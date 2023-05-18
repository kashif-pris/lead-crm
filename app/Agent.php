<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $guarded = [];

    protected $table= "agents";
  
    public function projects()
    {
        return $this->hasOne('App\Project', 'id', 'project_id')->select('id','project_name');
    }
   
}
