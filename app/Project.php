<?php

namespace App;
use App\Block;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable =[
        "id", "project_name", "description", "created_at",
        "updated_at"
    ];
  

    public function blocks()
    {
    	return $this->hasMany(Block::class);
    }
}
