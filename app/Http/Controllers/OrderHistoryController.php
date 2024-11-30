<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function getPendingOrders($user_id)
    {
        $orders = Order::where('status', 'pending')
                       ->where('user_id', $user_id)
                       ->get();
        return response()->json($orders);
    }

    public function getPrepareOrders($user_id)
    {
        $orders = Order::where('status', 'prepare')
                       ->where('user_id', $user_id)
                       ->get();
        return response()->json($orders);
    }

    public function getShippingOrders($user_id)
    {
        $orders = Order::where('status', 'shipping')
                       ->where('user_id', $user_id)
                       ->get();
        return response()->json($orders);
    }

    public function getSuccessOrders($user_id)
    {
        $orders = Order::where('status', 'success')
                       ->where('user_id', $user_id)
                       ->get();
        return response()->json($orders);
    }
    public function getReturnOrders($user_id)
    {
        $orders = Order::where('status', 'return')
                       ->where('user_id', $user_id)
                       ->get();
        return response()->json($orders);
    }

    public function getCanceledOrders($user_id)
    {
        $orders = Order::where('status', 'cancel')
                       ->where('user_id', $user_id)
                       ->get();
        return response()->json($orders);
    }
    public function cancelOrder($order_id)
    {
        // Tìm đơn hàng theo ID
        $order = Order::find($order_id);

        // Kiểm tra nếu đơn hàng không tồn tại
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Kiểm tra nếu trạng thái đơn hàng đã được hủy
        if ($order->status == 'cancel') {
            return response()->json(['message' => 'Order is already canceled'], 400);
        }

        // Cập nhật trạng thái đơn hàng thành 'cancel'
        $order->status = 'cancel';
        $order->save();

        return response()->json(['message' => 'Order has been canceled successfully', 'order' => $order]);
    }
    // API route để hoàn trả hàng


// Controller method
// Controller method
public function returnOrder($order_id)
{
    // Tìm đơn hàng theo ID
    $order = Order::find($order_id);

    // Kiểm tra xem đơn hàng có tồn tại không
    if (!$order) {
        return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
    }

    // Kiểm tra nếu đơn hàng đã được nhận quá 7 ngày
    $receivedDate = $order->created_at; // Giả sử `created_at` là ngày nhận hàng
    $currentDate = now(); // Lấy ngày hiện tại
    $daysDifference = $currentDate->diffInDays($receivedDate);

    if ($daysDifference > 7) {
        return response()->json(['error' => 'Không thể hoàn trả hàng sau 7 ngày'], 400);
    }

    // Cập nhật trạng thái đơn hàng thành 'prepare' nếu còn trong khoảng 7 ngày
    $order->status = 'return';
    $order->save();

    // Trả về thông tin đơn hàng đã được cập nhật
    return response()->json(['message' => 'Đơn hàng đã được hoàn trả và chuyển sang trạng thái "Chờ xác nhận".']);
}


}
