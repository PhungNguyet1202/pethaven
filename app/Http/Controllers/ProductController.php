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


    //     //return response()->json($dsSP);
    //     return view('product.product', compact(['products']));



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
    // public function product(Request $request)
    // {
    //     $request->validate([
    //         'search' => 'nullable|string|max:255',
    //         'perPage' => 'nullable|integer|min:1',
    //         'page' => 'nullable|integer|min:1',
    //         'min_price' => 'nullable|numeric|min:0',
    //         'max_price' => 'nullable|numeric|min:0',
    //         'sort' => 'nullable|string|in:name_asc,name_desc,price_asc,price_desc',
    //         'category_id' => 'nullable|integer',
    //     ]);

    //     $search = $request->input('search');
    //     $minPrice = $request->input('min_price');
    //     $maxPrice = $request->input('max_price');
    //     $sort = $request->input('sort');
    //     $categoryId = $request->input('category_id');
    //     $productId = $request->input('product_id');
    //     $perPage = $request->input('perPage', 9); // 9 sản phẩm trên 1 trang
    //     $page = $request->input('page', 1);

    //     // Thiết lập truy vấn chỉ với sản phẩm và danh mục
    //     $query = Product::with('category')->withSum('inventories', 'quantity_instock');

    //     if ($search) {
    //         Log::info('Search Query', ['search_term' => $search]);
    //         $query->where(function($q) use ($search) {
    //             $q->whereRaw('LOWER(name) LIKE ?', ["%".strtolower($search)."%"]);
    //         });
    //     }

    //     if ($categoryId) {
    //         $query->where('category_id', $categoryId);
    //     }

    //     if ($productId) {
    //         $query->where('id', '<>', $productId);
    //     }

    //     if ($minPrice) {
    //         $query->where('price', '>=', $minPrice);
    //     }

    //     if ($maxPrice) {
    //         $query->where('price', '<=', $maxPrice);
    //     }

    //     if ($sort) {
    //         switch ($sort) {
    //             case 'name_asc':
    //                 $query->orderBy('name', 'asc');
    //                 break;
    //             case 'name_desc':
    //                 $query->orderBy('name', 'desc');
    //                 break;
    //             case 'price_asc':
    //                 $query->orderBy('price', 'asc');
    //                 break;
    //             case 'price_desc':
    //                 $query->orderBy('price', 'desc');
    //                 break;
    //         }
    //     }

    //     // Lấy kết quả phân trang
    //     $products = $query->paginate($perPage, ['*'], 'page', $page);

    //     return response()->json([
    //         'status' => 'success',
    //         'data' => $products // Kết quả từ paginate() bao gồm cả thông tin phân trang
    //     ], 200);
    // }

    public function product(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:255',
            'perPage' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'sort' => 'nullable|string|in:name_asc,name_desc,price_asc,price_desc',
            'category_id' => 'nullable|integer',
        ]);

        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort');
        $categoryId = $request->input('category_id');
        $productId = $request->input('product_id');
        $perPage = $request->input('perPage', 9); // 9 sản phẩm trên 1 trang
        $page = $request->input('page', 1);

        // Thiết lập truy vấn chỉ với sản phẩm và danh mục
        $query = Product::with('category')->withSum('inventories', 'quantity_instock');

        if ($search) {
            Log::info('Search Query', ['search_term' => $search]);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ["%".strtolower($search)."%"]);
            });
        }

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($productId) {
            $query->where('id', '<>', $productId);
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

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

        // Lấy kết quả phân trang
        $products = $query->paginate($perPage, ['*'], 'page', $page);

        // Định dạng lại dữ liệu để bao gồm 'stock_quantity'
        $formattedProducts = $products->getCollection()->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'code' => $product->code,
                'category_id' => $product->category_id,
                'category_name' => $product->category ? $product->category->name : null,
                'stock_quantity' => $product->inventories_sum_quantity_instock ?? 0, // Tổng số lượng tồn kho
            ];
        });

        // Cập nhật lại tổng số trang cho response
        $products->setCollection($formattedProducts);

        return response()->json([
            'status' => 'success',
            'data' => $products // Kết quả từ paginate() bao gồm cả thông tin phân trang
        ], 200);
    }



    public function getRelatedProducts(Request $request, $category_id)
    {
        $product = Product::find($category_id);  // kiểm tra lại find() hoặc findOrFail()

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '<>', $category_id)
            ->take(4)
            ->get();

        return response()->json($relatedProducts, 200);
    }




//san pham moi theo id
public function getNewProducts(Request $request)
{
    $perPage = $request->input('perPage', 10); // Số lượng sản phẩm mặc định: 10

    $products = Product::orderBy('id', 'desc')->paginate($perPage);

    return response()->json([
        'status' => 'success',
        'message' => 'Danh sách sản phẩm mới',
        'data' => $products->items(),
        'pagination' => [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ],
    ]);
}

// san pham hot theo rating
public function getHotProducts(Request $request)
{
    $perPage = $request->input('perPage', 10); // Số lượng sản phẩm mặc định: 10

    $products = Product::orderBy('rating', 'desc')->paginate($perPage);

    return response()->json([
        'status' => 'success',
        'message' => 'Danh sách sản phẩm hot',
        'data' => $products->items(),
        'pagination' => [
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage(),
        ],
    ]);
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
    // }


    public function productsByCategory($categorySlug)
    {
        // Fetch the category by slug
        $category = Category::where('slug', $categorySlug)->first();

        // Kiểm tra nếu danh mục tồn tại
        if ($category) {
            // Lấy sản phẩm theo category_id và phân trang, cùng với tổng số lượng tồn kho
            $products = Product::where('category_id', $category->id)
                ->withSum('inventories', 'quantity_instock') // Lấy tổng tồn kho
                ->paginate(6);

            // Định dạng lại dữ liệu để bao gồm stock_quantity
            $formattedProducts = $products->getCollection()->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'image' => $product->image,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'code' => $product->code,
                    'stock_quantity' => $product->inventories_sum_quantity_instock ?? 0, // Tổng số lượng tồn kho
                ];
            });

            // Cập nhật lại tổng số trang cho response
            $products->setCollection($formattedProducts);

            // Trả về dữ liệu JSON
            return response()->json([
                'status' => 'success',
                'category' => $category->name,
                'products' => $products
            ], 200);
        } else {
            // Trả về thông báo lỗi nếu danh mục không tìm thấy
            return response()->json([
                'status' => 'error',
                'message' => 'Category not found'
            ], 404);
        }
    }

    public function detail($id)
{
    // Tìm sản phẩm theo id và lấy tổng số lượng tồn kho
    $product = Product::withSum('inventories', 'quantity_instock')->find($id);

    // Kiểm tra nếu sản phẩm tồn tại
    if ($product) {
        // Trả về chi tiết sản phẩm dưới dạng JSON, bao gồm description và tổng số lượng tồn kho
        return response()->json([
            'status' => 'success',
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'code' => $product->code,
                'description' => $product->description,  // Thêm description vào đây
                'stock_quantity' => $product->inventories_sum_quantity_instock ?? 0, // Tổng số lượng tồn kho
            ]
        ], 200);
    } else {
        // Trả về thông báo lỗi nếu không tìm thấy sản phẩm
        return response()->json([
            'status' => 'error',
            'message' => 'Product not found'
        ], 404);
    }
}


  }



