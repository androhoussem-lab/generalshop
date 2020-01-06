<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::with('category','images')->paginate(16);

        return view('admin.products.products')->with([
            'products' => $products
        ]);
    }
}
