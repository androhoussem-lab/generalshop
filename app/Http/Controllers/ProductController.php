<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request){
        $request->validate([
            'product_title' => 'required',
            'description' => 'required',
            'category' => 'required',
            'unit' => 'required',
            'price' => 'required',
            'total' => 'required',
            'discount' => 'required'
        ]);
        $product = new Product();
        $product->title = $request->input('product_title');
        $product->description = $request->input('description');
        $product->unit_id = intval($request->input('unit'));
        $product->price = doubleval($request->input('price'));
        $product->total = intval($request->input('total'));
        $product->category_id = intval($request->input('category'));
        $product->discount = doubleval($request->input('discount'));

        if($request->has('options')){ //because option field is optional 'nullable'
            $optionArray = []; //new empty array
            $options = array_unique($request->input('options')); // get not repeat elements from options (color,size)
            foreach ($options as $option){
                $actualOptions = $request->input($option); //color
                $optionArray[$option] = []; //make the first element of $optionArray key = color value = new array
                foreach ($actualOptions as $actualOption){
                    array_push($optionArray[$option],$actualOption);
                }

            }
            $product->options = json_encode($optionArray);
        }
        $product->save();
        Session::flash('message','product has been added');
        return redirect()->route('products');
    }
    public function delete($id, Request $request){

    }
    public function update(Request $request){

    }
    public function search(Request $request){

    }

}
