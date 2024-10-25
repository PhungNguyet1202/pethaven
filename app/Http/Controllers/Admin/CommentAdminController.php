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

class CommentAdminController extends Controller
{
    public function comment()
    {
        $dsCM = Comment::paginate(10);
        return response()->json($dsCM, 200);
    }

    public function service()
    {
        $dsService = Service::paginate(10); // Note: Ensure the correct model name here
        return response()->json($dsService, 200);
    }

    public function productAdd(Request $request)
    {
        $dsCT = Category::get();
        return response()->json($dsCT, 200);
    }

}