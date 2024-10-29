<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    public function product(Request $request){
        //  $dsSP = Product::limit(6)->get();
        //  return view('product.product',compact(['dsSP']));
        //  return view('product.product');
        $perPage = $request->input('per_page', 6); // mặc định 6 sản phẩm 1 trang
        $products= Product::paginate($perPage); // sử dụng get nếu ko muốn phan trang
        
        
        //return response()->json($dsSP);
        return view('product.product', compact(['products']));
         
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

        // Kiểm tra nếu danh mục tồn tại
        if ($category) {
            $products = Product::where('category_id', $category->id)->paginate(6); // Correct the category ID
            return view('product.product', compact('products', 'category'));
        } else {
            // Return an error message if the category is not found
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }
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
