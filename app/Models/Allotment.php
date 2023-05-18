<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allotment extends Model
{
    public $timestamps = false;
    protected $fillable =[
        "id", "customer_id", "booking_id",'status', "created_at",
        "updated_at",'created_by','updated_by','deleted_by','type','file','cnic','delivered_at'
    ];
  
    public function booking()
    {
        return $this->hasOne('App\Models\Booking', 'id','booking_id');
    }

    
   
}
