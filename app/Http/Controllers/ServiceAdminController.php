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
use App\Models\News;
use App\Models\Pet;
use App\Models\Service;
use Illuminate\Support\Str;


class ServiceAdminController extends Controller
{
    public function service()
    {
        $dsService = Service::paginate(10); // Note: Ensure the correct model name here
        return response()->json($dsService, 200);
    }

}