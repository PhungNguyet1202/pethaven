<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
class CheckoutController extends Controller
{
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
 
    public function momo_payment($order)
    {
        Log::info('Starting MoMo payment process for Order ID: ' . $order->id);
    
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOBKUN20180529';

            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua mã QR MoMo";
        $amount = (string) $order->total_money;
        $orderId = (string) $order->id;
        $redirectUrl = "http://localhost:3000/Order";   
        $ipnUrl = "http://localhost:3000/";
        $extraData = "";        
    
        // Tạo chuỗi hash
        $requestId = time() . "";
        $requestType = "captureWallet";
    
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
        Log::info('Generated signature for payment request', [
            'signature' => $signature,
            'rawHash' => $rawHash
        ]);
    
        // Dữ liệu gửi đi
        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            "storeId" => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];
    
        // Gọi MoMo API
        try {
            Log::info('Sending payment request to MoMo API', ['data' => $data]);
            $result = $this->execPostRequest($endpoint, json_encode($data));
            Log::info('Received response from MoMo API', ['result' => $result]);
    
            $jsonResult = json_decode($result, true);
    
            if (isset($jsonResult['payUrl'])) {
                Log::info('MoMo payment QR code created successfully', ['payUrl' => $jsonResult['payUrl']]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'Tạo mã QR thanh toán MoMo thành công',
                    'order_id' => $order->id,
                    'payUrl' => $jsonResult['payUrl']
                ]);
            } else {
                Log::error('MoMo API response error', ['response' => $jsonResult]);
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể tạo mã QR thanh toán MoMo'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('MoMo API request failed', [
                'error_message' => $e->getMessage(),
                'order_id' => $order->id
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi khi gửi yêu cầu thanh toán MoMo'
            ], 500);
        }
    }
    public function createOrder(Request $request)
    {
        Log::info('Received request in createOrder:', $request->all());
    
        $userId = $request->input('user_id');
        if (!$userId) {
            return response()->json(['status' => 'error', 'message' => 'Thiếu user_id trong request.'], 400);
        }
    
        $validatedData = $request->validate([
            'user_fullname' => 'required|string',
            'total_money' => 'required|numeric',
            'user_address' => 'required|string',
            'user_phone' => 'required|string',
            'user_email' => 'required|email',
            'payment_id' => 'required|integer|exists:payments,id',
            'shipping_id' => 'required|integer',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric',
            'items.*.total_price' => 'required|numeric',
        ]);
    
        DB::beginTransaction();
    
        try {
            $orderItems = [];
    
            foreach ($validatedData['items'] as $item) {
                // Xử lý logic kho hàng
                $inventoryEntries = Inventory::where('product_id', $item['product_id'])
                    ->where('quantity_instock', '>', 0)
                    ->orderBy('created_at')
                    ->get();
    
                $remainingQuantity = $item['quantity'];
                foreach ($inventoryEntries as $entry) {
                    if ($entry->quantity_instock >= $remainingQuantity) {
                        $entry->quantity_instock -= $remainingQuantity;
                        $entry->save();
                        $remainingQuantity = 0;
                        break;
                    } else {
                        $remainingQuantity -= $entry->quantity_instock;
                        $entry->quantity_instock = 0;
                        $entry->save();
                    }
                }
    
                if ($remainingQuantity > 0) {
                    DB::rollBack();
                    return response()->json(['status' => 'error', 'message' => "Sản phẩm không đủ hàng trong kho"], 400);
                }
    
                $orderItems[] = [
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total_price' => $item['total_price'],
                ];
            }
    
            // Tạo dữ liệu đơn hàng
            $orderData = [
                'user_id' => $userId,
                'total_money' => $validatedData['total_money'],
                'status' => 'pending',
                'payment_id' => $validatedData['payment_id'],
                'shipping_id' => $validatedData['shipping_id'],
                'user_fullname' => $validatedData['user_fullname'],
                'user_address' => $validatedData['user_address'],
                'user_phone' => $validatedData['user_phone'],
                'user_email' => $validatedData['user_email'],
            ];
    
            $order = Order::create($orderData);
    
            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderDetail::create($item);
            }
    
            DB::commit();
    
            // Nếu thanh toán qua MoMo, gọi hàm checkout MoMo và trả về thông tin
            if ($validatedData['payment_id'] === 1) {
                return $this->momo_payment($order);
            }
    
            return response()->json([
                'status' => 'success',
                'message' => 'Tạo đơn hàng thành công',
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
        }
    }
    
    public function checkTransactionStatus(Request $request)
    {
        try {
            $id = $request->input('id');
            $accessKey = 'klm05TvNBzhg7h7j';
            $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
            // Generate raw signature
            $rawSignature = "accesskey=" . $accessKey.
                "&orderId=" .   $secretKey .
                "&partnerCode=MOMO" .
                "&requestId=" . $id;

            // Generate HMAC SHA256 signature
            $signature = hash_hmac('sha256', $rawSignature, env('MOMO_SECRETKEY'));

            // Prepare request payload
            $requestBody = [
                "partner" => "MOMO",
                "requestId" => $id,
                "signature" => $signature,
                "lang" => "vi"
            ];

            // Send POST request to MoMo API
            $momoResponse = Http::withHeaders([
                "Content-Type" => "application/json"
            ])->post("https://test-payment.momo.vn/v2/gateway/query", $requestBody);

            if ($momoResponse->successful()) {
                $responseData = $momoResponse->json();

                // Update order status
                $orderResponse = Http::put("http://localhost:8000/admin/ordes/update/" . $id, [
                    "data" => [
                        "status" => $responseData['resultCode']==0 ?'pending':'cancle'
                    ]
                ]);
                Log::error('dữ liệu: ' . $orderResponse->getMessage());
                if ($orderResponse->successful()) {
                    return response()->json($responseData, 200);
                } else {
                    return response()->json(['error' => 'Failed to update order status'], 500);
                }
            }

            return response()->json(['error' => 'Failed to query MoMo API'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}