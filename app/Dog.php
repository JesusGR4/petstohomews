<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dog extends Model 
{

    protected $table = 'dogs';
    public $timestamps = true;

    public function dogBelongsTo()
    {
        return $this->belongsTo('Animal', 'animal_id');
    }

}