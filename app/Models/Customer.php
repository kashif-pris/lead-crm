<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Customer extends Model
{
    use HasFactory;
     
    public $timestamps = false;
    protected $table = 'tbl_sal_customer_master';
    protected $guarded = [];

    public function getUser(){
        return Auth::user()->id;
    }

    // public function save(array $options = []){
    //     if (Auth::user()) {
    //     $this->created_by = Auth::user()->id;
    //     }
    //         return parent::save();
    // }

    public function bookings(){
        return $this->hasMany('App\Models\Booking', 'id', 'booking_id');
    }

   


    public function transfers()
    {
        return $this->belongsTo('App\Models\Transfer', 'to_customer','id');
    }
      


}

