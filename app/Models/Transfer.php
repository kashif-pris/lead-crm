<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected  $guarded = []; 


    public function customerFrom()
    {
        return $this->hasOne('App\Models\Customer', 'sal_customer_id', 'from_customer');
    }


    public function customerTo()
    {
        return $this->hasOne('App\Models\Customer', 'sal_customer_id', 'to_customer');
    }

    public function agents()
    {
        return $this->hasOne('App\Agent', 'id', 'agent_id');
    }
    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function usersUpdate()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

    public function plots()
    {
        return $this->hasOne('App\Models\Plot', 'id', 'plot_id');
    }
    
    public function transferNominees()
    {
        return $this->hasMany('App\Models\TransferNominee', 'transfer_id', 'id');
    }

    public function booking()
    {
        return $this->hasMany('App\Models\Booking', 'id', 'booking_id');
    }

    public function getTotalTransfersAttribute() {
        
        return $this->where('plot_id',$this->plot_id)->where('status',1)->count('plot_id');
    }

    public function getEarnedMoneyAttribute() {
        
        return $this->where('plot_id',$this->plot_id)->sum('fee');
    }

    public function getReservedByAttribute() {
        
     $customerID = $this->where('plot_id',$this->plot_id)->where('status',1)->orderByDesc('id')->first()->to_customer;
     return Customer::where('sal_customer_id',$customerID)->first()->sal_customer_name;

    }

    public function down_payments()
    {
        return $this->hasOne('App\Models\DownPayment', 'transfer_id', 'id');
    }

    public function getDrawChartAttribute() {

        // $plot_booked = Plot::selectRaw('is_booked , count(id) as count')->groupBy('is_booked')->get()->toArray();
        // $plot_customers = Booking::with(['customers','plots'])->get()->toArray();

        $data = $this->where('plot_id',$this->plot_id)->where('status',1)->orderByDesc('id')->get();
        return $data;
   
       }

}
