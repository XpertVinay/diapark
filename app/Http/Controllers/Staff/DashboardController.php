<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Staffs;
use App\Models\Restaurants;
use App\Reservations;

class DashboardController extends Controller
{
    public function __construct(Request $request)
    {
        try{
            // echo "<pre>"; print_r($request->session()); exit;
            if(!$request->session()->get('restaurantid')){
                return redirect('staff/login');
            }
        } catch (\Exception $ex){
            return redirect('staff/login');
        }
    }



    public function dashboard(Request $request)
    {
    	$totalorder = count(Restaurants::get());
        $totalitem = count(Reservations::get());
        $staffs = count(Staffs::get());

       $orders = \DB::table('reservations as resr')
                ->select('resr.*', 'rest.name as restName')
                ->join('restaurants as rest', 'resr.restaurantid', 'rest.id')
                ->orderBy('resr.id', 'DESC')->limit(5)->get();
    	return view('staff.dashboard', ['request' => $request, 'orders' => $orders, 'totalorder' => $totalorder, 'totalitem' => $totalitem, 'staffs' => $staffs]);
    }

    public function doaddstaff(Request $request)
    {
    	$data = array(
    		'name' => $request->name,
	    	'restaurantid' => $request->session()->get('restaurantid'),
	    	'email' => $request->email,
	    	'phone' => $request->phone,
	    	'address' => $request->address,
	    	'password' => Hash::make($request->password)
    	);
        print_r($data); exit;
    	Staffs::create($data);
    	return redirect('/staff/dashboard')->with("addstaff", "Staff details is succesfully saved.");
    }


    public function removestaff($id){
        Staffs::where('id', $id)->delete();
        return redirect('/staff/dashboard')->with("deletestaff", "Staff is successfully Removed");
    }

    public function editstaff(Request $request){
        $id = $request->stassid;
        $data = array(
            'name' => $request->name,
            'restaurantid' => $request->session()->get('restaurantid'),
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password)
        );
        Staffs::where('id', $id)->update($data);
        return redirect('/staff/dashboard')->with("upstaff", "Staff details is succesfully Update.");
    }
    
    public function editprofile(Request $request){
       $userid = $request->session()->get('id');

        $password = Hash::make($request->password);

        $data = array(
             'name' =>$request->name,
             'email' => $request->email,
        	'password'  => $password
        );
        $request->session()->put('name', $request->name);
        $request->session()->put('email', $request->email);

        Staffs::where('id', $userid)->update($data);
        return  redirect('/staff/tablereservation')->with("staffpasschang", "Your Profile is successfully Update");


    }
}
