<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product(){
         $dsSP = Product::limit(6)->get();
         return view('product.product',compact(['dsSP']));
        //  return view('product.product');
         
      }
}