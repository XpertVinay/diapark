<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservations;
use App\Models\Restaurants;
use App\Staffs;
use Event;
use App\Notification\Notifications;

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
			    ->where(function($query) use ($request) {
				if($request->name)  {
                $query->where('reservations.name', 'LIKE', '%'.$request->name.'%');
            }
            if($request->email)  {
                $query->where('reservations.email', $request->email);
            }
            if($request->phone)  {
                $query->where('reservations.phone', $request->phone);
            }
            if($request->status)  {
                $query->where('reservations.status', $request->status);
            }
            if($request->restaurant_name)  {
                $query->where('res.name', 'LIKE', '%'.$request->restaurant_name.'%');
            }
            if($request->start && !$request->end)  {
                $query->where('reservations.starttime', $request->start);
            }else if($request->end && !$request->start)  {
                $query->where('reservations.endtime', $request->endtime);
            }else if($request->start && $request->end) {
                $query->where('reservations.starttime', '>=', $request->start);
                $query->where('reservations.endtime', '<=', $request->end);
            }
			    })
                            ->orderBy('reservations.created_at', 'desc')
                             // ->toSql();
                            ->paginate(5);
                            // ->get();
    	return view('staff.tablereservation', ['reservations'=>$reservations, 'request' => $request]);
    }


    public function approve(Request $request){
        $id = $request->id;
        $name = $request->name;

	 // notifications only email
        $reservation = Reservations::where('id', $id)->first();

        $restaurant = Restaurants::where('id', $reservation->restaurantid)->first();
	$staff = Staffs::where('id', $reservation->restaurantid)->first();
	$totalReservations = Reservations::select('id', 'male', 'female', 'child')
			->where('restaurantid', $id)
			->where('starttime', '>=', $request->starttime)
			->where('endtime', '<=', $request->endtime)
			->get();
			// ->toSql();
			//->count();
	// print_r($totalReservations); exit;
	$totalCount = 0; // count($totalReservations);
	foreach($totalReservations as $res){
		$totalCount += intval($res->male) + intval($res->female) + intval($res->child);
	}

	if(intval($totalCount) > intval($restaurant->capacity) ){
		return redirect('/tablereservation')->with('tableapprove', "Exceeding capacity by ". strval(intval($restaurant->capacity) - intval($totalCount)) .	". Contact admin for increase in capacity");
	}


        $reservation->starttime = $request->starttime;
        $reservation->endtime = $request->endtime;
        $reservation->status = $name;
        $reservation->male = $request->male;
        $reservation->female = $request->female;
        $reservation->child = $request->child;
        $reservation->save();


        $mailToCustomer = [
            'title' => 'Update on your recent booking from '.$restaurant->name,
            'email' => $reservation->email,
            'phone' => $reservation->phone,
            'restaurantName' => $restaurant->name,
            'body' => 'This is the body of test email.',
            'view' => 'content.updateres',
            'sms' => "Dear ".$reservation->name .",\n Your booking {ref id - ".$reservation->id."} for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been confirmed, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'whatsapp' => "Dear ".$reservation->name .",\n Your booking {ref if - ".$reservation->id."} for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been confimed, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'replacements' => array_merge($request->all(), ['restaurantName'=>$restaurant->name, 'sstart'=>$request->starttime, 'send'=>$request->endtime, 'name'=>$reservation->name]),
	        'type' => ['sms', 'email', 'whatsapp']
        ];
        // notifications only email
        //dd($reservation);
        if($reservation->email){
            Event::dispatch(new Notifications($mailToCustomer));
        }

      	// Reservations::where('id', $id)->update($data);
      	return redirect('/staff/tablereservation')->with('tableapprove', "Resevation is Approved.");
    }

    public function deletereservation($id){
      	Reservations::where('id', $id)->delete();
        return redirect('/staff/tablereservation')->with("deletereservationtable", "Resevation is successfully Removed");
    }
}
