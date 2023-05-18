<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InstallmentMaster extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $table= "InstallmentMaster";
    protected $primaryKey = 'InstallmentId';
    public $incrementing = false;
    protected $keyType = 'string';


    public function details()
    {
        return $this->hasMany('App\Models\InstallmentDetails', 'InstallmentId','InstallmentId');
    }

    public function details_receipt()
    {
        return $this->hasMany('App\Models\ReciptMaster', 'sal_customer_id','customerid');
    }
   
    public function getTotalInstallmentsAttribute()
    {
        return $this->details->count('InstallmentId');
    }

    public function getTotalPaidInstallmentsAttribute()
    {
        return $this->details->where('AmountReceived','!=',0)->count('InstallmentId');
    }

    public function plots()
    {
        return $this->hasOne('App\Models\Plot', 'id', 'plot_id');
    }

    public function customers()
    {
        return $this->hasOne('App\Models\leads', 'id', 'customerid');
    }

    public function getPaidAmountAttribute()
    {
        // dd($this);
        return $this->details()->sum('AmountReceived');
    }
    
    public function getRemainingAmountAttribute()
    {
       $data = $this->details()->get();
    
       $remainingAmount = [];
       foreach($data as $val){
            if($val->AmountReceived == 0){
                $remainingAmount[] =  $val->MonthlyInstallment;
            }elseif(($val->MonthlyInstallment - $val->AmountReceived) != 0){
                $remainingAmount[] =  $val->MonthlyInstallment - $val->AmountReceived;

            }
       }

       return array_sum($remainingAmount);
    }

    
   
}
