<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Restaurants;

class RestaurantController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index()
    {
    	$restaurants = Restaurants::orderBy('created_at', 'desc')->get();
    	return view('admin.restaurant', ['restaurants' => $restaurants]);
    }



    public function doaddrestaurant(Request $request)
    {
    	$data = array(
    		'name' => $request->name,
	    	'description' => $request->description,
	    	'capacity' => $request->capacity,
    	);
    	Restaurants::create($data);
    	return redirect('/restaurants')->with("addrestaurant", "Restaurant details is successfully saved.");
    }


    public function removerestaurant($id){
        Restaurants::where('id', $id)->delete();
        return redirect('/restaurants')->with("deleterestaurant", "Restaurant is successfully Removed");
    }

    public function editrestaurant(Request $request){
        $id = $request->restaurantid;
        $data = array(
            'name' => $request->name,
            'description' => $request->description,
            'capacity' => $request->capacity
        );
        Restaurants::where('id', $id)->update($data);
        return redirect('/restaurants')->with("uprestuarant", "Restaurant details is successfully Update.");
    }
}
