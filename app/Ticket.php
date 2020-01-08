<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable=[
        'user_id','order_id','status','title','message','ticket_type_id'
    ];
    public function ticketType(){
        return $this->belongsTo(TicketType::class);
    }
    public function customer(){
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
    public function formatTimeForHuman(){
        return  Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }
    //
}
