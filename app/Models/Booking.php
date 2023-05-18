<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function nominees()
    {
        return $this->hasMany('App\Models\Nominee', 'booking_id', 'id');
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'id', 'created_by');
    }


    public function down_payments()
    {
        return $this->hasOne('App\Models\DownPayment', 'booking_id', 'id');
    }

    // public function tokens()
    // {
    //     return $this->hasOne('App\Models\Token', 'booking_id', 'id');
    // }

    public function agents()
    {
        return $this->hasOne('App\Models\User', 'id', 'agent_id');
    }

    public function plots()
    {
        return $this->hasMany('App\Models\Plot', 'id', 'plot_id');
    }

    public function customers()
    {
        return $this->hasOne('App\Models\Leads', 'id', 'customer_id');
    }
    public function payments()
    {
        return $this->hasOne('App\Models\InstallmentMaster', 'customerid', 'customer_id');
    }
   
    public function allotment_Certificate()
    {
        return $this->hasMany('App\Models\Allotment', 'booking_id', 'id');
    }

    public function getDownPaymentAttribute() {

        return $this->down_payments()->first()->token_amount+$this->down_payments()->first()->amount;
    }
    

   
    
}
