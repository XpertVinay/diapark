@extends('admin.adminmaster')

@section('content')

<!-- DETAILS -->
<section class="common-shadow py-3">
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-xl-10 col-lg-9 col-md-8 ml-auto">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <div class="col-md-8">
                                    <h1 class="card-text" style="font-size: 1em">Staff</h1>
                                </div>

                                @if(session('addstaff'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('addstaff')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif
				@if(session('erraddstaff'))
                                <div class="alert alert-danger h3" id="msg">
                                    {{session('erraddstaff')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif

                                @if(session('deletestaff'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('deletestaff')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif
                                  @if(session('upstaff'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('upstaff')}}
                                    <button type="button" class="close pl-4" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                @endif
                                <div class="col-md-4">
                                    <button class="btn btn-lg btn-success ml-auto" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-plus-circle"></i> Add Staff</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-responsive table-hover text-center">
                                    <thead class="thead-background">
                                        <tr>
                                            <th scope="col">Staff ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Restaurant</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Address</th>
                                            @if(false) {{-- <th scope="col">Salary</th> --}}@endif
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if(!empty($staffs))
                                            @foreach($staffs as $staff)
                                                <tr>
                                                    <th scope="row">{{ $staff->id }}</th>
                                                    <td>{{ $staff->name }}</td>
                                                    <td>{{ $staff->restaurantName }}</td>
                                                    <td>{{ $staff->email }}</td>
                                                    <td>{{ $staff->phone }}</td>
                                                    <td>{{ $staff->address }}</td>
                                                    @if(false){{-- <td>{{ $staff->salary }}</td> --}}@endif
                                                    <td>
                                                        <button class="btn btn-md btn-primary mr-2" data-toggle="modal" data-target="#editUserModal{{ $staff->id }}">Edit</button>




                                                        <a href='{{url("/removestaff/{$staff->id}")}}' class="btn btn-md btn-danger m-1">Delete</a>

                                                        <!-- STUFF MODAL -->
<div class="modal fade" id="editUserModal{{ $staff->id }}">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Staff</h5>
                <button class="close text-light" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="{{route('editstaff.submit')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ $staff->name }}" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="restaurantid">Restaurant</label>
                        <select class="form-control" name="restaurantid" id="restaurantid" required="true">
                            <option>-- Select Option --</option>
                            @if(!empty($restaurants))
                                @foreach($restaurants as $restaurant)
                                    <option value="{{$restaurant->id}}" {{ $restaurant->id === $staff->restaurantid ? 'selected' : null }}>{{$restaurant->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" value="{{ $staff->email }}" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="text">Phone</label>
                        <input type="tel" name="phone" value="{{ $staff->phone }}" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="text">Address</label>
                        <input type="text" name="address" value="{{ $staff->address }}" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="text">Password</label>
                        <input type="text" name="password" value="" class="form-control" required="true">
                    </div>
                    <input type="hidden" name="stassid" value="{{ $staff->id }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- ./DETAILS -->

<!-- STUFF MODAL -->
<div class="modal fade" id="addUserModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Staff</h5>
                <button class="close text-light" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="{{route('doaddstaff.submit')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="restaurantid">Restaurant</label>
                        <select class="form-control" name="restaurantid" id="restaurantid" required="true">
                            <option>-- Select Option --</option>
                            @if(!empty($restaurants))
                                @foreach($restaurants as $restaurant)
                                    <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="text">Phone</label>
                        <input type="tel" name="phone" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="text">Address</label>
                        <input type="text" name="address" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="text">Password</label>
                        <input type="text" name="password" class="form-control" required="true">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- ./STUFF MODAL -->

@endsection
