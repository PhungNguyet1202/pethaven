<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function momoPayment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = 'MOMOTESTPARTNERCODE';  // Thay bằng mã của bạn
        $accessKey = 'MOMOTESTACCESSKEY';      // Thay bằng mã của bạn
        $secretKey = 'MOMOTESTSECRETKEY';      // Thay bằng mã của bạn
        $orderId = time();
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "10000";  // Số tiền cần thanh toán
        $redirectUrl = route('payment.momo.return');
        $ipnUrl = route('payment.momo.return');
        $extraData = "";

        // Tạo chữ ký (signature) với các tham số
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $orderId . "&requestType=captureWallet";
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $orderId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => 'captureWallet',
            'signature' => $signature
        ];

        // Gửi yêu cầu tới API MoMo
        $response = Http::post($endpoint, $data);
        $result = $response->json();

        if (isset($result['payUrl'])) {
            return redirect()->to($result['payUrl']);  // Chuyển hướng tới URL thanh toán của MoMo
        }

        return response()->json($result);
    }

    public function momoReturn(Request $request)
    {
        $partnerCode = 'MOMOTESTPARTNERCODE';
        $accessKey = 'MOMOTESTACCESSKEY';
        $secretKey = 'MOMOTESTSECRETKEY';

        $data = $request->all();

        // Xác thực chữ ký từ MoMo
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $data['amount'] . "&extraData=" . $data['extraData'] . "&message=" . $data['message'] . "&orderId=" . $data['orderId'] . "&orderInfo=" . $data['orderInfo'] . "&orderType=" . $data['orderType'] . "&partnerCode=" . $data['partnerCode'] . "&payType=" . $data['payType'] . "&requestId=" . $data['requestId'] . "&responseTime=" . $data['responseTime'] . "&resultCode=" . $data['resultCode'] . "&transId=" . $data['transId'];
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        if ($signature == $data['signature'] && $data['resultCode'] == '0') {
            // Xử lý đơn hàng thành công
            return redirect()->route('your-success-route')->with('message', 'Thanh toán thành công!');
        }

        // Xử lý đơn hàng thất bại
        return redirect()->route('your-failure-route')->with('message', 'Thanh toán thất bại.');
    }
}