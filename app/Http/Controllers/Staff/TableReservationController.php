<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservations;

class TableReservationController extends Controller
{
	public function __construct(Request $request)
	{
	    try{
            if(!$request->session()->get('restaurantid')){
                return redirect('staff/login');
            }
        } catch (\Exception $ex){
            return redirect('staff/login');
        }
	}



    public function tablereservation(Request $request)
    {
        $reservations = Reservations::select('reservations.*', 'res.name as restaurantName')
                            ->join('restaurants as res', function($join)
                            {
                              $join->on('res.id', '=', 'reservations.restaurantid');
                              $join->where('res.deleted_at', '=', NULL);

                            })
                            ->join('staffs as staff', function($join)
                            {
                              $join->on('staff.restaurantid', '=', 'res.id');
                            })
                            ->where('staff.restaurantid', '=', $request->session()->get('restaurantid'))
                            ->orderBy('created_at', 'desc')
                            ->get();
    	return view('staff.tablereservation', ['reservations'=>$reservations, 'request' => $request]);
    }


    public function approve(Request $request){
        $id = $request->id;
        $name = $request->name;
       $data = array(
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'status' => $name,
            'male' => $request->male,
            'female' => $request->female,
            'child' => $request->child,
        );

        // notifications only email

      	Reservations::where('id', $id)->update($data);
      	return redirect('/staff/tablereservation')->with('tableapprove', "Resevation is Approved.");
    }

    public function deletereservation($id){
      	Reservations::where('id', $id)->delete();
        return redirect('/staff/tablereservation')->with("deletereservationtable", "Resevation is successfully Removed");
    }
}
