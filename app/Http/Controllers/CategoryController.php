<?php

namespace App\Http\Controllers;

use App\Category;
use foo\bar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    //TODO:Show all
    public function index(){
        $categories = Category::paginate(env('PAGINATION_COUNT'));
        return view('admin.categories.categories')->with([
            'categories' => $categories,
            'showLinks' => true
        ]);
    }

    private function checkCategoryName($categoryName){
        $categories = Category::where(
            'name','=',$categoryName
        )->get();
        if(count($categories) > 0){
            Session::flash('message','category (' .$categoryName. ') is already exist ');
            return true;
        }
        return false;
    }
    //TODO:Store new
    public function store(Request $request){
        $request->validate([
            'category_name' => 'required'
        ]);
        $category = $request->input('category_name');
        if ($this->checkCategoryName($category)){
            return back();
        }
        $newCategory = new Category();
        $newCategory->name = $category;
        $newCategory->save();
        Session::flash('message' , 'Category (' .$category. ') has been added');
        return back();
    }
    //TODO:Delete
    public function delete(Request $request){
        $categoryId = $request->input('category_id');
        if(is_null($categoryId) || empty($categoryId)){
            Session::flash('message','category id is required');
            return back();
        }
        Category::destroy($categoryId);
        Session::flash('message','this category has been deleted');
        return back();

    }
    //TODO:Update
    public function update(Request $request){
        $request->validate([
            'category_name' => 'required',
            'category_id' => 'required'
        ]);
        $categoryId = intval($request->input('category_id'));
        $categoryName = $request->input('category_name');
        if ($this->checkCategoryName($categoryName)){
            return back();
        }
        $category = Category::find($categoryId);
        $category->name = $categoryName;
        $category->save();
        Session::flash('message' , 'category (' .$category->name. ') has been updated ');
        return back();

    }
    //TODO:search
    public function search(Request $request){
        $request->validate([
            'category_search' => 'required'
        ]);
        $term = $request->input('category_search');
        $result = Category::where(
            'name' , 'like' , '%' .$term. '%'
        )->get();
        if(count($result) > 0){
            return view('admin.categories.categories')->with([
                'categories' => $result,
                'showLinks' => false
            ]);
        }
        Session::flash('message' ,'this category is not exist');
        return back();

    }
}
