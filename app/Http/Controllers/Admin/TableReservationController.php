<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservations;

class TableReservationController extends Controller
{
	public function __construct()
	{
	    $this->middleware('auth');
	}



    public function tablereservation()
    {
    	$reservations = Reservations::select('reservations.*', 'res.name as restaurantName')
                            ->leftjoin('restaurants as res', function($join)
                            {
                              $join->on('res.id', '=', 'reservations.restaurantid');
                              $join->where('res.deleted_at', '=', NULL);

                            })
                            ->orderBy('created_at', 'desc')
                            ->get();
    	return view('admin.tablereservation', ['reservations'=>$reservations]);
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
        if(false){
            $mailToCustomer = [
                'title' => 'Thank you for your reservation on '.config('app.name'),
                'body' => 'This is the body of test email.',
                'view' => 'content.reservation',
                'replacements' => $request->all()
            ];
    
            $mailToRestaurantStaff = [
                'title' => 'You received a booking request'.config('app.name'),
                'body' => 'This is the body of test email.',
                'view' => 'content.staff',
                'replacements' => $request->all()
            ];
    
            Mail::to($request->email)->send(new SendMail($mailToCustomer));
            Mail::to($staff->email)->send(new SendMail($mailToRestaurantStaff));   
        }

      	Reservations::where('id', $id)->update($data);
      	return redirect('/tablereservation')->with('tableapprove', "Resevation is Approved.");
    }

    public function deletereservation($id){
      	Reservations::where('id', $id)->delete();
        return redirect('/tablereservation')->with("deletereservationtable", "Resevation is successfully Removed");
    }
}
