<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservations;
use App\User;
use App\Staffs;
use App\Models\Restaurants;

class LandingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index_en()
    {
	$restaurants = Restaurants::get();
        return view('landing_en', ['restaurants'=>$restaurants]);
    }

    public function index_jp()
    {
	$restaurants = Restaurants::get();
        return view('landing_jp', ['restaurants'=>$restaurants]);
    }
}
