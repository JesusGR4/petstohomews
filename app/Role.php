<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {

	protected $table = 'roles';
	public $timestamps = true;

	public function hasManyUsers()
	{
		return $this->hasMany('User');
	}

}