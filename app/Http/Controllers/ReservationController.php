<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservations;
use App\Models\Restaurants;
use App\Staffs;
use Mail;
use App\Mail\SendMail;
use Config;
use App\Notification\Notifications;
use Event;

class ReservationController extends Controller
{
    public function reservation()
    {
        $restaurants = Restaurants::get();
    	return view('reservation', ['restaurants' => $restaurants]);
    }



    public function doreservation(Request $request)
    {
	// $request->phone = '91'.$request->phone;
	$request->phone = $request->countryCode.$request->phone;
	$refererUrl = request()->headers->get('referer');
    	$data = array(
    		'name' => $request->name,
    		'email' => $request->email,
    		'phone' => $request->phone,
    		'restaurantid' => $request->restaurantid,
    		'occasion' => $request->occasion,
    		'starttime' => date('Y-m-d H:i:s', strtotime($request->starttime)),
    		'endtime' => date('Y-m-d H:i:s', strtotime('+'.$request->endtime.'hour', strtotime(date('Y-m-d H:i:s', strtotime($request->starttime))))),
    		'male' => $request->male,
    		'female' => $request->female,
    		'child' => $request->child,
    		'status' => 'Pending',
		'customer_comment' => $request->customer_comment,
            'created_at' => date('Y:m:d h:i:s'),
            'updated_at' => date('Y:m:d h:i:s'),
	    'referrer' => $refererUrl
    	);
	// echo "<pre>"; print_r($data); exit;
        $reservation = \DB::table('reservations')->insert($data);
        $reservationId = \DB::getPdo()->lastInsertId();
        $staff = Staffs::where('id', '=', $request->restaurantid)->first();

	if(empty($staff)){ return redirect($refererUrl.'?success=1')->with('addreservation', 'No manager available for this restaurant.');
 }
        // dd($staff);
        $restaurant = Restaurants::where('id', $request->restaurantid)->first();
        // trigger notificationss Email, sms, whatsapp etc
        $mailToCustomer = [
            'title' => 'Thank you for your reservation on '. $restaurant->name . ' - ' .config('app.name'),
            'email' => $request->email,
            'phone' => $request->phone,
            'restaurantName' => $restaurant->name,
            'body' => 'This is the body of test email.',
            'view' => 'content.reservation',
            'sms' => 'Thank you for booking with {ref id - '.$reservationId.'}. We will shortly inform you about the confirmation of your table.',
            'whatsapp' => 'Thank you for booking with {ref id - '.$reservationId.'}. We will shortly inform you about the confirmation of your table.',
            'replacements' => $request->all(),
            'type' => ['sms', 'email', 'whatsapp']
        ];
        // print_r("Customer>>>>>>>>>>>>");
        if ($mailToCustomer['email']) {
            Event::dispatch(new Notifications($mailToCustomer));
        }
        // print_r("Customer End >>>>>>>>>>>");
        $mailToRestaurantStaff = [
                'title' => 'You have received a new booking request ' . $restaurant->name . ' - ' .config('app.name'),
                'email' => $staff->email,
                'phone' => $staff->phone,
                'restaurantName' => $restaurant->name,
                'body' => 'This is the body of test email.',
                'view' => 'content.staff',
                'sms' => "Hi $staff->name, New booking request recieved with {ref id - $reservationId }. Please take action on this booking id {$reservationId} ".url('/staff/login').".",
                'whatsapp' => "Hi $staff->name, New booking request recieved with {ref id - $reservationId }. Please take action on this booking id {$reservationId} ".url('/staff/login').".",
                'replacements' => array_merge($request->all(), ['staff_name' => $staff->name, 'restaurantName' => $restaurant->name]),
                'type' => ['email', 'whatsapp']
            ];
            // print_r("staff");
        if ($mailToRestaurantStaff['email']) {
            Event::dispatch(new Notifications($mailToRestaurantStaff));
        }

        // dd('print');

    	// Reservations::create($data);
	$admin = "";
	if($request->admin == '1'){
		$admin = "&admin=1";
	}
	// return \Redirect::back()->with(['success' => '1', 'addreservation', 'Thank you for your booking. Please wait for approval and check your Email for confirmation']);
    	return redirect($refererUrl.'/?success=1'.$admin)->with('addreservation', 'Thank you for your booking. Please wait for approval and check your Email for confirmation');
    }
}
