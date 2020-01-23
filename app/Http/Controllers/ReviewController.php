<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    //
    public function index(){
        $reviews = Review::with(['product','customer'])->paginate(env('PAGINATION_COUNT'));
        $products = Product::all(); // for show in list wen add a new review
        return view('admin.reviews.reviews')->with([
            'reviews' => $reviews,
            'products' => $products
        ]);
    }
    private function checkReview($userId,$productId){
        $reviews = Review::where(
            'user_id','=',$userId
        )->where(
            'product_id','=',$productId
        )->get();
        if (count($reviews)>0){
            Session::flash('message','you already add a review for this product');
            return true;
        }
        return false;

    }
    public function store(Request $request){
        $request->validate([
            'user' => 'required',
            'products' => 'required',
            'stars' => 'required',
            'review' => 'required',
        ]);
        $userId = $request->input('user');
        $productId = $request->input('products');
        $stars = $request->input('stars');
        $content = $request->input('review');
        if ($this->checkReview($userId,$productId)){
            return back();
        }
        $review = new Review();
        $review->user_id = $userId;
        $review->product_id = $productId;
        $review->stars = $stars;
        $review->review = $content;
        $review->save();
        Session::flash('message' , 'Thank you ,your review has been added for product id : '.$productId );
        return back();
    }
    public function delete(Request $request){
        $reviewId = intval($request->input('review_id'));
        if (is_null($reviewId) || empty($reviewId) ){
            Session::flash('message','Review id is required');
            return back();
        }
        Review::destroy($reviewId);
        Session::flash('message','this review has been deleted');
        return back();
    }
}
