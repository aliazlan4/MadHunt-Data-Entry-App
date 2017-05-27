<?php

namespace MadHunt;

use Illuminate\Database\Eloquent\Model;

class madhuntData extends Model
{
    protected $table = 'madhuntDataTable';

    protected $fillable = [
        'lat', 'lng', 'radius', 'user'
    ];
}
