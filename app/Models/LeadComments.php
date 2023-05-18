<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadComments extends Model
{
    use HasFactory;
    protected $table = 'php_comments';
    protected $guarded = [];
   
}
