<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservations;
use App\Models\Restaurants;
use App\Staffs;
use Mail;
use App\Mail\SendMail;
use Config;
use App\Events\SendNotification;
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
    	$data = array(
    		'name' => $request->name,
    		'email' => $request->email,
    		'phone' => $request->phone,
    		'restaurantid' => $request->restaurantid,
    		'occasion' => $request->occasion,
    		'starttime' => $request->starttime,
    		'endtime' => $request->endtime,
    		'male' => $request->male,
    		'female' => $request->female,
    		'child' => $request->child,
    		'status' => 'Pending',
            'created_at' => date('Y:m:d h:i:s'),
            'updated_at' => date('Y:m:d h:i:s')
    	);
	// print_r($data); exit;
        $reservation = \DB::table('reservations')->insert($data);
        $reservationId = \DB::getPdo()->lastInsertId();
        $staff = Staffs::where('id', '=', $request->restaurantid)->first();
        $restaurant = Restaurants::where('id', $request->restaurantid)->first();
        // trigger notifications Email, sms, whatsapp etc
        $mailToCustomer = [
            'title' => 'Thank you for your reservation on '.config('app.name'),
            'email' => $request->email,
            'phone' => $request->phone,
            'restaurantName' => $restaurant->name,
            'body' => 'This is the body of test email.',
            'view' => 'content.reservation',
            'sms' => 'Thank you for booking. We will shortly inform you about the confirmation of your table.',
            'whatsapp' => 'Thank you for booking. We will shortly inform you about the confirmation of your table.',
            'replacements' => $request->all(),
            'type' => ['sms', 'email', 'whatsapp']
        ];
        $mailToRestaurantStaff = [
                'title' => 'You have received a new booking request '.config('app.name'),
                'email' => $staff->email,
                'phone' => $staff->phone,
                'restaurantName' => $restaurant->name,
                'body' => 'This is the body of test email.',
                'view' => 'content.staff',
                'sms' => "Hi $staff->name, New booking request recieved. Please take action on this booking id {$reservationId}",
                'whatsapp' => 'Hi $staff->name, New booking request recieved. Please take action on this booking id {$reservationId}.',
                'replacements' => array_merge($request->all(), ['staff_name' => $staff->name, 'restaurantName' => $restaurant->name]),
                'type' => ['email', 'whatsapp']
            ];
        if ($mailToCustomer['email']) {
            Event::dispatch(new SendNotification($mailToCustomer));
        }
 	if ($mailToRestaurantStaff['email']) {
	   Event::dispatch(new SendNotification($mailToRestaurantStaff));
	}
        // Event::dispatch(new SendNotification($mailToRestaurantStaff));
        /*if(false){
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
        }*/

    	// Reservations::create($data);
    	return redirect('/food-service/?success=1')->with('addreservation', 'Thank you for your booking. Please wait for approval and check your Email for confirmation');
    }
}
