<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Plot extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function block()
    {
        return $this->hasOne('App\Block', 'id', 'bl_id');
    }

    public function sizeGet()
    {
         return $this->hasOne('TCG\Voyager\Models\Category', 'id', 'size');
    }

    public function projects()
    {
         return $this->hasOne('App\Project', 'id', 'pr_id');
    }
    public function customers()
    {
         return $this->hasOne('App\Models\Leads', 'id', 'customer_id');
    }

    public function scopePlots($query){
        
        $empty = [];

        $bookings = DB::table('bookings')->select('plot_id')->get()->toArray();
        $tokens = DB::table('tokens')->select('plot_id')->get()->toArray();
        
        foreach($bookings as $item){
            $empty[] = $item->plot_id;
        }
        foreach($tokens as $item){
            $empty[] = $item->plot_id;
        }
       
        return $query->whereNotIn('id', $empty);
    }

  
}
