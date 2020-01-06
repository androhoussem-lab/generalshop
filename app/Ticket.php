<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable=[
        'user_id','order_id','status','title','message','ticket_type_id'
    ];
    public function ticketType(){
        return $this->belongsTo(TicketType::class);
    }
    //
}
