<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProductController extends Controller
{
    // public function product(Request $request){
    //     //  $dsSP = Product::limit(6)->get();
    //     //  return view('product.product',compact(['dsSP']));
    //     //  return view('product.product');
    //     $perPage = $request->input('per_page', 6); // mặc định 6 sản phẩm 1 trang
    //     $products= Product::paginate($perPage); // sử dụng get nếu ko muốn phan trang
        
        
    //     if ($request->wantsJson()) {
    //         return response()->json($products); //tả về json
    //     }
    
    //     //tả về trang sp
    //     return view('product.product', compact('products'));
         
    //   } // chưa trả về json


    // load sp
    // public function product(Request $request)
    // {
    //     // Get search query and pagination parameters
    //     $search = $request->input('search');
    //     $perPage = $request->input('perPage', 9); // Default to 10 items per page
    //     $page = $request->input('page', 1);
    
    //     // Build the query
    //     $query = Product::with('category')
    //                     ->withSum('stockIns', 'Quantity');
    
    //     // Apply search filter
    //     if ($search) {
    //         $query->where('name', 'like', "%{$search}%")
    //               ->orWhere('code', 'like', "%{$search}%"); // Assuming product has 'code'
    //     }
        
    //     // Get paginated results
    //     $products = $query->paginate($perPage, ['*'], 'page', $page);
    
    //     return response()->json($products, 200);
    // }
    public function product(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'search' => 'nullable|string|max:255',
            'perPage' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort' => 'nullable|string|in:name_asc,name_desc,price_asc,price_desc',
        ]);
    
        // Get search parameters and pagination settings
        $search = $request->input('search');
        $perPage = $request->input('perPage', 9);
        $page = $request->input('page', 1);
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort');
    
        // Build the query
        $query = Product::with('category')->withSum('stockIns', 'Quantity');
    
        // Apply search filter (case insensitive)
        Log::info('Product method accessed', ['search' => $search]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%".strtolower($search)."%"])
                  ->orWhereRaw('LOWER(code) LIKE ?', ["%".strtolower($search)."%"]);
            });
        }
    
        // Debug SQL query
        Log::info('SQL Query: ' . $query->toSql(), $query->getBindings());
    
        // Apply price filters
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
    
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }
    
        // Apply sorting
        if ($sort) {
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }
    
        // Get paginated results
        $products = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Return results as JSON
        return response()->json($products, 200);
    }
    
    
    
    

//     public function product(Request $request)
// {
//     // Lấy từ khóa tìm kiếm và các tham số phân trang
//     $search = $request->input('search');
//     $perPage = $request->input('perPage', 9); // Số sản phẩm mỗi trang, mặc định là 9
//     $page = $request->input('page', 1);

//     // Xây dựng truy vấn
//     $query = Product::with('category')  // Nếu sản phẩm có quan hệ với category
//                     ->withSum('stockIns', 'Quantity');  // Nếu bạn có quan hệ stockIns

//     // Áp dụng bộ lọc tìm kiếm
//     if ($search) {
//         $query->where('name', 'like', "%{$search}%")
//               ->orWhere('code', 'like', "%{$search}%");  // Giả sử sản phẩm có mã code
//     }

//     // Lấy kết quả phân trang
//     $products = $query->paginate($perPage, ['*'], 'page', $page);

//     // Trả về dữ liệu dưới dạng JSON
//     return response()->json($products, 200);
// }


    //   public function detail($slug) {
      
    //     $sp = Product::where('slug', $slug)->first();
    
    //    //kiểm tra sp tồn tại ko
    //     if ($sp) {
    //        // chuyển sang trang chi tiết
    //         return view('product.detail', compact('sp'));
    //     } else {
    //        // Chuyển hướng hoặc hiển thị trang 404 nếu không tìm thấy sản phẩm
    //         return redirect()->route('home')->with('error', 'Product not found');
    //     }

//     public function detail($slug)
// {
//     $sp = Product::where('slug', $slug)->first();
    
//     // ktra sp
//     if ($sp) {
//         // trả sp dưới dạng json
//         if (request()->wantsJson()) {
//             return response()->json($sp);
//         }

//         // trả về trang ctsp
//         return view('product.detail', compact('sp'));
//     } else {
//        // nếu ko thấy sp thì chuyển sang trang notfound
//         if (request()->wantsJson()) {
//             return response()->json(['error' => 'Product not found'], 404);
//         }

//         return redirect()->route('home')->with('error', 'Product not found');
//     }
// }
public function detail($id) {
    // Tìm sản phẩm theo id và ném lỗi nếu không tìm thấy
    $sp = Product::findOrFail($id);

    // Trả về dữ liệu sản phẩm dưới dạng JSON
    return response()->json($sp);
}
    

    // public function productsByCategory($categorySlug) {
    //     // Fetch the category by slug
    //     $category = Category::where('slug', $categorySlug)->first();
    
    //     // If the category exists, fetch its products
    //     if ($category) {
    //         $products = Product::where('category_id', $category->id)->paginate(6); // Correct the category ID
    //         return view('product.product', compact('products', 'category'));
    //     } else {
    //         // If the category does not exist, redirect to home with an error
    //         return redirect()->route('home')->with('error', 'Category not found');
    //     }
    // }
    public function productsByCategory($categorySlug) {
        // Fetch the category by slug
        $category = Category::where('slug', $categorySlug)->first();
    
        // If the category exists, fetch its products
        if ($category) {
            // Fetch products related to the category
            $products = Product::where('category_id', $category->id)->paginate(6);
    
            // Return the products and category as JSON
            return response()->json([
                'status' => 'success',
                'category' => $category,
                'products' => $products->items(),  // Get paginated items
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                ]
            ]);
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
