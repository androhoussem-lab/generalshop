<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(){
        $products = Product::with('category','images')->paginate(env('PAGINATION_COUNT'));
        $currency = env('CURRENCY_CODE' , '$');
        return view('admin.products.products')->with([
            'products' => $products,
            'currency_code' => $currency
        ]);
    }
    public function newProduct($id = null){
        $product = null;
        $units = Unit::all();
        $categories = Category::all();
        if (! is_null($id)){
            $product = Product::with(['unit','category'])->find($id);

        }
        return view('admin.products.new_product')->with([
            'product' => $product,
            'units' => $units,
            'categories' => $categories
        ]);
    }
    public function store(Request $request){

    }
    public function delete($id, Request $request){

    }
    public function update(Request $request){
            dd($request);
    }
    public function search(Request $request){

    }

}
