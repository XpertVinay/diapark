@extends('admin.adminmaster')

@section('content')

<!-- TABLE RESERVATION -->
<section class="order-list py-3 common-shadow">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row mb-5">
                    @if(session('adminpasschang'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('adminpasschang')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif
                    <div class="col-12">
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
<form method="GET" name="filterForm" id="filterForm">
      <input type="text" class="name" name="name" value="{{old('name') ?? $request->name}}" placeholder="Customer Name">
      <input type="text" class="email" name="email" value="{{old('email') ?? $request->email}}" placeholder="Cutomer Email">
      <input type="numnber" class="phone" name="phone" value="{{old('phone') ?? $request->phone}}" placeholder="Cutomer Phone">
      <input type="date" class="email" name="start" value="{{old('start') ?? $request->start}}" >
      <input type="date" class="phone" name="end" value="{{old('end') ?? $request->end}}" >
      <select id="status">
         <option value="">Select</option>
	 <option value="Approved">Approved</option>
      </select>
      <button type="submit" id="formFilter1" class="button">Search</button>
      <a href="/staff/tablereservation" class="button">Reset</a>
    </form>

                            <div class="card-body">
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
                                                    <td>
                                                        <a id="approve"  class="btn btn-info" data-toggle="modal" data-target="#enditreservation{{ $reservation->id }}">Approve</a>
                                                        {{-- <a href='{{url("/approve/{$reservation->id}/Approved")}}' class="btn btn-success m-1">Approve</a> --}}
                                                        <a href='{{url("/staff/deletereservation/{$reservation->id}")}}' class="btn btn-md btn-danger m-1">Cancel</a>
                                                    </td>
<!-- STUFF MODAL -->
<div class="modal fade" id="enditreservation{{ $reservation->id }}">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approve</h5>
                <button class="close text-light" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="{{url("/staff/approve")}}">
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
			<textarea class="form-control" col="5" row="5" placeholder="comment"></textarea>
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
		{{ $reservations->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('approve').addEventListner('click', () => {

    })
</script>

<!-- END TABLE RESERVATION-->
@endsection
