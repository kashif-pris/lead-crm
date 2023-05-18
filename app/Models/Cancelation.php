<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancelation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function booking()
    {
        return $this->hasOne('App\Models\Booking', 'id', 'booking_id');
    }

    public function users()
    {
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function usersUpdate()
    {
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }

}
