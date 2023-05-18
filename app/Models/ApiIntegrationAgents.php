<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiIntegrationAgents extends Model
{
    protected $fillable =[
        'id'
      ,'integration_id'
      ,'agent_name'
      ,'date'
      ,'lead_count'
      ,'created_at'
      ,'updated_at'
    ];
    use HasFactory;
}
