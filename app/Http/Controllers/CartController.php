<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // Lấy tất cả sản phẩm trong giỏ hàng của người dùng
    public function getCart()
    {   
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();
        Log::info('User ID: ' . $userId);

        $cartItems = CartItem::with('product')
            ->whereHas('shoppingcart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->get();

        Log::info('Cart Items: ', $cartItems->toArray());

        return response()->json([
            'status' => 'success',
            'cart' => $cartItems
        ]);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
{
    $userId = Auth::id(); // Lấy ID người dùng hiện tại
    $productId = $request->input('product_id');
    $quantity = $request->input('quantity', 1); // Mặc định là 1 nếu không truyền

    // Kiểm tra sản phẩm có tồn tại hay không
    $product = Product::find($productId);
    if (!$product) {
        return response()->json(['status' => 'error', 'message' => 'Product not found'], 404);
    }

    // Tìm giỏ hàng của người dùng hoặc tạo mới nếu chưa có
    $shoppingCart = ShoppingCart::firstOrCreate(['user_id' => $userId]);

    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    $cartItem = CartItem::where('shoppingcart_id', $shoppingCart->id)
                        ->where('product_id', $productId)
                        ->first();

    if ($cartItem) {
        // Nếu sản phẩm đã tồn tại, cập nhật số lượng và tổng giá
        $cartItem->quantity += $quantity;
        $cartItem->total_price = $cartItem->quantity * $product->price;
        $cartItem->save();
    } else {
        // Nếu chưa có, tạo mới mục giỏ hàng
        CartItem::create([
            'shoppingcart_id' => $shoppingCart->id,
            'product_id' => $productId,
            'quantity' => $quantity,
            'price' => $product->price,
            'total_price' => $quantity * $product->price
        ]);
    }

    return response()->json(['status' => 'success', 'message' => 'Product added to cart']);
}


    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request, $cartItemId)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();
        $cartItem = CartItem::whereHas('shoppingcart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('id', $cartItemId)->first();
        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Cart item not found'], 404);
        }

        $quantity = $request->input('quantity');
        if ($quantity > 0) {
            $cartItem->quantity = $quantity;
            $cartItem->total_price = $quantity * $cartItem->price;
            $cartItem->save();

            return response()->json(['status' => 'success', 'message' => 'Cart updated']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Quantity must be greater than zero'], 400);
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($cartItemId)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();
        $cartItem = CartItem::whereHas('shoppingcart', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->where('id', $cartItemId)->first();

        if (!$cartItem) {
            return response()->json(['status' => 'error', 'message' => 'Cart item not found'], 404);
        }

        $cartItem->delete();
        return response()->json(['status' => 'success', 'message' => 'Product removed from cart']);
    }
}