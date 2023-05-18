<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function from()
    {
         return $this->hasOne('TCG\Voyager\Models\User', 'id', 'msg_from');
    }

    public function to()
    {
         return $this->hasOne('TCG\Voyager\Models\User', 'id', 'msg_to');
    }

    public function event()
    {
         return $this->hasOne('App\FeeSetup', 'id', 'event_id');
    }
    

}
