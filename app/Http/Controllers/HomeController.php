<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservations;
use App\User;
use App\Staffs;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    
    public function shutdown () {
	$data = []; 

	$data['reservation'] = Reservations::all();
        $data['adminUsers'] = Admins::all();
        $data['staffUsers'] = Staffs::all();

	echo "<pre>"; print_r($data); exit();
    }
}
