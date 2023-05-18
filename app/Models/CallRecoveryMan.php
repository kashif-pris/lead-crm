<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRecoveryMan extends Model
{
    use HasFactory;
    protected $table = 'calls';

    protected $fillable = ['id', 'lead_id', 'type', 'description', 'call_status', 'call_type', 'date', 'created_at', 'updated_at' , 'created_by'];

    public function leadsDetails()
    {
        return $this->hasMany('App\Models\leads', 'id', 'lead_id');
    }


}
