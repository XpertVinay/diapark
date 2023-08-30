<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservations;
use App\Models\Restaurants;
use App\Staffs;
use App\Notification\Notifications;
use Event;

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

	 // notifications only email
        $reservation = Reservations::where('id', $id)->first();
        $reservation->starttime = $request->starttime;
        $reservation->endtime = $request->endtime;
        $reservation->status = $name;
        $reservation->male = $request->male;
        $reservation->female = $request->female;
        $reservation->child = $request->child;
        $reservation->save();
        
        $restaurant = Restaurants::where('id', $reservation->restaurantid)->first();
	    $staff = Staffs::where('id', $reservation->restaurantid)->first();

        $mailToCustomer = [
            'title' => 'Update on your recent booking from '.$restaurant->name,
            'email' => $reservation->email,
            'phone' => $reservation->phone,
            'restaurantName' => $restaurant->name,
            'body' => 'This is the body of test email.',
            'view' => 'content.updateres',
            'sms' => "Dear ".$reservation->name .",\n Your booking (Booking id - ".$reservation->id.") for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been confirmed, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'whatsapp' => "Dear ".$reservation->name .",\n Your booking ".$reservation->id." for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been confirmed, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'replacements' => array_merge($request->all(), ['restaurantName'=>$restaurant->name, 'sstart'=>$request->starttime, 'send'=>$request->endtime, 'name'=>$reservation->name]),
	        'type' => ['sms', 'email', 'whatsapp']
        ];
        // notifications only email
	if($reservation->email){
		Event::dispatch(new Notifications($mailToCustomer));
	}

      	// Reservations::where('id', $id)->update($data);
      	return redirect('/tablereservation')->with('tableapprove', "Resevation is Approved.");
    }

    public function deletereservation($id){
      	Reservations::where('id', $id)->delete();
        return redirect('/tablereservation')->with("deletereservationtable", "Resevation is successfully Removed");
    }
}
