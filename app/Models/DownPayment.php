<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownPayment extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;

        public function banks()
        {
            return $this->hasOne('App\Models\Bank', 'id', 'bank_id');
        }

}
