@extends('layouts.default')
@section('content')



    delet this page




    <div class="row">
        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/restaurants.blade.php"); ?>
            <div class="card">
                <div class="card-header">


                    <h3>Restaurants
                    <a class="btn btn-primary btn-sm" href="{{ url('restaurant/add/new') }}">Add</a></h3>


                </div>
                <div class="card-block p-a-0">
                    <table class="table table-responsive m-b-0">
                        <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th width="10%">Logo</th>
                            <th width="15%">Name</th>
                            <th width="15%">Rating</th>
                            <th width="10%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($restaurants_list as $value)
                            <?php $resLogo = (isset($value->logo) && $value->logo != "") ? 'restaurants/' . $value->id . '/thumb_' . $value->logo : 'default.png'; ?>
                            <tr>
                                <td>{{ $value->id }}</td>
                                <td><img src="{{ asset('assets/images/'.$resLogo) }}" width="90"/></td>
                                <td>{{ $value->name }}</td>
                                <td>
                                    {!! rating_initialize("static-rating", "restaurant", $value['id'], true) !!}
                                </td>
                                <td>@if($value->open == true)Open @else Closed @endif
                                    @if($value->open == true)
                                        <a href="{{ url('restaurant/list/status/'.$value->id) }}"
                                           class="btn btn-warning btn-sm"
                                           onclick="return confirm('Are you sure you want to close {{ addslashes("'" . $value->name . "'") }} ?');">Close</a>
                                    @else
                                        <a href="{{ url('restaurant/list/status/'.$value->id) }}" class="btn  btn-success btn-sm"
                                           onclick="return confirm('Are you sure you want to open {{ addslashes("'" . $value->name . "'") }} ?');">Open</a>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ url('restaurant/orders/history/'.$value->id) }}"
                                       class="btn btn-primary-outline btn-sm">Orders</a>
                                    <a href="{{ url('restaurant/info/'.$value->id) }}"
                                       class="btn btn-info-outline btn-sm">Edit</a>

                                    <a href="{{ url('restaurant/list/delete/'.$value->id) }}"
                                       class="btn btn-danger-outline btn-sm"
                                       onclick="return confirm('Are you sure you want to delete {{ addslashes("'" . $value->name . "'") }} ?');">Delete</a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



@stop