<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

	protected $table = 'images';
	public $timestamps = true;

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}

    public function belongsToAnimal()
    {
        return $this->belongsTo('Animal', 'animal_id');
    }

}