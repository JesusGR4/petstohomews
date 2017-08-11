<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cat extends Model 
{

    protected $table = 'cats';
    public $timestamps = true;

    public function catBelongsTo()
    {
        return $this->belongsTo('Animal', 'animal_id');
    }

}