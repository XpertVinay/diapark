<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Orders;
use App\Menu;
use App\Models\Restaurants;
use App\Reservations;
use App\Staffs;
use App\Expenses;

class DashbaordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function dashboard()
    {
        $totalorder = count(Restaurants::get());
        $totalitem = count(Reservations::get());
        $staffs = count(Staffs::get());

       $orders = \DB::table('reservations as resr')
                ->select('resr.*', 'rest.name as restName')
                ->join('restaurants as rest', 'resr.restaurantid', 'rest.id')
                ->orderBy('resr.id', 'DESC')->limit(5)->get();
    	return view('admin.dashboard', ['orders' => $orders, 'totalorder' => $totalorder, 'totalitem' => $totalitem, 'staffs' => $staffs]);
    }

    public function editprofile(Request $request){
       $userid = Auth::user()->id;

        $password = Hash::make($request->password);

        $data = array(
             'name' =>$request->name,
             'email' => $request->email,
        	'password'  => $password
        );

        User::where('id', $userid)->update($data);
        return  redirect('/dashboard')->with("adminpasschang", "Your Profile is successfully Update");


    }
}
