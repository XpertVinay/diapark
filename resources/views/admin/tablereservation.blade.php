<style>
    .row > .col-xs-3 {
    display:flex;
    flex: 0 0 25%;
    max-width: 25%
}

.flex-nowrap {
    -webkit-flex-wrap: nowrap!important;
    -ms-flex-wrap: nowrap!important;
    flex-wrap: nowrap!important;
}
.flex-row {
    display:flex;
    -webkit-box-orient: horizontal!important;
    -webkit-box-direction: normal!important;
    -webkit-flex-direction: row!important;
    -ms-flex-direction: row!important;
    flex-direction: row!important;
}


.well {
    width: 100%;
}

.gallary-horizontal{
    width: 100%;
    overflow: scroll;
}

.blink {
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  0% {
    background-color: #ffff00;
    box-shadow: 0 0 3px #ffff00;
  }
  15% {
    background-color: #cc0000;
    box-shadow: 0 0 3px #cc0000;
  }
  25% {
    background-color: #ff3333;
    box-shadow: 0 0 3px #ff3333;
  }
  50% {
    background-color: #e6e600;
    box-shadow: 0 0 10px #e6e600;
  }
  65% {
    background-color: #cc0000;
    box-shadow: 0 0 3px #cc0000;
  }
  75% {
    background-color: #cc0000;
    box-shadow: 0 0 10px #cc0000;
  }
  100% {
    background-color: #ffff00;
    box-shadow: 0 0 3px #ffff00;
  }
}

  .carousel-inner > .item > img,
  .carousel-inner > .item > a > img {
    width: 100%;
    margin: auto;
  }
  
  .carousel-inner2 > .item > img,
  .carousel-inner2 > .item > a > img {
    width: 100%;
    margin: auto;
    min-height: 150px;
  }
  
  .carousel-inner1 > .item > img,
  .carousel-inner1 > .item > a > img {
    width: 100%;
    margin: auto;
    min-height: 150px;
  }

</style>


@extends('admin.adminmaster')

@section('content')

<!-- TABLE RESERVATION -->
<section class="order-list py-3 common-shadow">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row mb-5">
                    <div class="col-12"style="height: 100vh">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h1 class="card-text" style="font-size: 1em">Reservations</h1>
                                 @if(session('tableapprove'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('tableapprove')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif

                                @if(session('deletereservationtable'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('deletereservationtable')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif
                            </div>

<form method="POST" action="/csv-reservation" name="csvForm" id="filterForm">
	@csrf()
      <input type="hidden" class="form-control" name="name" value="{{old('name') ?? $request->name}}" placeholder="Customer Name">
      <input type="hidden" class="form-control" name="email" value="{{old('email') ?? $request->email}}" placeholder="Cutomer Email">
      <input type="hidden" class="form-control" name="phone" value="{{old('phone') ?? $request->phone}}" placeholder="Cutomer Phone">
      <input type="hidden" class="form-control" name="start" value="{{old('start') ?? $request->start}}" >
      <input type="hidden" class="form-control" name="end" value="{{old('end') ?? $request->end}}" >
      <select id="status" name="status" style="display: none">
         <option value="">Select</option> 
	 <option value="Approved" {{ @$request->status == 'Approved' ? 'selected' : '' }} >Approved</option>
	 <option value="Pending" {{ @$request->status == 'Pending' ? 'selected' : '' }}>Pending</option>

      </select>
      <button type="submit" id="csvForm" class="btn btn-success">CSV</button>
    </form>

<form method="GET" name="filterForm" id="filterForm">
   <div class="col-md-12 row">
      <div class="col-md-3"><input type="text" class="form-control" name="name" value="{{old('name') ?? $request->name}}" placeholder="Customer Name"></div>
      <div class="col-md-3"><input type="text" class="form-control" name="email" value="{{old('email') ?? $request->email}}" placeholder="Cutomer Email"></div>
      <div class="col-md-3"><input type="numnber" class="form-control" name="phone" value="{{old('phone') ?? $request->phone}}" placeholder="Cutomer Phone"></div>
      <div class="col-md-3"><input type="date" class="form-control" name="start" value="{{old('start') ?? $request->start}}" ></div>
      <div class="col-md-3"><input type="date" class="form-control" name="end" value="{{old('end') ?? $request->end}}" ></div>
      <div class="col-md-3">
      <select class="form-control" id="status" name="status">
         <option value="">Select</option>
	 <option value="Approved" {{ @$request->status == 'Approved' ? 'selected' : '' }} >Approved</option>
         <option value="Pending" {{ @$request->status == 'Pending' ? 'selected' : '' }}>Pending</option>
      </select>
      </div>
  </div>
  <div class="col-md-12">
      <button type="submit" id="formFilter1" class="btn btn-primary">Search</button>
      <a href="/tablereservation" class="btn btn-info">Reset</a>
   </div>
</form>

<a class="btn btn-warning btn-lg blink" id="bookingRes" target="_blank" href="/food-service?admin=1">Book a Table</a>



<!-- Modal -->
<div id="reservationBooking" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
  
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <div class="">
            @if(session('addreservation'))
            <div class="alert alert-success" role="alert">
                {{session('addreservation')}}
            </div>
            @endif
                <div class="card my-5" style="">
                    <div class="card-body col-md-12">
                        <form action="{{route('doreservation.submit')}}" method="POST" id="reservationForm">
                            @csrf
                            <div class="form-group" id="siteHeader" style="position: relative !important;">
                                <!-- <center><label for="restaurantid" class="col-form-lable" style="font-size: 2.0em; color: white">RESERVE FOR</label></center> -->
                                <select class="form-control" name="restaurantid" id="restaurantid" required="true" style="text-align: center; font-size: 2.0em; height: 56px;">
                                    <option value="">-- Choose Restaurant --</option>
                                    @if(!empty($restaurants))
                                        @foreach($restaurants as $restaurant)
                                            <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                <div class="col-md-12">
                    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name2" class="col-form-label">Name-Company Name</label>
                                    <div class="">
                                        <input type="text" name="name" class="form-control" id="name2" placeholder="Name-Company Name" required="true">
                                    </div>
                                </div>
                    </div>
                    <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email2" class="col-form-label">Email</label>
                                    <div class="">
                                        <input type="email" name="email" class="form-control" id="email2" placeholder="Email" required="true">
                                    </div>
                                </div>
                        </div>
                </div>
                <div class="col-md-12">
			    <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="col-form-label">Phone (Country code not required)</label>
                                <div class="">
                                    <input type="number" name="phone" class="form-control" id="phone" placeholder="Mobile Number without Country code" required="true">
                                </div>
                            </div>
			    </div>
			   <div class="col-md-6">
                            <div class="form-group">
                                <label for="occasion" class="col-form-lable">Event</label>
                                <div class="">
                                    <select class="form-control" name="occasion" id="occasion" required="true">
                                        <option>-- Select Option --</option>
                                        <option value="Corporate Party">Event</option>
                                        <option value="Kitty Party">Birthday</option>
                                        <option value="Bachelor Party">Family Gathering </option>
                                        <option value="Birthday">Company Meeting</option>
                                        <option value="Anniversary">Welcome Party</option>
                                        <option value="Sympathy">Farewell Party</option>
                                        <option value="Christmas">After Golf</option>
                                        <option value="New Baby">Anniversary</option>
                                    </select>
                                </div>
                            </div>
                        </div>
			    </div>
                <div class="col-md-12">
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Time of Arrival</label>
                                <div class="col">
                                    <input type="datetime-local" name="starttime" class="form-control" placeholder="On which date" required="true" value="">
                                </div>
                            </div>
			    </div>
			    <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Reserved Time</label>
                                <div class="col">
                                    <!-- <input type="datetime-local" name="endtime" class="form-control" placeholder="On which date" required="true" value=""> -->
					<select name='endtime' class='form-control'>
						<option value='1'>1 Hour</option>
						<option value='2'>2 Hour</option>
						<option value='3'>3 Hour</option>
						<option value='4'>4 Hour</option>
						<option value='5'>5 Hour</option>
					</select>

                                </div>
                            </div>
			    </div>
            </div>
          <div class="col-md-12">
                            <div class="form-group row">
				<div class="col-md-12">
				<div class="col-md-6">
                                <label for="guest" class="col-form-label">No of Guest</label>
                                <div class="">
                                    <input type="number" name="male" class="form-control" id="male" placeholder="Guest" onclick="addRequiredForField()">
                                </div>
				</div>
                                <!-- <div class="">
                                    <input type="number" name="female" class="form-control" id="female" placeholder="Female Guest" onclick="addRequiredForField()">
                                </div> -->
				<div class="col-md-6">
                                <div class="">
                                    <input type="number" name="child" class="form-control" id="child" placeholder="Child Under 7 Year">
                                </div>
				</div>
				</div>
			</div>
        </div>

	<div class="col-md-12">
		<div class="form-group">
                        <label for="guest" class="col-form-label">Comment</label>
			<textarea class="form-control" name="customer_comment" placeholder="comment"></textarea>
                 </div>

	</div>

	<div class="col-md-12">
                            <div class="form-group">
                                    <div class="col-md-5" style="margin-top: 20px;">
                                        <input type="checkbox" name="whatsapp" class="" id="whatsapp" checked>
                                        I agree to be contacted via whatsapp <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-whatsapp" viewBox="0 0 16 16">
  <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
</svg>
                                    </div>
                            </div>
       </div>
       <div class="col-md-12">
                            <div class="form-group">
                                    <div class="col-md-12">
                                        <center><button type="submit" id="reserve" class="btn btn-info">Book Your Table</button></center>
                                    </div>
                            </div>
       </div>

                            </div>
                            <div class="row mx-md-n5" style="margin-top:10px">
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
      </div>
   </div>
 </div><br> 

<div class="card-body">
				<div class="search-container">
		                     <table class="table table-responsive table-striped text-center">
                                    <thead class="thead-background">
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Start</th>
                                            <th scope="col">End</th>
                                            <th scope="col">Guest No</th>
                                            <th scope="col">Reserved For</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Customer Comment</th>
                                            <th scope="col">Comment</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($reservations))
                                            @foreach($reservations as $reservation)
                                                <tr>
                                                    <th scope="row">{{ $reservation->id }}</th>
                                                    <td>{{ $reservation->name }}</td>
                                                    <td>{{ $reservation->email }}</td>
                                                    <td>{{ $reservation->phone }}</td>
                                                    <td>{{ date('d M Y h:i:s', strtotime($reservation->starttime)) }}</td>
                                                    <td>{{ date('d M Y h:i:s', strtotime($reservation->endtime)) }}</td>
                                                    <td>{{ 'Male-'.intval($reservation->male).' | '.'Female-'.intval($reservation->female).' | '.'Child-'.intval($reservation->child) }}</td>
                                                    <td>{{ $reservation->restaurantName }}</td>
                                                    <td>{{ $reservation->status }}</td>
                                                    <td>{{ $reservation->customer_comment }}</td>
                                                    <td>{{ $reservation->comment }}</td>
                                                    <td>
                                                        <a id="approve"  class="btn btn-info" data-toggle="modal" data-target="#enditreservation{{ $reservation->id }}">Approve</a>
                                                        {{-- <a href='{{url("/approve/{$reservation->id}/Approved")}}' class="btn btn-success m-1">Approve</a> --}}
                                                        <a href='{{url("/deletereservation/{$reservation->id}")}}' class="btn btn-md btn-danger m-1">Cancel</a>
                                                    </td>
<!-- STUFF MODAL -->
<div class="modal fade" id="enditreservation{{ $reservation->id }}">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve</h5>
                <button class="close text-light" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="{{url("/approve")}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="endtime">Postponed Date</label>
                        <input type="datetime-local" name="starttime" value="{{ $reservation->starttime }}" class="form-control" required="true">
                        <input type="datetime-local" name="endtime" value="{{ $reservation->endtime }}" class="form-control" required="true">
                        <div class="form-group row">
                            <label for="guest" class="col-3 col-form-label">No of Guest</label>
                            <div class="col-3">
                                <input type="number" name="male" class="form-control" id="male" placeholder="Male Guest" value="{{ $reservation->male }}">
                            </div>
                            <div class="col-3">
                                <input type="number" name="female" class="form-control" id="female" placeholder="Female Guest" value="{{ $reservation->female }}">
                            </div>
                            <div class="col-3">
                                <input type="number" name="child" class="form-control" id="child" placeholder="Child Guest" value="{{ $reservation->child }}">
                            </div>
                            </div>
                        </div>
			<textarea class="form-control" name="comment" col="5" row="5" placeholder="comment">{{ $reservation->comment }}</textarea>
                        <input type="hidden" name="id" value="{{ $reservation->id }}" class="form-control" required="true">
                        <input type="hidden" name="name" value="{{ 'Approved' }}" class="form-control" required="true">
                    </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- ./STUFF MODAL -->
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
			{{ $reservations->appends($_GET)->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

</script>

<!-- END TABLE RESERVATION-->
@endsection
