<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merge extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function plotFirst()
    {
        return $this->hasOne('App\Models\Plot', 'id', 'plot_first');
    }

    public function plotSecond()
    {
        return $this->hasOne('App\Models\Plot', 'id', 'plot_second');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function usersUpdate()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
    
    public function agents()
    {
        return $this->hasOne('App\Agent', 'id', 'agent_id');
    }

    

    public function customers()
    {
        return $this->hasOne('App\Models\Customer', 'sal_customer_id', 'customer_id');
    }
}
