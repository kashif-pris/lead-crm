<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable =[
        "id", "name", "slug", "created_at",
        "updated_at"
    ];
  

   
}
