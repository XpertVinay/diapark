@extends('layout.master')

@section('content')

<!-- RESERVATION -->
<div class="reservation pt-5">
    <h1 class="h1 text-center font-weight-bold text-uppercase mt-4">Reservation</h1>
    <div class="title-bottom"></div>
    <div class="container-fluid">

        @if(session('addreservation'))
        <div class="alert alert-success h3" id="msg">
            {{session('addreservation')}}
            <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        @endif

        <div class="row gutters">
            <div class="col-6">
                <div class="card my-5" style="box-shadow: 0px 0px 2px 2px #ccc;">
                    <div class="card-body">
                        <img src="img/reservation.jpg" alt="" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card my-5" style="box-shadow: 0px 0px 2px 2px #ccc;">
                    <h3 class="card-header text-center">Table Reservation</h3>
                    <div class="card-body">
                        <form action="{{route('doreservation.submit')}}" method="POST" id="reservationForm">
                            @csrf
                            <div class="form-group row">
                                <label for="name2" class="col-3 col-form-label">Name</label>
                                <div class="col-9">
                                    <input type="text" name="name" class="form-control" id="name2" placeholder="Name" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="email2" class="col-3 col-form-label">Email</label>
                                <div class="col-9">
                                    <input type="email" name="email" class="form-control" id="email2" placeholder="Email" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-3 col-form-label">Phone</label>
                                <div class="col-9">
                                    <input type="number" name="phone" class="form-control" id="phone" placeholder="Phone" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="occasion" class="col-3 col-form-lable">Occasion</label>
                                <div class="col-9">
                                    <select class="form-control" name="occasion" id="occasion" required="true">
                                        <option>-- Select Option --</option>
                                        <option value="Corporate Party">Corporate Party</option>
                                        <option value="Kitty Party">Kitty Party</option>
                                        <option value="Bachelor Party">Bachelor Party</option>
                                        <option value="Birthday">Birthday</option>
                                        <option value="Anniversary">Anniversary</option>
                                        <option value="Sympathy">Sympathy</option>
                                        <option value="Christmas">Christmas</option>
                                        <option value="New Baby">New Baby</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="restaurantid" class="col-3 col-form-lable">Reserve For</label>
                                <div class="col-9">
                                    <select class="form-control" name="restaurantid" id="restaurantid" required="true">
                                        <option>-- Select Option --</option>
                                        @if(!empty($restaurants))
                                            @foreach($restaurants as $restaurant)
                                                <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Planned Arival</label>
                                <div class="col">
                                    <input type="datetime-local" name="starttime" class="form-control" placeholder="On which date" required="true" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-3 col-form-label">Planned Departure</label>
                                <div class="col">
                                    <input type="datetime-local" name="endtime" class="form-control" placeholder="On which date" required="true" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="guest" class="col-3 col-form-label">No of Guest</label>
                                <div class="col-3">
                                    <input type="number" name="male" class="form-control" id="male" placeholder="Male Guest">
                                </div>
                                <div class="col-3">
                                    <input type="number" name="female" class="form-control" id="female" placeholder="Female Guest">
                                </div>
                                <div class="col-3">
                                    <input type="number" name="child" class="form-control" id="child" placeholder="Child Guest">
                                </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-2">
                                    <input type="checkbox" name="whatsapp" class="form-control" id="whatsapp">
                                </div>
                                <div class="col-9">
                                    I agree to contacted via whatsapp.
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-10">
                                    <button type="submit" id="reserve" class="btn btn-info">Book Your Table</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function onSubmit(){
        e.preventDefault();
        const male = document.getElementById('male').value;
        const female = document.getElementById('female').value;
        const child = document.getElementById('child').value;

        console.log(male, female, child);

        if (!male && !female && !child ) {
            $('#male').attr('required', 'required');
            return false;
        }
        return true;
    }

    document.getElementById("reservationForm").addEventListener("submit", function(e){
        e.preventDefault();
        const male = document.getElementById('male').value;
        const female = document.getElementById('female').value;
        const child = document.getElementById('child').value;

        console.log(male, female, child);

        if (!male && !female && !child ) {
            $('#male').attr('required', 'required');
            return false;
        }
        document.getElementById("reservationForm").submit();
        return true;
    });
</script>

@endsection
