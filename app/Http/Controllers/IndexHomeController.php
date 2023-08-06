<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurants;

class IndexHomeController extends Controller
{
    public function index()
    {
    	$restaurants = Restaurants::get();
    	return view('index', ['restaurants'=>$restaurants]);
    }
    
    public function foodNService()
    {
    	$restaurants = Restaurants::get();
    	return view('food_service', ['restaurants'=>$restaurants]);
    }
}
