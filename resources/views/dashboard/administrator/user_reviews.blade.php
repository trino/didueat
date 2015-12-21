@extends('layouts.default')
@section('content')
  <meta name="_token" content="{{ csrf_token() }}"/>
  <script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
  
  <div class="content-page">
    <div class="container-fluid">
      <div class="row">

        @include('layouts.includes.leftsidebar')

        <div class="col-xs-12 col-md-10 col-sm-8">
            <?php printfile("views/dashboard/administrator/user_reviews.blade.php"); ?>
          @if(\Session::has('message'))
            <div class="alert {!! Session::get('message-type') !!}">
              <strong>{!! Session::get('message-short') !!}</strong>
              &nbsp; {!! Session::get('message') !!}
            </div>
          @endif

          <div class="container-fluid">
            <div class="btn_wrapper margin-bottom-20 clearfix">
            </div>

            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="box-shadow">
              <div class="portlet-title">
                <div class="caption">
                  USER REVIEWS
                </div>
                <div class="tools">
                </div>
              </div>
              <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
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
                      <td> <a href="#editNewUser" class="btn red editUser fancybox-fast-view" data-id="{{ $rating->id }}">Edit</a>
                      <a href="{{ url('user/reviews/action/'.$rating->id) }}" class="btn red" onclick="return confirm('Are you sure to delete review  {{ addslashes("'" . $rating->rating . "'") }} ?');">Delete</a></td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
             <div id="editNewUser" class="col-md-12 col-sm-12 col-xs-12 popup-dialog" style="display: none;">
        <div class="modal-dialog2">
            <div class="fancy-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                </div>
                {!! Form::open(array('url' => '/user/reviews', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
                    <div id="editContents"></div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('common.tabletools')
   <script>
        $('body').on('click', '.editUser', function(){
            var id = $(this).attr('data-id');
            $.get("{{ url("user/reviews/edit") }}/"+id, {}, function(result){
                $('#editContents').html(result);
            });
        });
    </script>

@stop