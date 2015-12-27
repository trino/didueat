@extends('layouts.default')
@section('content')
    <meta name="_token" content="{{ csrf_token() }}"/>
    <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>

    <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-lg-9">
            <?php printfile("views/dashboard/administrator/user_reviews.blade.php"); ?>
            @if(\Session::has('message'))
                <div class="alert {!! Session::get('message-type') !!}">
                    <strong>{!! Session::get('message-short') !!}</strong>
                    &nbsp; {!! Session::get('message') !!}
                </div>
            @endif


                <div class="card">
                    <div class="card-header bg-primary">


                        Reviews


                    </div>
                    <div class="card-block p-a-0">
                <table class="table table-striped table-responsive" id="sample_1">
                            <thead>
                            <tr>
                                <th width="6%">ID</th>
                                <th width="12%">User</th>
                                <th width="20%">Target</th>
                                <th width="7%">Type</th>
                                <th width="5%">Rating</th>
                                <th width="25%">Comment</th>
                                <th width="15%">Comment Date</th>
                                <th width="10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($ratings as $rating)
                                <tr>
                                    <td>{{ $rating->id  }}</td>
                                    <td>{{ select_field("profiles", "id", $rating->user_id, "name")  }}</td>
                                    <td>{{ ($rating->type == "menu")?select_field("menus", "id", $rating->target_id, "menu_item"):select_field("restaurants", "id", $rating->target_id, "name")  }}</td>
                                    <td>{{ $rating->type  }}</td>
                                    <td>{{ $rating->rating  }}</td>
                                    <td>{{ substr($rating->comments, 0, 100) }}</td>
                                    <td>{{ $rating->created_at  }}</td>
                                    <td>



                                        <a class="btn btn-info btn-sm editUser" data-toggle="modal" data-target="#editReviewModal"  data-id="{{ $rating->id }}">
                                            Edit
                                        </a>

                                        <a href="{{ url('user/reviews/action/'.$rating->id) }}" class="btn btn-danger btn-sm"
                                           onclick="return confirm('Are you sure to delete review  {{ addslashes("'" . $rating->rating . "'") }} ?');">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>



            </div>
            </div>
        </div>
    </div>



    <div class="modal  fade clearfix" id="editReviewModal" tabindex="-1" role="dialog" aria-labelledby="editReviewModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="editReviewModalLabel">Edit Review</h4>
                </div>
                <div class="modal-body">


                    {!! Form::open(array('url' => '/user/reviews', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    <div id="editContents"></div>
                    {!! Form::close() !!}



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>


    @include('common.tabletools')



    <script>
        $('body').on('click', '.editUser', function () {
            var id = $(this).attr('data-id');
            $.get("{{ url("user/reviews/edit") }}/" + id, {}, function (result) {
                $('#editContents').html(result);
            });
        });
    </script>




@stop