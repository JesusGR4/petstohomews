<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shelter extends Model {

	protected $table = 'shelters';
	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

}