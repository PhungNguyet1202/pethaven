<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\Stockin;
use App\Models\Category;
use App\Models\CategoryNew;

use App\Models\Pet;
use App\Models\Service;
use Illuminate\Support\Str;

class UserAdminController extends Controller
{
 
    public function user()
    {
        $dsUS = User::paginate(10);
        return response()->json($dsUS, 200);
    }


}