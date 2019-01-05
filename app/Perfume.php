<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfume extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'aroma','type','stock','image'
    ];
}
