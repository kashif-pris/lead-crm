<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Plot;
use App\Models\Customer;
use App\Models\Leads;
use App\Models\User;

use Auth;
use DB;

class Token extends Model
{
    use HasFactory;
    protected $guarded = [];
//     public $timestamps = false;

    public function save(array $options = []){
       
       $plot =  Plot::where('id',$this->plot_id)->first()->name;
       $customer =  Leads::where('id',$this->customer_id)->first();
    
      
        if (Auth::user()) {
        $this->created_by = Auth::user()->name;
        $this->status = 0;
        }
             parent::save();

            $mobile = $customer->phone;
            $message = "Mr . ".$customer->name." You have given token of ".$this->amount." against Office (".$plot."). Its expire date is ".$this->expriry_date;
            $path = '/admin/tokens'; 
            $return_message = 'Token has been created successfully';
            
    
            return app('App\Http\Controllers\ApiController')->sms($mobile,$message,$path,$return_message);
    }

   

    public function users()
    {
         return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function customers()
     {
     return $this->hasOne('App\Models\Leads', 'id','customer_id');
     }
     
     public function plots()
     {
     return $this->hasOne('App\Models\Plot', 'id','plot_id');
     }

}
