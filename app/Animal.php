<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Animal extends Model 
{

    protected $table = 'animals';
    public $timestamps = true;

    public function belongsToShelter()
    {
        return $this->belongsTo('Shelter', 'shelter_id');
    }

    public function hasManyImages()
    {
        return $this->hasMany('Image');
    }

    public function hasManyDogs()
    {
        return $this->hasMany('Dog');
    }

    public function hasManyCats()
    {
        return $this->hasMany('Cat');
    }

}