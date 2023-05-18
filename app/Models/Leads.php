<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    protected $table = 'leads';
    protected $guarded = [];


    public function reminders()
    {
        return $this->hasMany('App\Models\CallRecoveryMan', 'id','lead_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\LeadComments', 'lead_id')->orderBy('id','desc');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_name');
    }

    public function partnerData()
    {
        return $this->belongsTo('App\Agent','partner');
    }

    public function agent()
    {
        return $this->hasOne('App\Models\User','id' ,'allocated_to')->withCount('agent_lead_count');
    }
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'lead_id','id');
    }
    public function reminders_call()
    {
        return $this->hasMany('App\Models\CallRecoveryMan', 'lead_id','id');
    }

    public function agent_count_lead()
    {
        return $this->hasMany('App\Models\User', 'id','allocated_to');
    }


}
