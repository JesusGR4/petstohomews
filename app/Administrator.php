<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Administrator extends Model {

	protected $table = 'administrators';
	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

}