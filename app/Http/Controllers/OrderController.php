<?php

namespace App\Http\Controllers;

// namespace App\Http\Controllers;
// use Illuminate\Http\Request;


use Illuminate\Http\Request;
    namespace App\Http\Controllers;


use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\inventory;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    // Tạo đơn hàng từ giỏ hàng
    // public function createOrder(Request $request)
    // {
    //     $userId = Auth::id(); // ID người dùng

    //     // Lấy giỏ hàng của người dùng
    //     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
    //                             $query->where('user_id', $userId);
    //                         })->get();

    //     if ($cartItems->isEmpty()) {
    //         return response()->json(['status' => 'error', 'message' => 'Cart is empty'], 400);
    //     }

    //     // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
    //     DB::beginTransaction();

    //     try {
    //         // Tính tổng giá trị đơn hàng
    //         $total = 0;
    //         foreach ($cartItems as $item) {
    //             $total += $item->total_price;
    //         }

    //         // Tạo đơn hàng mới
    //         $order = Order::create([
    //             'user_id' => $userId,
    //             'total' => $total,
    //             'status' => 'pending'
    //         ]);

    //         // Thêm các sản phẩm vào bảng `order_items`
    //         foreach ($cartItems as $item) {
    //            OrderItem::create([
    //                 'order_id' => $order->id,
    //                 'product_id' => $item->product_id,
    //                 'quantity' => $item->quantity,
    //                 'price' => $item->price,
    //                 'total_price' => $item->total_price
    //             ]);
    //         }

    //         // Xóa giỏ hàng sau khi tạo đơn hàng
    //         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

    //         // Commit giao dịch
    //         DB::commit();

    //         return response()->json(['status' => 'success', 'message' => 'Order created', 'order_id' => $order->id]);

    //     } catch (\Exception $e) {
    //         // Rollback nếu có lỗi
    //         DB::rollBack();
    //         return response()->json(['status' => 'error', 'message' => 'Failed to create order'], 500);
    //     }
    // }

    // Lấy danh sách đơn hàng của người dùng
    // public function getOrders()
    // {
    //     $userId = Auth::id();
    //     $orders = Order::where('user_id', $userId)->with('orderItems.product')->get();

    //     return response()->json([
    //         'status' => 'success',
    //         'orders' => $orders
    //     ]);
    // }

    // Lấy chi tiết đơn hàng
    // public function getOrderDetail($orderId)
    // {
    //     $userId = Auth::id();
    //     $order = Order::where('user_id', $userId)->with('orderItems.product')->findOrFail($orderId);

    //     return response()->json([
    //         'status' => 'success',
    //         'order' => $order
    //     ]);
    // }


     // Tạo đơn hàng mới
    //  public function store(Request $request)
    //  {
    //      if ($request->user()) {
    //          // Người dùng đã đăng nhập
    //          $validatedData = $request->validate([
    //              'total_amount' => 'required|numeric',
    //              'status' => 'nullable|string',
    //              'products' => 'required|array',
    //              'products.*.name' => 'required|string|max:255',
    //              'products.*.price' => 'required|numeric',
    //              'products.*.quantity' => 'required|integer|min:1',
    //              'payment_method' => 'required|string|max:50',
    //              'user_fullname' => 'nullable|string|max:255', // Được phép là null
    //              'email' => 'nullable|email|max:255', // Trường email có thể nullable cho người dùng đã đăng nhập
    //          ]);
             
    //          // Gán user_fullname và email từ user nếu không có
    //          $validatedData['user_id'] = $request->user()->id;
    //          $validatedData['user_fullname'] = $validatedData['user_fullname'] ?? $request->user()->name;
    //          $validatedData['email'] = $validatedData['email'] ?? $request->user()->email; // Lấy email từ user
    //      } else {
    //          // Người dùng chưa đăng nhập
    //          $validatedData = $request->validate([
    //              'total_amount' => 'required|numeric',
    //              'status' => 'nullable|string',
    //              'products' => 'required|array',
    //              'products.*.name' => 'required|string|max:255',
    //              'products.*.price' => 'required|numeric',
    //              'products.*.quantity' => 'required|integer|min:1',
    //              'payment_method' => 'required|string|max:50',
    //              'user_fullname' => 'required|string|max:255', // Bắt buộc
    //              'name' => 'required|string|max:255',
    //              'address' => 'required|string|max:255',
    //              'phone' => 'required|string|max:15',
    //              'email' => 'required|email|max:255', // Bắt buộc cho người dùng chưa đăng nhập
    //          ]);
    //      }
     
    //      // Tính toán tổng số lượng và tổng tiền từ danh sách sản phẩm
    //      $totalQuantity = 0;
    //      $totalPrice = 0;
    //      foreach ($validatedData['products'] as $product) {
    //          $totalQuantity += $product['quantity'];
    //          $totalPrice += $product['price'] * $product['quantity'];
    //      }
     
    //      $validatedData['total_quantity'] = $totalQuantity;
    //      $validatedData['total_price'] = $totalPrice;
    //      $validatedData['products'] = json_encode($validatedData['products']);
     
    //      // Tạo đơn hàng với dữ liệu đã xác thực
    //      $order = Order::create($validatedData);
     
    //      return response()->json([
    //          'message' => 'Đơn hàng đã được tạo thành công',
    //          'order' => $order,
    //      ], 201);
    //  }
    // public function store(Request $request)
    // {
    //     // Xác thực dữ liệu
    //     $validatedData = $request->validate([
    //         'product_id' => 'required|integer|exists:products,id', // Kiểm tra ID sản phẩm
    //         'quantity' => 'required|integer|min:1',
    //         'payment_method' => 'required|string',
    //         // Thông tin người dùng nếu không đăng nhập
    //         'user_fullname' => 'required_if:guest,true|string',
    //         'user_address' => 'required_if:guest,true|string',
    //         'user_phone' => 'required_if:guest,true|string',
    //         'user_email' => 'required_if:guest,true|email',
    //     ]);

    //     // Kiểm tra người dùng đã đăng nhập chưa
    //     if (Auth::check()) {
    //         // Lấy thông tin người dùng từ đăng nhập
    //         $user = Auth::user();
    //         $orderData = [
    //             'user_id' => $user->id,
    //             'product_id' => $validatedData['product_id'],
    //             'quantity' => $validatedData['quantity'],
    //             'payment_method' => $validatedData['payment_method'],
    //         ];
    //     } else {
    //         // Nếu chưa đăng nhập, lấy thông tin từ request
    //         $orderData = [
    //             'user_fullname' => $validatedData['user_fullname'],
    //             'user_address' => $validatedData['user_address'],
    //             'user_phone' => $validatedData['user_phone'],
    //             'user_email' => $validatedData['user_email'],
    //             'product_id' => $validatedData['product_id'],
    //             'quantity' => $validatedData['quantity'],
    //             'payment_method' => $validatedData['payment_method'],
    //         ];
    //     }

    //     // Tạo đơn hàng
    //     $order = Order::create($orderData);

    //     return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    // }
    // public function store(Request $request)
    // {
    //     // Xác thực dữ liệu
    //     $validatedData = $request->validate([
    //         'product_id' => 'required|integer|exists:products,id',
    //         'total_quantity' => 'required|integer|min:1',
    //         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery',
    //         // Thông tin người dùng nếu không đăng nhập
    //         'user_fullname' => 'required_if:guest,true|string',
    //         'user_address' => 'required_if:guest,true|string',
    //         'user_phone' => 'required_if:guest,true|string',
    //         'user_email' => 'required_if:guest,true|email',
    //     ]);
    
    //     // Lấy thông tin sản phẩm
    //     $product = Product::findOrFail($validatedData['product_id']);
    //     $orderData = [
    //         'product_id' => $validatedData['product_id'],
    //         'total_quantity' => $validatedData['total_quantity'],
    //         'payment_id' => $validatedData['payment_id'],
    //         'total_money' => $product->price * $validatedData['total_quantity'], // Tính tổng tiền
    //     ];
    
    //     // Kiểm tra người dùng đã đăng nhập chưa
    //     if (Auth::check()) {
    //         // Nếu đã đăng nhập
    //         $user = Auth::user();
    //         $orderData['user_id'] = $user->id; // Thêm user_id vào mảng dữ liệu
    //     } else {
    //         // Nếu chưa đăng nhập, không thêm user_id vào mảng dữ liệu
    //         $orderData['user_fullname'] = $validatedData['user_fullname'];
    //         $orderData['user_address'] = $validatedData['user_address'];
    //         $orderData['user_phone'] = $validatedData['user_phone'];
    //         $orderData['user_email'] = $validatedData['user_email'];
    //         // Không thêm 'user_id' vào $orderData
    //     }
    
    //     // Tạo đơn hàng
    //     $order = Order::create($orderData);
    
    //     return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
    // }

    //đã post được dữ liệu
//     public function store(Request $request)
// {
//     // Xác thực dữ liệu
//     $validatedData = $request->validate([
//         'product_id' => 'required|integer|exists:products,id',
//         'total_quantity' => 'required|integer|min:1',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery', // Đảm bảo payment_id hợp lệ
//         // Thông tin người dùng nếu không đăng nhập
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//     ]);

//     // Lấy thông tin sản phẩm
//     $product = Product::findOrFail($validatedData['product_id']);
//     $orderData = [
//         'product_id' => $validatedData['product_id'],
//         'total_quantity' => $validatedData['total_quantity'],
//         'payment_id' => $validatedData['payment_id'], // Lưu giá trị payment_id
//         'total_money' => $product->price * $validatedData['total_quantity'], // Tính tổng tiền
//     ];

//     // Kiểm tra người dùng đã đăng nhập chưa
//     if (Auth::check()) {
//         // Nếu đã đăng nhập
//         $user = Auth::user();
//         $orderData['user_id'] = $user->id; // Thêm user_id vào mảng dữ liệu
//     } else {
//         // Nếu chưa đăng nhập, không thêm user_id vào mảng dữ liệu
//         $orderData['user_fullname'] = $validatedData['user_fullname'];
//         $orderData['user_address'] = $validatedData['user_address'];
//         $orderData['user_phone'] = $validatedData['user_phone'];
//         $orderData['user_email'] = $validatedData['user_email'];
//         // Không thêm 'user_id' vào $orderData
//     }

//     // Tạo đơn hàng
//     $order = Order::create($orderData);

//     return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
// }
//

//order rồi
// public function store(Request $request)
// {
//     // Xác thực dữ liệu
//     $validatedData = $request->validate([
//         'product_id' => 'required|integer|exists:products,id',
//         'total_quantity' => 'required|integer|min:1',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//     ]);

//     // Tìm sản phẩm
//     $product = Product::findOrFail($validatedData['product_id']);

//     // Kiểm tra nếu hàng trong kho không đủ, cập nhật thêm hàng nếu cần
//     if ($product->inventory < $validatedData['total_quantity']) {
//         // Thêm số lượng để đảm bảo hàng trong kho đủ để đặt hàng
//         $requiredQuantity = $validatedData['total_quantity'] - $product->inventory;
//         $product->inventory += $requiredQuantity;
//         $product->save();
//     }

//     // Tạo dữ liệu đơn hàng
//     $orderData = [
//         'product_id' => $validatedData['product_id'],
//         'total_quantity' => $validatedData['total_quantity'],
//         'payment_id' => $validatedData['payment_id'],
//         'total_money' => $product->price * $validatedData['total_quantity'],
//     ];

//     // Kiểm tra nếu người dùng đã đăng nhập
//     if (Auth::check()) {
//         $user = Auth::user();
//         $orderData['user_id'] = $user->id;
//     } else {
//         // Thêm thông tin người dùng nếu không đăng nhập
//         $orderData['user_fullname'] = $validatedData['user_fullname'];
//         $orderData['user_address'] = $validatedData['user_address'];
//         $orderData['user_phone'] = $validatedData['user_phone'];
//         $orderData['user_email'] = $validatedData['user_email'];
//     }

//     // Tạo đơn hàng
//     $order = Order::create($orderData);

//     // Giảm số lượng sản phẩm trong kho
//     $product->inventory -= $validatedData['total_quantity'];
//     $product->save();

//     return response()->json(['message' => 'Đơn hàng tạo thành công', 'order' => $order], 201);
// }

//order theo giỏ hàng
// public function createOrder(Request $request)
// {
//     Log::info($request->all());
//     Log::info('Received order request:', $request->all());

//     $userId = Auth::id(); // Lấy ID người dùng nếu đã đăng nhập

//     // Lấy các mục trong giỏ hàng của người dùng
//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//                             $query->where('user_id', $userId);
//                         })->with('product')->get();

//     // Kiểm tra nếu giỏ hàng trống
//     if ($cartItems->isEmpty()) {
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     // Xác thực thông tin người dùng khách nếu chưa đăng nhập
//    // $validatedData = $request->validate([
//         // 'user_fullname' => 'required_if:guest,true|string',
//         // 'user_address' => 'required_if:guest,true|string',
//         // 'user_phone' => 'required_if:guest,true|string',
//         // 'user_email' => 'required_if:guest,true|email',
//         // 'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//         $validatedData = $request->validate([
//             'guest' => 'required|boolean', // Bắt buộc trường guest
//             'user_fullname' => 'required_if:guest,true|string',
//             'user_address' => 'required_if:guest,true|string',
//             'user_phone' => 'required_if:guest,true|string',
//             'user_email' => 'required_if:guest,true|email',
//             'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//         ]);
        
//    // ]);

//     DB::beginTransaction(); // Bắt đầu một giao dịch để đảm bảo tính toàn vẹn dữ liệu

//     try {
//         $total = 0;

//         // Tính tổng giá trị và kiểm tra kho cho từng sản phẩm trong giỏ hàng
//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             // Lấy danh sách các đợt nhập kho cho sản phẩm này (FIFO: đợt nhập cũ nhất trước)
//             $inventoryEntries = inventory::where('product_id', $product->id)
//                                               ->where('quantity_instock', '>', 0)
//                                               ->orderBy('created_at')
//                                               ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity >= $remainingQuantity) {
//                     $entry->quantity -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity;
//                     $entry->quantity = 0;
//                     $entry->save();
//                 }
//             }

//             // Nếu vẫn còn lượng cần mà kho không đủ, rollback ngay lập tức
//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Tính tổng giá trị của giỏ hàng
//             $total += $item->price * $item->quantity;
//         }

//         // Tạo mảng dữ liệu đơn hàng
//         $orderData = [
//             'user_id' => $userId,
//             'total' => $total,
//             'status' => 'pending',
//             'payment_id' => $validatedData['payment_id']
//         ];

//         if (!$userId) { // Thêm thông tin khách nếu chưa đăng nhập
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         // Tạo đơn hàng
//         $order = Order::create($orderData);

//         // Xử lý từng sản phẩm trong giỏ, thêm vào bảng order_items
//         foreach ($cartItems as $item) {
//             OrderItem::create([
//                 'order_id' => $order->id,
//                 'product_id' => $item->product_id,
//                 'quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->price * $item->quantity
//             ]);
//         }

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng'], 500);
//     }
// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());
//     Log::info('Received order request:', $request->all());

//     $userId = Auth::id(); // Lấy ID người dùng nếu đã đăng nhập

//     // Lấy các mục trong giỏ hàng của người dùng
//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//                             $query->where('user_id', $userId);
//                         })->with('product')->get();

//     // Kiểm tra nếu giỏ hàng trống
//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     // Xác thực thông tin người dùng khách nếu chưa đăng nhập
//     $validatedData = $request->validate([
//         'guest' => 'required|boolean', // Bắt buộc trường guest
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//     ]);

//     DB::beginTransaction(); // Bắt đầu một giao dịch để đảm bảo tính toàn vẹn dữ liệu

//     try {
//         $total = 0;

//         // Tính tổng giá trị và kiểm tra kho cho từng sản phẩm trong giỏ hàng
//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             // Kiểm tra nếu sản phẩm không tồn tại
//             if (!$product) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Lấy danh sách các đợt nhập kho cho sản phẩm này (FIFO: đợt nhập cũ nhất trước)
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                                           ->where('quantity_instock', '>', 0)
//                                           ->orderBy('created_at')
//                                           ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity >= $remainingQuantity) {
//                     $entry->quantity -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity;
//                     $entry->quantity = 0;
//                     $entry->save();
//                 }
//             }

//             // Nếu vẫn còn lượng cần mà kho không đủ, rollback ngay lập tức
//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Tính tổng giá trị của giỏ hàng
//             $total += $item->price * $item->quantity;
//         }

//         // Tạo mảng dữ liệu đơn hàng
//         $orderData = [
//             'user_id' => $userId,
//             'total' => $total,
//             'status' => 'pending',
//             'payment_id' => $validatedData['payment_id']
//         ];

//         if (!$userId) { // Thêm thông tin khách nếu chưa đăng nhập
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         // Tạo đơn hàng
//         $order = Order::create($orderData);

//         // Xử lý từng sản phẩm trong giỏ, thêm vào bảng order_items
//         foreach ($cartItems as $item) {
//             CartItem::create([
//                 'order_id' => $order->id,
//                 'product_id' => $item->product_id,
//                 'quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->price * $item->quantity
//             ]);
//         }

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Error creating order: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng'], 500);
//     }
// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());

//     // Lấy ID người dùng nếu đã đăng nhập
//     $userId = Auth::id();

//     // Lấy các mục trong giỏ hàng của người dùng
//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//         $query->where('user_id', $userId);
//     })->with('product')->get();

//     // Kiểm tra nếu giỏ hàng trống
//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     // Xác thực thông tin người dùng khách nếu chưa đăng nhập
//     $validatedData = $request->validate([
//         'guest' => 'required|boolean',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//     ]);

//     DB::beginTransaction(); // Bắt đầu một giao dịch

//     try {
//         $total = 0;

//         // Tính tổng giá trị và kiểm tra kho cho từng sản phẩm trong giỏ hàng
//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             // Kiểm tra nếu sản phẩm không tồn tại
//             if (!$product) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Lấy danh sách các đợt nhập kho cho sản phẩm này (FIFO: đợt nhập cũ nhất trước)
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                                           ->where('quantity_instock', '>', 0)
//                                           ->orderBy('created_at')
//                                           ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity_instock >= $remainingQuantity) {
//                     $entry->quantity_instock -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity_instock;
//                     $entry->quantity_instock = 0;
//                     $entry->save();
//                 }
//             }

//             // Nếu vẫn còn lượng cần mà kho không đủ, rollback ngay lập tức
//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Tính tổng giá trị của giỏ hàng
//             $total += $item->total_price; // Sử dụng total_price từ CartItem
//         }

//         // Tạo mảng dữ liệu đơn hàng
//         $orderData = [
//             'user_id' => $userId,
//             'total' => $total,
//             'status' => 'pending',
//             'payment_id' => $validatedData['payment_id'],
//             'user_fullname' => $userId ? null : $validatedData['user_fullname'] ?? '', // Đảm bảo có giá trị cho user_fullname
//             'user_address' => $userId ? null : $validatedData['user_address'] ?? '',
//             'user_phone' => $userId ? null : $validatedData['user_phone'] ?? '',
//             'user_email' => $userId ? null : $validatedData['user_email'] ?? '',
//         ];

//         // Tạo đơn hàng
//         $order = Order::create($orderData);

//         // Xử lý từng sản phẩm trong giỏ, thêm vào bảng order_items
//         foreach ($cartItems as $item) {
//             OrderItem::create([
//                 'order_id' => $order->id,
//                 'product_id' => $item->product_id,
//                 'quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->total_price
//             ]);
//         }

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Error creating order: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
//     }
// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());

//     // Lấy ID người dùng nếu đã đăng nhập
//     $userId = Auth::id();

//     // Lấy các mục trong giỏ hàng của người dùng
//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//         $query->where('user_id', $userId);
//     })->with('product')->get();

//     // Kiểm tra nếu giỏ hàng trống
//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     // Xác thực thông tin người dùng khách nếu chưa đăng nhập
//     $validatedData = $request->validate([
//         'guest' => 'required|boolean',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//     ]);

//     DB::beginTransaction(); // Bắt đầu một giao dịch

//     try {
//         $total = 0;

//         // Tính tổng giá trị và kiểm tra kho cho từng sản phẩm trong giỏ hàng
//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             // Kiểm tra nếu sản phẩm không tồn tại
//             if (!$product) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Lấy danh sách các đợt nhập kho cho sản phẩm này (FIFO: đợt nhập cũ nhất trước)
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                                           ->where('quantity_instock', '>', 0)
//                                           ->orderBy('created_at')
//                                           ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity_instock >= $remainingQuantity) {
//                     $entry->quantity_instock -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity_instock;
//                     $entry->quantity_instock = 0;
//                     $entry->save();
//                 }
//             }

//             // Nếu vẫn còn lượng cần mà kho không đủ, rollback ngay lập tức
//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Tính tổng giá trị của giỏ hàng
//             $total += $item->total_price; // Sử dụng total_price từ CartItem
//         }

//         // Tạo mảng dữ liệu đơn hàng
//         $orderData = [
//             'user_id' => $userId,
//             'total' => $total,
//             'status' => 'pending',
//             'payment_id' => $validatedData['payment_id'],
//             // Không cần gán giá trị cho product_id ở đây
//         ];

//         // Thêm thông tin người dùng nếu chưa đăng nhập
//         if (!$userId) {
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         // Tạo đơn hàng
//         $order = Order::create($orderData);

//         // Xử lý từng sản phẩm trong giỏ, thêm vào bảng order_items
//         foreach ($cartItems as $item) {
//             OrderItem::create([
//                 'order_id' => $order->id,
//                 'product_id' => $item->product_id,
//                 'quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->total_price
//             ]);
//         }

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Error creating order: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
//     }
// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());
    
//     $userId = Auth::id(); // Lấy ID người dùng nếu đã đăng nhập

//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//         $query->where('user_id', $userId);
//     })->with('product')->get();

//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     $validatedData = $request->validate([
//         'guest' => 'required|boolean',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//     ]);

//     DB::beginTransaction(); // Bắt đầu giao dịch

//     try {
//         $total = 0;
//         $orderItems = []; // Mảng lưu trữ thông tin sản phẩm trong đơn hàng

//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             if (!$product) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Kiểm tra tồn kho
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                                           ->where('quantity_instock', '>', 0)
//                                           ->orderBy('created_at')
//                                           ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity >= $remainingQuantity) {
//                     $entry->quantity -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity;
//                     $entry->quantity = 0;
//                     $entry->save();
//                 }
//             }

//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Cộng dồn tổng giá trị
//             $total += $item->total_price; // Sử dụng total_price từ CartItem

//             // Thêm thông tin sản phẩm vào mảng orderItems
//             $orderItems[] = [
//                 'product_id' => $item->product_id,
//                 'quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->total_price,
//             ];
//         }

//         // Tạo mảng dữ liệu đơn hàng
//         $orderData = [
//             'user_id' => $userId,
//             'total' => $total,
//             'status' => 'pending',
//             'payment_id' => $validatedData['payment_id'],
//             'order_items' => json_encode($orderItems), // Lưu trữ thông tin sản phẩm dưới dạng JSON
//         ];

//         if (!$userId) {
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         // Tạo đơn hàng
//         $order = Order::create($orderData);

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Error creating order: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
//     }
// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());
    
//     $userId = Auth::id(); // Lấy ID người dùng nếu đã đăng nhập

//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//         $query->where('user_id', $userId);
//     })->with('product')->get();

//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     $validatedData = $request->validate([
//         'guest' => 'required|boolean',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery'
//     ]);

//     DB::beginTransaction(); // Bắt đầu giao dịch

//     try {
//         $total = 0;
//         $orderItems = []; // Mảng lưu trữ thông tin sản phẩm trong đơn hàng

//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             if (!$product) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Kiểm tra tồn kho
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                                           ->where('quantity_instock', '>', 0)
//                                           ->orderBy('created_at')
//                                           ->get();

//             $remainingQuantity = $item->quantity;

//             // foreach ($inventoryEntries as $entry) {
//             //     if ($entry->quantity >= $remainingQuantity) {
//             //         $entry->quantity -= $remainingQuantity;
//             //         $entry->save();
//             //         $remainingQuantity = 0;
//             //         break;
//             //     } else {
//             //         $remainingQuantity -= $entry->quantity;
//             //         $entry->quantity = 0;
//             //         $entry->save();
//             //     }
//             // }
//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity_instock >= $remainingQuantity) { // Sử dụng quantity_instock thay vì quantity
//                     $entry->quantity_instock -= $remainingQuantity; // Cập nhật cột tồn kho
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity_instock; // Sử dụng quantity_instock
//                     $entry->quantity_instock = 0; // Cập nhật cột tồn kho
//                     $entry->save();
//                 }
//             }
            

//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Cộng dồn tổng giá trị
//             $total += $item->total_price; // Sử dụng total_price từ CartItem

//             // Thêm thông tin sản phẩm vào mảng orderItems
//             $orderItems[] = [
//                 'product_id' => $item->product_id,
//                 'total_quantity' => $item->quantity, // Đổi tên thành total_quantity
//                 'price' => $item->price,
//                 'total_price' => $item->total_price,
//             ];
//         }

//         // Tạo mảng dữ liệu đơn hàng
//         // $orderData = [
//         //     'user_id' => $userId,
//         //     'total' => $total,
//         //     'status' => 'pending',
//         //     'payment_id' => $validatedData['payment_id'],
//         //     'order_items' => json_encode($orderItems), // Lưu trữ thông tin sản phẩm dưới dạng JSON
//         // ];
//         // Tạo mảng dữ liệu đơn hàng
//   $orderData = [
//     'user_id' => $userId,
//     'total' => $total,
//     'status' => 'pending',
//     'payment_id' => $validatedData['payment_id'],
//     // Nếu bạn cần thêm thông tin sản phẩm vào đơn hàng
//     //'product_id' => $item->product_id // Đây là ví dụ, bạn có thể cần thay đổi
//      ];


//         if (!$userId) {
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         // Tạo đơn hàng
//         $order = Order::create($orderData);

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Error creating order: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
//     }

// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());
    
//     $userId = Auth::id(); // Lấy ID người dùng nếu đã đăng nhập

//     $cartItems = CartItem::whereHas('shoppingcart', function($query) use ($userId) {
//         $query->where('user_id', $userId);
//     })->with('product')->get();

//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     $validatedData = $request->validate([
//         'guest' => 'required|boolean',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery',
//         'shipping_id' => 'required|integer', // Validate shipping_id
//     ]);

//     DB::beginTransaction(); // Bắt đầu giao dịch

//     try {
//         $total = 0;
//         $totalQuantity = 0; // Khởi tạo biến tổng số lượng
//         $orderItems = []; // Mảng để lưu trữ thông tin sản phẩm trong đơn hàng

//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             if (!$product) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Kiểm tra tồn kho
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                                           ->where('quantity_instock', '>', 0)
//                                           ->orderBy('created_at')
//                                           ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity_instock >= $remainingQuantity) {
//                     $entry->quantity_instock -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity_instock;
//                     $entry->quantity_instock = 0;
//                     $entry->save();
//                 }
//             }

//             if ($remainingQuantity > 0) {
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Cộng dồn tổng giá trị và tổng số lượng
//             $total += $item->total_price;
//             $totalQuantity += $item->quantity;

//             // Thêm thông tin sản phẩm vào mảng orderItems
//             $orderItems[] = [
//                 'product_id' => $item->product_id,
//                 'total_quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->total_price,
//             ];
//         }

//         // // Tạo đơn hàng
//         // $orderData = [
//         //     'user_id' => $userId,
//         //     'total_money' => $total,
//         //     'total_quantity' => $totalQuantity, // Thêm tổng số lượng
//         //     'status' => 'pending',
//         //     'payment_id' => $validatedData['payment_id'], // Lấy payment_id từ validatedData
//         //     'shipping_id' => $validatedData['shipping_id'], // Lấy shipping_id từ validatedData
//         // ];
//         // Tạo đơn hàng
//           $orderData = [
//          'user_id' => $userId,
//          'total_money' => $total,
//          'total_quantity' => $totalQuantity,
//          'status' => 'pending',
//          'payment_id' => $validatedData['payment_id'],
//          'shipping_id' => $validatedData['shipping_id'],
//          ];


//         if (!$userId) {
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         $order = Order::create($orderData);

//         // Chèn thông tin sản phẩm vào bảng orderdetail
//         foreach ($orderItems as $item) {
//             $item['order_id'] = $order->id; // Thiết lập ID đơn hàng
//             $item['quantity'] = $item['total_quantity']; // Thêm quantity vào dữ liệu

//             OrderDetail::create($item); // Chèn vào bảng orderdetail
//         }

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
//     }
// }
// public function createOrder(Request $request)
// {
//     Log::info($request->all());

//     $userId = Auth::id(); // Lấy ID người dùng nếu đã đăng nhập

//     // Lấy các sản phẩm trong giỏ hàng của người dùng
//     $cartItems = CartItem::whereHas('shoppingcart', function ($query) use ($userId) {
//         $query->where('user_id', $userId);
//     })->with('product')->get();

//     if ($cartItems->isEmpty()) {
//         Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
//         return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
//     }

//     // Validate request
//     $validatedData = $request->validate([
//         'guest' => 'required|boolean',
//         'user_fullname' => 'required_if:guest,true|string',
//         'user_address' => 'required_if:guest,true|string',
//         'user_phone' => 'required_if:guest,true|string',
//         'user_email' => 'required_if:guest,true|email',
//         'payment_id' => 'required|string|in:Credit Card,Cash on Delivery',
//         'shipping_id' => 'required|integer',
//     ]);

//     DB::beginTransaction(); // Bắt đầu giao dịch

//     try {
//         $total = 0;
//         $totalQuantity = 0;
//         $orderItems = [];

//         foreach ($cartItems as $item) {
//             $product = $item->product;

//             if (!$product) {
//                 Log::error('Sản phẩm không tồn tại: ' . json_encode($item));
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
//             }

//             // Kiểm tra tồn kho
//             $inventoryEntries = Inventory::where('product_id', $product->id)
//                 ->where('quantity_instock', '>', 0)
//                 ->orderBy('created_at')
//                 ->get();

//             $remainingQuantity = $item->quantity;

//             foreach ($inventoryEntries as $entry) {
//                 if ($entry->quantity_instock >= $remainingQuantity) {
//                     $entry->quantity_instock -= $remainingQuantity;
//                     $entry->save();
//                     $remainingQuantity = 0;
//                     break;
//                 } else {
//                     $remainingQuantity -= $entry->quantity_instock;
//                     $entry->quantity_instock = 0;
//                     $entry->save();
//                 }
//             }

//             if ($remainingQuantity > 0) {
//                 Log::error("Sản phẩm: {$product->name} không đủ hàng trong kho");
//                 DB::rollBack();
//                 return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
//             }

//             // Cộng dồn tổng giá trị và tổng số lượng
//             $total += $item->total_price;
//             $totalQuantity += $item->quantity;

//             // Thêm thông tin sản phẩm vào mảng orderItems
//             $orderItems[] = [
//                 'product_id' => $item->product_id,
//                 'total_quantity' => $item->quantity,
//                 'price' => $item->price,
//                 'total_price' => $item->total_price,
//             ];
//         }

//         // Tạo đơn hàng
//         $orderData = [
//             'user_id' => $userId,
//             'total_money' => $total,
//             'total_quantity' => $totalQuantity,
//             'status' => 'pending',
//             'payment_id' => $validatedData['payment_id'],
//             'shipping_id' => $validatedData['shipping_id'],
//         ];

//         // Nếu người dùng là khách, thêm thông tin của họ
//         if (!$userId) {
//             $orderData['user_fullname'] = $validatedData['user_fullname'];
//             $orderData['user_address'] = $validatedData['user_address'];
//             $orderData['user_phone'] = $validatedData['user_phone'];
//             $orderData['user_email'] = $validatedData['user_email'];
//         }

//         // Ghi log dữ liệu đơn hàng
//         Log::info('Order data: ', $orderData);

//         $order = Order::create($orderData); // Tạo đơn hàng

//         // Chèn thông tin sản phẩm vào bảng orderdetail
//         foreach ($orderItems as $item) {
//             $item['order_id'] = $order->id; // Thiết lập ID đơn hàng
//             OrderDetail::create($item); // Chèn vào bảng orderdetail
//         }

//         // Xóa giỏ hàng của người dùng
//         CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

//         DB::commit(); // Commit giao dịch

//         return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

//     } catch (\Exception $e) {
//         DB::rollBack(); // Rollback nếu có lỗi
//         Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
//         return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
//     }
// }

public function createOrder(Request $request)
{
    // Log toàn bộ request để debug
    Log::info('Received request:', $request->all());

    // Lấy user_id từ request
    $userId = $request->input('user_id');

    // Kiểm tra nếu user_id không tồn tại
    if (!$userId) {
        return response()->json(['status' => 'error', 'message' => 'Thiếu user_id trong request.'], 400);
    }

    // Lấy các sản phẩm trong giỏ hàng của người dùng
    $cartItems = CartItem::whereHas('shoppingcart', function ($query) use ($userId) {
        $query->where('user_id', $userId);
    })->with('product')->get();

    if ($cartItems->isEmpty()) {
        Log::warning('Giỏ hàng trống cho user_id: ' . $userId);
        return response()->json(['status' => 'error', 'message' => 'Giỏ hàng trống'], 400);
    }

    // Validate request
    $validatedData = $request->validate([
        'guest' => 'required|boolean',
        'user_fullname' => 'required_if:guest,true|string',
        'user_address' => 'required_if:guest,true|string',
        'user_phone' => 'required_if:guest,true|string',
        'user_email' => 'required_if:guest,true|email',
        'payment_id' => 'required|integer|exists:payments,id',
        'shipping_id' => 'required|integer',
    ]);

    DB::beginTransaction(); // Bắt đầu giao dịch

    try {
        $total = 0;
        $totalQuantity = 0;
        $orderItems = [];

        foreach ($cartItems as $item) {
            $product = $item->product;

            if (!$product) {
                Log::error('Sản phẩm không tồn tại: ' . json_encode($item));
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => 'Sản phẩm không tồn tại'], 404);
            }

            // Kiểm tra tồn kho
            $inventoryEntries = Inventory::where('product_id', $product->id)
                ->where('quantity_instock', '>', 0)
                ->orderBy('created_at')
                ->get();

            $remainingQuantity = $item->quantity;

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
                Log::error("Sản phẩm: {$product->name} không đủ hàng trong kho");
                DB::rollBack();
                return response()->json(['status' => 'error', 'message' => "Sản phẩm: {$product->name} không đủ hàng trong kho"], 400);
            }

            // Cộng dồn tổng giá trị và tổng số lượng
            $total += $item->total_price;
            $totalQuantity += $item->quantity;

            // Thêm thông tin sản phẩm vào mảng orderItems
            $orderItems[] = [
                'product_id' => $item->product_id,
                'total_quantity' => $item->quantity,
                'price' => $item->price,
                'total_price' => $item->total_price,
                'quantity' => $item->quantity,  // Thêm quantity vào dữ liệu orderdetail
            ];
        }

        // Tạo đơn hàng
        $orderData = [
            'user_id' => $userId,
            'total_money' => $total,
            'total_quantity' => $totalQuantity,
            'status' => 'pending',
            'payment_id' => $validatedData['payment_id'],
            'shipping_id' => $validatedData['shipping_id'],
        ];

        // Nếu người dùng là khách, thêm thông tin của họ
        if ($validatedData['guest']) {
            $orderData['user_fullname'] = $validatedData['user_fullname'];
            $orderData['user_address'] = $validatedData['user_address'];
            $orderData['user_phone'] = $validatedData['user_phone'];
            $orderData['user_email'] = $validatedData['user_email'];
        }

        // Ghi log dữ liệu đơn hàng
        Log::info('Order data: ', $orderData);

        $order = Order::create($orderData); // Tạo đơn hàng

        // Chèn thông tin sản phẩm vào bảng orderdetail
        foreach ($orderItems as $item) {
            $item['order_id'] = $order->id; // Thiết lập ID đơn hàng
            OrderDetail::create($item); // Chèn vào bảng orderdetail
        }

        // Xóa giỏ hàng của người dùng
        CartItem::where('shoppingcart_id', $cartItems->first()->shoppingcart_id)->delete();

        DB::commit(); // Commit giao dịch

        return response()->json(['status' => 'success', 'message' => 'Tạo đơn hàng thành công', 'order_id' => $order->id]);

    } catch (\Exception $e) {
        DB::rollBack(); // Rollback nếu có lỗi
        Log::error('Lỗi khi tạo đơn hàng: ' . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Không thể tạo đơn hàng', 'error_detail' => $e->getMessage()], 500);
    }

}












  
     
 
    //  // Lấy thông tin đơn hàng theo ID
    //  public function show($id)
    //  {
    //      $order = Order::with('orderdetails')->findOrFail($id);
 
    //      return response()->json($order);
    //  }
 
    //  // Cập nhật đơn hàng (ví dụ: thay đổi trạng thái)
    //  public function update(Request $request, $id)
    //  {
    //      // Xác thực dữ liệu
    //      $request->validate([
    //          'status' => 'required|string|in:pending,completed,canceled', // Đảm bảo status hợp lệ
    //      ]);
     
    //      $order = Order::findOrFail($id); // Tìm đơn hàng theo ID
    //      $order->update($request->only('status')); // Cập nhật trạng thái
     
    //      return response()->json([
    //          'message' => 'Đơn hàng đã được cập nhật thành công',
    //          'order' => $order,
    //      ]);
    //  }
     
    //  // Xóa đơn hàng theo ID
    //  public function destroy($id)
    //  {
    //      $order = Order::findOrFail($id);
    //      $order->delete();
 
    //      return response()->json(['message' => 'Đơn hàng đã được xóa thành công']);
    //  }





    }


