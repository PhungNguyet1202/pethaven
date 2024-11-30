<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\servicebooking;
use App\Models\Stockin;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Pet;
use App\Models\Service;
use App\Models\inventory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderAdminController extends Controller
{
    public function orders(Request $request)
{
    // Lấy thông tin tìm kiếm và phân trang từ request
    $search = $request->input('search');
    $fromDate = $request->input('from_date');
    $toDate = $request->input('to_date');
    $perPage = $request->input('perPage', 10); // Mặc định 10 đơn hàng trên mỗi trang
    $page = $request->input('page', 1);

    // Tạo truy vấn với các mối quan hệ
    $query = Order::with(['user', 'payments', 'shippings']); // Đảm bảo rằng các mối quan hệ được định nghĩa đúng

    // Áp dụng tìm kiếm nếu có
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('id', 'like', "%{$search}%");
        });
    }

    // Lọc theo ngày nếu có
    if ($fromDate) {
        $query->where('created_at', '>=', $fromDate);
    }

    if ($toDate) {
        $query->where('created_at', '<=', $toDate);
    }

    // Lấy kết quả phân trang
    $orders = $query->paginate($perPage, ['*'], 'page', $page);

    // Định dạng lại dữ liệu để bao gồm chi tiết người dùng, phương thức thanh toán, và vận chuyển
    $formattedOrders = $orders->getCollection()->map(function ($order) {
        return [
            'id' => $order->id,
            'user_fullname' => $order->user->name ?? null,
            'user_email' => $order->user->email ?? null,
            'user_phone' => $order->user->phone ?? null,
            'total_money' => $order->total_money,
            'total_quantity' => $order->total_quantity,
            'status' => $order->status,
            'payment_method' => $order->payments->payment_method ?? null,
            'shipping_method' => $order->shippings->shipping_method ?? null,
            'created_at' => $order->created_at,
        ];
    });

    // Cập nhật lại tổng số trang cho response
    $orders->setCollection($formattedOrders);

    return response()->json($orders, 200);
}

    // Lấy chi tiết đơn hàng dựa trên order_id
    public function orderDetail($order_id)
    {
        // Tìm đơn hàng theo id và lấy kèm thông tin chi tiết đơn hàng, thanh toán, và vận chuyển
        $order = Order::with(['orderDetails.product', 'payments', 'shippings'])->find($order_id);
    
        // Nếu không tìm thấy đơn hàng
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
    
        // Định dạng lại chi tiết đơn hàng
        $formattedOrder = [
            'id' => $order->id,
            'user_fullname' => $order->user_fullname,
            'user_email' => $order->user_email,
            'user_phone' => $order->user_phone,
            'total_money' => $order->total_money,
            'total_quantity' => $order->total_quantity,
            'status' => $order->status,
            'payment_method' => $order->payments ? $order->payments->payment_method : null,
            'shipping_method' => $order->shippings ? $order->shippings->shipping_method : null,
            'order_details' => $order->orderDetails->map(function ($detail) {
                return [
                    'product_id' => $detail->product_id,
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'price' => $detail->price,
                    'total_price' => $detail->price * $detail->quantity,
                ];
            }),
            'created_at' => $order->created_at,
        ];
    
        return response()->json($formattedOrder, 200);
    }
    // public function updateOrderStatus(Request $request, $id)
    // {
    //     // Xác thực dữ liệu cho trạng thái đơn hàng
    //     $validatedData = $request->validate([
    //         'status' => 'required|string|in:pending,prepare,shipping,success,cancle' // Trạng thái phải là một trong các giá trị hợp lệ
    //     ]);
    
    //     // Tìm đơn hàng theo ID
    //     $order = Order::find($id);
    //     if (!$order) {
    //         return response()->json(['message' => 'Order not found'], 404); // Trả về 404 nếu không tìm thấy đơn hàng
    //     }
    
    //     // Cập nhật giá trị của status
    //     $order->status = $validatedData['status'];
    //     if ( $order->status='cancel'){
        
    //     }

    //     // Lưu thay đổi
    //     $order->save();
    //     // Trả về phản hồi thành công kèm theo dữ liệu đơn hàng
    //     return response()->json([
    //         'message' => 'Order status updated successfully',
    //         'order' => $order
    //     ], 200); // Trả về mã HTTP 200 cho yêu cầu thành công
    // }
   
    public function updateOrderStatus(Request $request, $id)
    {
        // Xác thực dữ liệu cho trạng thái đơn hàng
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,prepare,shipping,success,cancle,return' // Trạng thái phải là một trong các giá trị hợp lệ
        ]);
    
        // Tìm đơn hàng theo ID
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404); // Trả về 404 nếu không tìm thấy đơn hàng
        }
    
        // Cập nhật giá trị của status
        $order->status = $validatedData['status'];
    
        // Nếu status là 'cancel', cập nhật lại số lượng sản phẩm trong Inventory
        if ($order->status === 'cancle' || $order->status === 'return') {
            // Lấy danh sách chi tiết đơn hàng của order
            $orderDetails = $order->orderDetails;
    
            foreach ($orderDetails as $detail) {
                $productId = $detail->product_id;
                $quantity = $detail->quantity;
    
                // Tìm bản ghi inventory của sản phẩm theo ngày tạo cũ nhất
                $inventory = Inventory::where('product_id', $productId)
                                      ->orderBy('created_at', 'asc')
                                      ->first();
    
                if ($inventory) {
                    // Cộng dồn số lượng vào inventory
                    $inventory->quantity_instock += $quantity;
                    $inventory->save();
                }
            }
        }
    
        // Lưu thay đổi trạng thái đơn hàng
        $order->save();
    
        // Trả về phản hồi thành công kèm theo dữ liệu đơn hàng
        return response()->json([
            'message' => 'Order status updated successfully',
            'order' => $order
        ], 200); // Trả về mã HTTP 200 cho yêu cầu thành công
    }
    
}