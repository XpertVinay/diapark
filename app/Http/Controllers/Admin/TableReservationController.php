<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Reservations;
use App\Models\Restaurants;
use App\Staffs;
use App\Notification\Notifications;
use Event;
use Maatwebsite\Excel\Facades\Excel;

class TableReservationController extends Controller
{
	public function __construct()
	{
	    $this->middleware('auth');
	}



    public function tablereservation(Request $request)
    {
    	$reservations = Reservations::select('reservations.*', 'res.name as restaurantName')
                            ->leftjoin('restaurants as res', function($join)
                            {
                              $join->on('res.id', '=', 'reservations.restaurantid');
                              $join->where('res.deleted_at', '=', NULL);
                            })
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
                $query->whereDate('reservations.starttime', $request->start);
            }else if($request->end && !$request->start) {
                $query->whereDate('reservations.endtime', $request->end);
            }else if($request->start && $request->end) {
                $query->whereDate('reservations.starttime', '>=', $request->start);
                $query->whereDate('reservations.endtime', '<=', $request->end);
            }

			    })
        		    ->orderBy('id', 'desc')
                            ->paginate(10);
			    // ->toSql();
// print_r($reservations); exit;
    	return view('admin.tablereservation', ['reservations'=>$reservations, 'request' => $request]);
    }

    public function approve(Request $request){
        $id = $request->id;
        $name = $request->name;

	// echo "<pre>"; print_r($request->all()); exit();

	 // notifications only email
        $reservation = Reservations::where('id', $id)->first();

        $restaurant = Restaurants::where('id', $reservation->restaurantid)->first();
        $staff = Staffs::where('id', $reservation->restaurantid)->first();
	$totalReservations = Reservations::select('id', 'male', 'female', 'child')
			->where('restaurantid', $reservation->restaurantid)
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
        $reservation->comment = $request->comment;
        $reservation->save();
	

        $mailToCustomer = [
            'title' => 'Update on your recent booking from '.$restaurant->name,
            'email' => $reservation->email,
            'phone' => $reservation->phone,
            'restaurantName' => $restaurant->name,
            'body' => 'This is the body of test email.',
            'view' => 'content.updateres',
            'sms' => "Dear ".$reservation->name .",\n Your booking {ref id - ".$reservation->id."} for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been confirmed, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
            'whatsapp' => "Dear ".$reservation->name .",\n Your booking {ref id - ".$reservation->id."} for $restaurant->name on " . date('d M Y, H:i:s', strtotime($request->starttime)). " has been confirmed, for any update or change please contact ". $staff->name ." ". $staff->phone . "\nThank you for your booking !!",
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

    public function reservationCsv (Request $request) {
try{
   	$reservations = Reservations::select('reservations.*', 'res.name as restaurantName')
                            ->leftjoin('restaurants as res', function($join)
                            {
                              $join->on('res.id', '=', 'reservations.restaurantid');
                              $join->where('res.deleted_at', '=', NULL);
                            })
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
                $query->whereDate('reservations.starttime', $request->start);
            }else if($request->end && !$request->start) {
                $query->whereDate('reservations.endtime', $request->end);
            }else if($request->start && $request->end) {
                $query->whereDate('reservations.starttime', '>=', $request->start);
                $query->whereDate('reservations.endtime', '<=', $request->end);
            }

			    })
        		    ->orderBy('created_at', 'desc')
			    ->get();
	$fileName = 'reservation-'.time().'.csv';
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
	$columns = array('Name', 'Email', 'Phone', 'Start Time', 'End Time', 'Guest No', 'Reserved For', 'Status', 'Comment');
	$callback = function() use($reservations, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($reservations as $task) {
                $row['Name']  = $task->name;
                $row['Email']    = $task->email;
                $row['Phone']    = $task->phone;
                $row['Start Time']  = $task->starttime;
                $row['End Time']  = $task->endtime;
                $row['Guest No']  = intval($task->male) + intval($task->child);
                $row['Reserved For']  = $task->restaurantName;
                $row['Status']  = $task->status;
                $row['Comment']  = $task->comment;

                fputcsv($file, array($row['Name'], $row['Email'], $row['Phone'], $row['Start Time'], $row['End Time'], $row['Guest No'], $row['Reserved For'], $row['Status'], $row['Comment']));
            }

            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
	// return \Response::download($callback, 'reservation'.time().'.csv', $headers);
}catch(\Exception $e){
		print_r($e->getMessage());
}
        }
}
