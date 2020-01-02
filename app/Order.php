<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=[
      'user_id','payment_id','cart_id','order_date'
    ];
    //
    public function Customer(){
        return $this->belongsTo(User::class);
    }
    public function Cart(){
        return $this->hasOne(Cart::class);
    }
    public function payment(){
        return $this->hasOne(Payment::class);
    }
}
