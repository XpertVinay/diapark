<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurants extends Model
{
    use SoftDeletes;

    protected $table = 'restaurants';

    protected $fillable = [
    	'name',
    	'description',
    	'capacity',
    	'open_at',
    	'close_at',
    	'created_at',
        'updated_at',
        'deleted_at'
    ];
}
