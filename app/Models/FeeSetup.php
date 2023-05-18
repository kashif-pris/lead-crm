<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeSetup extends Model
{
    protected $fillable =[
        "id", "name", "fee", "slug","created_at",
        "updated_at"
    ];

    protected $table= "fee_setup";
  

   
}
