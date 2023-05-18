<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiIntegrationSetting extends Model
{
    protected $fillable =[
        'id','_token','agent_id','facebook','api_duration','account_id','app_id','compaign_id','fb_token','base_path','uan_token','status','created_at','updated_at'
    ];
    use HasFactory;
}
