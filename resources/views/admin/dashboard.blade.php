@extends('admin.adminmaster')

@section('content')
    <!-- DASHBOARD-BAR -->
    <section class="dashbar py-3 bg-white">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">
                    @if(session('adminpasschang'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('adminpasschang')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif

                </div>

                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body d-flex justify-content-between">
                                    <i class="fas fa-table fa-2x mt-2"></i>
                                    <div>
                                        <h1 class="m-0 text-right">
                                          {{$totalorder}}


                                        </h1>
                                        <p>Restaurant Count</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body d-flex justify-content-between">
                                    <i class="fas fa-align-justify fa-2x mt-2"></i>
                                    <div>
                                        <h1 class="m-0 text-right">{{$totalitem}}</h1>
                                        <p>Total Reservations</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between">
                                    <i class="fas fa-users fa-lg mr-2"></i>
                                    <div>
                                        <h1 class="m-0 text-right">{{$staffs}}</h1>
                                        <p>Total Staff</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- ./DASHBOARD-BAR -->

    <!-- REVENUE -->
    <section class="py-3 revenue bg-white common-shadow">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">6 month's matrix</h4>
                                </div>

                                <div class="card-body">
                                    <canvas id="donught" style="display: block;" width="600" height="450" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Recent Reservation</h4>
                                </div>

                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead class="border-top-0">
                                            <tr>
                                                <th scope="col">Id No</th>
                                                <th scope="col">Customer Name</th>
                                                <th scope="col">Restaurant Name</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if(!empty($orders))
                                            @foreach($orders as $order)
                                            <tr>
                                                <th scope="row">{{$order->id}}</th>
                                                <td>{{$order->name}}</td>
                                                <td>{{$order->restName}}</td>
                                            </tr>
                                            @endforeach
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ./REVENUE -->

@endsection
