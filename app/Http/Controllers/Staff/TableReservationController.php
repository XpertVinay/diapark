<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservations;
use App\Models\Restaurants;
use App\Staffs;
use App\Events\SendNotification;
use Event;

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
        $reservations = \DB::table('reservations')->select('reservations.*', 'res.name as restaurantName')
                            ->join('restaurants as res', function($join) use ($request)
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
    //    $data = array(
    //         'starttime' => $request->starttime,
    //         'endtime' => $request->endtime,
    //         'status' => $name,
    //         'male' => $request->male,
    //         'female' => $request->female,
    //         'child' => $request->child,
    //     );

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
            'sms' => "Dear ".$reservation->name .",\n Your booking (Booking id - ".$reservation->id.") for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been approved, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'whatsapp' => "Dear ".$reservation->name .",\n Your booking ".$reservation->id." for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been approved, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'replacements' => array_merge($request->all(), ['restaurantName'=>$restaurant->name, 'sstart'=>$request->starttime, 'send'=>$request->endtime, 'name'=>$reservation->name]),
	        'type' => ['sms', 'email', 'whatsapp']
        ];
	    dd($mailToCustomer);
        // notifications only email
	//dd($reservation);
	if($reservation->email){
		Event::dispatch(new SendNotification($mailToCustomer));
	}

      	// Reservations::where('id', $id)->update($data);
      	return redirect('/staff/tablereservation')->with('tableapprove', "Resevation is Approved.");
    }

    public function deletereservation($id){
      	Reservations::where('id', $id)->delete();
        return redirect('/staff/tablereservation')->with("deletereservationtable", "Resevation is successfully Removed");
    }
}
