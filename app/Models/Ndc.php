<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ndc extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'ndc';
    protected $guarded = [];

    public function bookings()
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
    public function allotment_Certificate()
    {
        return $this->hasMany('App\Models\Allotment', 'booking_id', 'booking_id');
    }

}
