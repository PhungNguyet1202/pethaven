<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Thêm dòng này
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\inventory;  // Thêm dòng này nếu Inventory là model
use App\Http\Controllers\CheckoutController;

class OrderController extends Controller
{
    //     public function createOrder(Request $request)
    //     {
    //         Log::info('Received request in createOrder:', $request->all());

    //         $userId = $request->input('user_id');
    //         if (!$userId) {
    //             return response()->json(['status' => 'error', 'message' => 'Thiếu user_id trong request.'], 400);
    //         }

    //         $validatedData = $request->validate([
    //             'user_fullname' => 'required|string',
    //             'total_money' => 'required|numeric',
    //             'user_address' => 'required|string',
    //             'user_phone' => 'required|string',
    //             'user_email' => 'required|email',
    //             'payment_id' => 'required|integer|exists:payments,id',
    //             'shipping_id' => 'required|integer',
    //             'items.*.product_id' => 'required|exists:products,id',
    //             'items.*.quantity' => 'required|integer|min:1',
    //             'items.*.price' => 'required|numeric',
    //             'items.*.total_price' => 'required|numeric',
    //         ]);

    //         // Nếu `payment_id` là 1, gọi API MoMo để tạo mã QR thanh toán trước khi tạo đơn hàng
    //         if ($validatedData['payment_id'] === 1) {
    //             $checkoutController = new CheckoutController();
    //             $request->merge(['amount' => $validatedData['total_money']]);
    //             Log::info('Amount after merging:', ['amount' => $request->input('amount')]);
    //             $response = $checkoutController->momo_payment($request);
    //             $paymentData = json_decode($response->getContent(), true);

    //             if (!isset($paymentData['success']) || !$paymentData['success']) {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'Không thể tạo mã QR thanh toán MoMo'
    //                 ], 500);
    //             }
    //         }

    //         DB::beginTransaction();

    //         try {
    //             $orderItems = [];

    //             foreach ($validatedData['items'] as $item) {
    //                 $inventoryEntries = Inventory::where('product_id', $item['product_id'])
    //                     ->where('quantity_instock', '>', 0)
    //                     ->orderBy('created_at')
    //                     ->get();

    //                 $remainingQuantity = $item['quantity'];
    //                 foreach ($inventoryEntries as $entry) {
    //                     if ($entry->quantity_instock >= $remainingQuantity) {
    //                         $entry->quantity_instock -= $remainingQuantity;
    //                         $entry->save();
    //                         $remainingQuantity = 0;
    //                         break;
    //                     } else {
    //                         $remainingQuantity -= $entry->quantity_instock;
    //                         $entry->quantity_instock = 0;
    //                         $entry->save();
    //                     }
    //                 }

    //                 if ($remainingQuantity > 0) {
    //                     DB::rollBack();
    //                     return response()->json(['status' => 'error', 'message' => "Sản phẩm không đủ hàng trong kho"], 400);
    //                 }

    //                 $orderItems[] = [
    //                     'product_id' => $item['product_id'],
    //                     'quantity' => $item['quantity'],
    //                     'price' => $item['price'],
    //                     'total_price' => $item['total_price'],
    //                 ];
    //             }

    //             // Tạo dữ liệu đơn hàng
    //             $orderData = [
    //                 'user_id' => $userId,
    //                 'total_money' => $validatedData['total_money'],
    //                 'status' => 'pending',
    //                 'payment_id' => $validatedData['payment_id'],
    //                 'shipping_id' => $validatedData['shipping_id'],
    //                 'user_fullname' => $validatedData['user_fullname'],
    //                 'user_address' => $validatedData['user_address'],
    //                 'user_phone' => $validatedData['user_phone'],
    //                 'user_email' => $validatedData['user_email'],
    //             ];

    //             $order = Order::create($orderData);

    //             foreach ($orderItems as $item) {
    //                 $item['order_id'] = $order->id;
    //                 OrderDetail::create($item);
    //             }

    //         DB::commit();

    //         // Trả về URL thanh toán MoMo nếu thành công
    //         if ($validatedData['payment_id'] === 1) {
    //             return response()->json([
    //                 'status' => 'success',
    //                 'message' => 'Tạo đơn hàng thành công',
    //                 'order_id' => $order->id,
    //                 'momo_url' => $paymentData['payUrl']
    //             ]);
    //         }

    //         // Trả về phản hồi nếu không sử dụng thanh toán MoMo
    //         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
    //         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
    //     }
    // }

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
            'items.*.name' => 'required|string',
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
                    'name' => $item['name'],
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

    // Lấy danh sách đơn hàng của người dùng
    public function getOrders()
    {
        $userId = Auth::id();
        $orders = Order::where('user_id', $userId)->with('orderItems.product')->get();

        return response()->json([
            'status' => 'success',
            'orders' => $orders
        ]);
    }

    // Lấy chi tiết đơn hàng
    public function getOrderDetail($orderId)
    {
        $userId = Auth::id();
        $order = Order::where('user_id', $userId)->with('orderItems.product')->findOrFail($orderId);

        return response()->json([
            'status' => 'success',
            'order' => $order
        ]);
    }
}
