<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home(){
        // $dsSP = Product::limit(8)->get();
         // return view('page.home',compact(['dsSP']));
         return view('page.home');
      }
}