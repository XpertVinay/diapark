<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservations extends Model
{

    protected $guarded=[];
    protected $fillable = [
    	'name',
    	'email',
    	'phone',
    	'status',
        'restaurantid',
    	'starttime',
    	'endtime',
    	'occasion',
    	'male',
    	'female',
    	'child',
        'updated_at',
        'created_at'
    ];
}
