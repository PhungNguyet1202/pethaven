<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Tạo đơn hàng từ giỏ hàng
    public function createOrder(Request $request)
    {
        $userId = Auth::id(); // ID người dùng

        // Lấy giỏ hàng của người dùng
        $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
                                $query->where('user_id', $userId);
                            })->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
        }

        // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
        DB::beginTransaction();

        try {
            // Tính tổng giá trị đơn hàng
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->total_price;
            }

            // Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => $userId,
                'total' => $total,
                'status' => 'pending'
            ]);

            // Thêm các sản phẩm vào bảng `order_items`
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total_price' => $item->total_price
                ]);
            }

            // Xóa giỏ hàng sau khi tạo đơn hàng
            CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

            // Commit giao dịch
            DB::commit();

            return response()->json(['status' => 'success', 'message' => 'Order created', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            // Rollback nếu có lỗi
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Failed to create order'], 500);
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