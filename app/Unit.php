<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    //
    protected $fillable=[
        'unit_code','unit_name'
    ];

    public function products(){
        return $this->hasMany(Product::class , 'unit' , 'id');
    }
    public function formattedName(){
        return $this->unit_code . '-' .$this->unit_name;
    }
}
