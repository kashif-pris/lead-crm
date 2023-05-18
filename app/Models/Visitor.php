<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use DB;

class Visitor extends Model
{
    use HasFactory;
     
    public $timestamps = false;
    protected $table = 'php_visitors';
    protected $guarded = [];

    public function getUser(){
        return Auth::user()->id;
    }

}

