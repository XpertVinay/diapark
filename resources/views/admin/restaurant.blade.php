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
                                    <h1 class="card-text" style="font-size: 1em">Restaurants</h1>
                                </div>

                                @if(session('addrestaurant'))
                                <div class="alert alert-success h3" id="msg">
                                    {{session('addrestaurant')}}
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
                                
                            </div>
                            <div class="card-body">
                                <div class="col-md- float-right">
                                    <button class="btn btn-lg btn-success ml-auto" data-toggle="modal" data-target="#addUserModal"><i class="fas fa-plus-circle"></i> Add Restaurant</button>
                                    </div>
                                <table class="table table-responsive table-hover text-center">
                                    <thead class="thead-background">
                                        <tr>
                                            <th scope="col">Restaurant ID</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Capacity</th>
                                            <th scope="col">Created On</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @if(!empty($restaurants))
                                            @foreach($restaurants as $restaurant)
                                                <tr>
                                                    <th scope="row">{{ $restaurant->id }}</th>
                                                    <td>{{ $restaurant->name }}</td>
                                                    <td>{{ $restaurant->description }}</td>
                                                    <td>{{ $restaurant->capacity }}</td>
                                                    <td>{{ $restaurant->created_at->format('M d Y') }}</td>
                                                    <td>
                                                        <button class="btn btn-md btn-primary mr-2" data-toggle="modal" data-target="#editRestaurant{{ $restaurant->id }}">Edit</button>




                                                        <a href='{{url("/removerestaurant/{$restaurant->id}")}}' class="btn btn-md btn-danger m-1">Delete</a>

                                                        <!-- STUFF MODAL -->
<div class="modal fade" id="editRestaurant{{ $restaurant->id }}" style="position: absolute; ">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Staff</h5>
                <button class="close text-light" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="{{route('editrestaurant.submit')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" value="{{ $restaurant->name }}" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" required="true">{{ $restaurant->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="capacity">capacity</label>
                        <input type="number" min="0" max="500" name="capacity" value="{{ $restaurant->capacity }}" class="form-control" required="true">
                    </div>
                    <input type="hidden" name="restaurantid" value="{{ $restaurant->id }}">
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
                <h5 class="modal-title">Add Restaurant</h5>
                <button class="close text-light" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form method="POST" action="{{route('doaddrestaurant.submit')}}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control" required="true">
                    </div>
                    <div class="form-group">
                        <label for="description">description</label>
                        <textarea name="description" class="form-control" required="true"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="capacity">Capacity</label>
                        <input type="number" name="capacity" class="form-control" required="true" min="0" max="500">
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
