<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product(Request $request){
        //  $dsSP = Product::limit(6)->get();
        //  return view('product.product',compact(['dsSP']));
        //  return view('product.product');
        $perPage = $request->input('per_page', 6); // mặc định 6 sản phẩm 1 trang
        $dsSP = Product::paginate($perPage); // sử dụng get nếu ko muốn phan trang
        
        
        //return response()->json($dsSP);
        return view('product.product', compact(['dsSP']));
         
      }


      public function detail($slug) {
      
        $sp = Product::where('slug', $slug)->first();
    
       //kiểm tra sp tồn tại ko
        if ($sp) {
           // chuyển sang trang chi tiết
            return view('product.detail', compact('sp'));
        } else {
           // Chuyển hướng hoặc hiển thị trang 404 nếu không tìm thấy sản phẩm
            return redirect()->route('home')->with('error', 'Product not found');
        }
    }
    

    public function productsByCategory($categorySlug) {
      // Fetch the category by slug
      $category = Category::where('slug', $categorySlug)->first();
  
      // If the category exists, fetch its products
      if ($category) {
          $products = Product::where('category_id', $category->id)->paginate(6); // Paginate 6 products
  
          // Return a view displaying the products and category
          return view('product.products_by_category', compact('products', 'category'));
      } else {
          // If the category does not exist, redirect to home with an error
          return redirect()->route('home')->with('error', 'Category not found');
      }
  }
  
  
      // public function detail($slug){
      //   // $sp = Product::where('slug',$slug)->first();
      //   // return view('product.detail',compact(['sp']));
      //    // Fetch the product by slug
      //    $product = Product::where('slug', $slug)->first();

      //    // Check if the product exists
      //    if ($product) {
      //        // Return product details as a JSON response
      //        return response()->json([
      //            'status' => 'success',
      //            'product' => $product
      //        ], 200);
      //    } else {
      //        // Return an error response if the product is not found
      //        return response()->json([
      //            'status' => 'error',
      //            'message' => 'Product not found'
      //        ], 404);
      //    }
     
      // }
}
