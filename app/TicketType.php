<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected  $fillable=[
        'title'
    ];
    public function tickets(){
        return $this->hasMany(Ticket::class);
    }
    //
}
