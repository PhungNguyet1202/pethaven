<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Models\Order;
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

class StockInAdminController extends Controller
{
    public function stockin(Request $request)
    {
        // Lấy thông tin tìm kiếm và phân trang từ request
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // Mặc định là 10 bản ghi trên mỗi trang
        $page = $request->input('page', 1);
    
        // Tạo truy vấn cơ bản cho Stockin
        $query = Stockin::with(['products']); // Giả sử có quan hệ với bảng product
    
        // Áp dụng tìm kiếm nếu có từ khóa tìm kiếm
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('stockin_date', 'like', "%{$search}%") ;// Tìm theo ngày nhập kho
                
                 
            });
        }
    
        // Lấy kết quả phân trang
        $stockEntries = $query->paginate($perPage, ['*'], 'page', $page);
    
        // Định dạng lại dữ liệu trả về với tên sản phẩm
        $formattedEntries = $stockEntries->getCollection()->map(function ($entry) {
            return [
                'id' => $entry->id,
                'product_id' => $entry->product_id,
                'stockin_date' => $entry->stockin_date,
                'quantity' => $entry->Quantity,
                'created_at' => $entry->created_at,
                'updated_at' => $entry->updated_at,
                'product_name' => $entry->products ? $entry->products->name : null, // Lấy tên sản phẩm
            ];
        });
    
        // Trả về kết quả dưới dạng JSON
        return response()->json([
            'data' => $formattedEntries,
            'current_page' => $stockEntries->currentPage(),
            'last_page' => $stockEntries->lastPage(),
            'per_page' => $stockEntries->perPage(),
            'total' => $stockEntries->total(),
        ], 200);
    }
    public function getProducts()
{
    try {
        // Lấy tất cả sản phẩm từ database
        $products = Product::all();

        return response()->json([
            'status' => 'success',
            'products' => $products,
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to retrieve products.',
            'error' => $e->getMessage(),
        ], 500);
    }
}
 
public function gettStockinById($id)
{
    $stockin = Stockin::with('products')->find($id);
    
    if (!$stockin) {
        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

  

    $stockinData = [
        'id' => $stockin->id,
        'quantity' => $stockin->Quantity,
   
        'stockin_date' =>$stockin->stockin_date, // URL đầy đủ cho hình ảnh
        'productName' => $stockin->products ? $stockin->products->name : null,
        'productId' => $stockin->products ? $stockin->products->id : null,
 
    ];

    return response()->json($stockinData, 200);
}
public function postStockEntry(Request $request)
{
    try {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'stockin_date' => 'required|date',
        ]);

        // Lưu thông tin nhập kho vào bảng stockin
        $stockinEntry = new StockIn([
            'product_id' => $validatedData['productId'], // Sử dụng productId từ validatedData
            'Quantity' => $validatedData['quantity'], // Kiểm tra tên trường trong bảng
            'created_at' => now(),
            'stockin_date' => $validatedData['stockin_date'],
        ]);
        $stockinEntry->save();

        // Lưu thông tin nhập kho vào bảng inventory
        $inventoryEntry = new Inventory([
            'product_id' => $validatedData['productId'], // Sử dụng productId từ validatedData
            'quantity_instock' => $validatedData['quantity'], // Kiểm tra tên trường trong bảng
            'created_at' => now(),
            'stockin_id' => $stockinEntry->id, // Lưu id nhập kho vào cột stockin_id
        ]);
        $inventoryEntry->save();

        // Cập nhật số lượng tồn kho trong bảng sản phẩm
        $product = Product::find($validatedData['productId']); // Sử dụng productId
        if ($product) {
            $product->instock += $validatedData['quantity']; // Cập nhật số lượng tồn kho
            $product->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Stock entry added successfully.'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to add stock entry.', 'error' => $e->getMessage()], 500);
    }
}

public function updateStockEntry(Request $request, $id)
{
    try {
        // Xác thực dữ liệu
        $validatedData = $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'stockin_date' => 'required|date',
        ]);

        // Tìm mục nhập kho theo stock_in_id
        $stockinEntry = StockIn::find($id);
        if (!$stockinEntry) {
            return response()->json(['status' => 'error', 'message' => 'Stock entry not found'], 404);
        }

        // Lưu lại số lượng cũ để điều chỉnh tồn kho
        $oldQuantity = $stockinEntry->Quantity;

        // Cập nhật thông tin nhập kho trong bảng stockin
        $stockinEntry->product_id = $validatedData['productId'];
        $stockinEntry->Quantity = $validatedData['quantity'];
        $stockinEntry->stockin_date = $validatedData['stockin_date'];
        $stockinEntry->updated_at = now();
        $stockinEntry->save();

        // Cập nhật hoặc tạo mới mục nhập trong bảng inventory
        $inventoryEntry = Inventory::where('stockin_id', $stockinEntry->id)->first();
        if ($inventoryEntry) {
            // Cập nhật tồn kho nếu đã tồn tại
            $inventoryEntry->quantity_instock = $validatedData['quantity'];
            $inventoryEntry->updated_at = now();
            $inventoryEntry->save();
        } else {
            // Nếu không có mục nhập trong bảng inventory, tạo mới
            $inventoryEntry = new Inventory([
                'product_id' => $validatedData['productId'],
                'quantity_instock' => $validatedData['quantity'],
                'created_at' => now(),
                'updated_at' => now(),
                'stockin_id' => $stockinEntry->id,
            ]);
            $inventoryEntry->save();
        }

        // Cập nhật số lượng tồn kho trong bảng sản phẩm
        $product = Product::find($validatedData['productId']);
        if ($product) {
            // Cập nhật tồn kho
            $product->instock = $product->instock - $oldQuantity + $validatedData['quantity'];
            $product->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Stock entry updated successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to update stock entry', 'error' => $e->getMessage()], 500);
    }
}

public function deleteStockEntry($id)
{
    try {
        // Tìm mục nhập trong bảng stockin theo ID
        $stockinEntry = StockIn::find($id);
        if (!$stockinEntry) {
            return response()->json(['status' => 'error', 'message' => 'Stock entry not found'], 404);
        }

        // Lấy thông tin sản phẩm và số lượng đã nhập
        $productId = $stockinEntry->product_id;
        $quantity = $stockinEntry->Quantity;

        // Xóa mục nhập tương ứng trong bảng inventory
        Inventory::where('stockin_id', $stockinEntry->id)->delete();

        // Xóa mục nhập trong bảng stockin
        $stockinEntry->delete();

        // Cập nhật số lượng tồn kho trong bảng sản phẩm
        $product = Product::find($productId);
        if ($product) {
            $product->instock -= $quantity; // Trừ đi số lượng đã nhập
            $product->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Stock entry deleted successfully'], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'error', 'message' => 'Failed to delete stock entry', 'error' => $e->getMessage()], 500);
    }
}


}