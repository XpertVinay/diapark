<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Staffs;
use App\Models\Restaurants;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }



    public function staff()
    {
    	$staffs = Staffs::select('staffs.*', 'res.name as restaurantName')
                        ->leftjoin('restaurants as res', 'res.id', '=', 'staffs.restaurantid')
                        ->get();
        // print_r($staffs->toArray()); exit;
        $restaurants = Restaurants::get();
    	return view('admin.staff', ['staffs' => $staffs, 'restaurants' => $restaurants]);
    }



    public function doaddstaff(Request $request)
    {
    	$data = array(
	    	'name' => $request->name,
	    	'restaurantid' => $request->restaurantid,
	    	'email' => $request->email,
	    	'phone' => $request->phone,
	    	'address' => $request->address,
	    	'password' => Hash::make($request->password)
    	);
	$staff = \DB::table('staffs')
			->where('restaurantid', $request->restaurantid)
			->where('email', $request->email)
			// ->toSql();
			->get();
	if($staff->count() > 0){
		return redirect('/staff')->with("erraddstaff", "Staff already exists for this restaurant.");
	}
    	\DB::table('staffs')->insert($data);
    	return redirect('/staff')->with("addstaff", "Staff details is succesfully saved.");
    }


    public function removestaff($id){
        Staffs::where('id', $id)->delete();
        return redirect('/staff')->with("deletestaff", "Staff is successfully Removed");
    }

    public function editstaff(Request $request){
        $id = $request->stassid;
        $data = array(
            'name' => $request->name,
            'restaurantid' => $request->restaurantid,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'salary' => $request->salary,
            'password' => Hash::make($request->password)
        );
        Staffs::where('id', $id)->update($data);
        return redirect('/staff')->with("upstaff", "Staff details is succesfully Update.");
    }
}
