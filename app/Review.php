<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable= [
        'user_id','product_id','stars','review'
    ];

    public function customer(){
        return $this->belongsTo(User::class,'user_id' , 'id');
    }
    public function product(){
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }
    public function formatTimeForHuman(){
        return  Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }
    //
}
