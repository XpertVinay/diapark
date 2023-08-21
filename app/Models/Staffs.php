<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staffs extends Model
{
    protected $fillable =[
    	'name',
    	'restaurantid',
    	'email',
    	'phone',
    	'address',
    	'salary',
        'password'
    ];
}
