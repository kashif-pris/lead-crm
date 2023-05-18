<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
	use HasFactory;

	protected $fillable = [
		'title', 'start', 'end','lead_id','created_by'
	];

    public function lead()
    {
        return $this->hasOne('App\Models\Leads', 'id', 'lead_id');
    }

}

?>