<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\Stockin;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Support\Str;

class NewAdminController extends Controller
{
    public function categoryNew()
    {
        $dsCTN = CategoryNew::paginate(10);
        return response()->json($dsCTN, 200);
    }

    public function news()
    {
        $dsNew = News::with('categoryNew')->paginate(10);
        return response()->json($dsNew, 200);
    }

    public function pet()
    {
        $dsPet = Pet::paginate(10);
        return response()->json($dsPet, 200);
    }
    
}