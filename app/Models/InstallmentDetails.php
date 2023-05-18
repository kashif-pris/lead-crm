<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentDetails extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table= "InsatllmentDetails";
   
    public function booking()
    {
        return $this->hasOne('App\Models\Booking', 'id','booking_id');
    }

    

    
   
}
