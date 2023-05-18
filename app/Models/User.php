<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Contracts\User as UserContract;
use TCG\Voyager\Traits\VoyagerUser;
use Laravel\Sanctum\HasApiTokens;
use Auth;
class User extends Authenticatable implements UserContract
{
    use HasApiTokens;
    use VoyagerUser;
    protected $fillable = ['name', 'email', 'password'];
    protected $guarded = [];

    public $additional_attributes = ['locale'];

    public function getAvatarAttribute($value)
    {
        return $value ?? config('voyager.user.default_avatar', 'users/default.png');
    }

    public function setCreatedAtAttribute($value)
    {
        $this->attributes['created_at'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = $value ? $value->toJson() : json_encode([]);
    }

    public function getSettingsAttribute($value)
    {
        return collect(json_decode($value));
    }

    public function setLocaleAttribute($value)
    {
        $this->settings = $this->settings->merge(['locale' => $value]);
    }

    public function getLocaleAttribute()
    {
        return $this->settings->get('locale');
    }
    public function getUser(){
        return Auth::user()->id;
    }

    public function agent_lead_count()
    {
        return $this->hasMany('App\Models\Leads', 'allocated_to','id');
    }
    public function agent_event_count()
    {
        return $this->hasMany('App\Models\Event', 'created_by','id');
    }
    public function agent_call_count()
    {
        return $this->hasMany('App\Models\CallRecoveryMan', 'created_by','id');
    }

    public static function getManagerAgents()
    {
        $managerId = Auth::user();
            if($managerId->role_id == 8){
                $arry =  User::where('manager',$managerId->id)->pluck('id')->toArray();
                // dd( $arry );
                array_push($arry,$managerId->id);
            }else{
                $arry =  User::where('manager',$managerId->id)->pluck('id')->toArray();
            }

            return $arry;
          
        

    }
    
}
