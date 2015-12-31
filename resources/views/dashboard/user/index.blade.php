@extends('layouts.default')
@section('content')

<meta name="_token" content="{{ csrf_token() }}"/>
<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('users/list/ajax') }}";
</script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/user/addresses.blade.php"); ?>
        
        @if(\Session::has('message'))
        <div class="alert {!! Session::get('message-type') !!}">
            <strong>{!! Session::get('message-short') !!}</strong>
            &nbsp; {!! Session::get('message-detail') !!}
        </div>
        @endif
        
        <div id="ajax_message_jgrowl"></div>
        
        <!-- Panels Start -->
        <div id="loadPageData">
            <div id="ajaxloader"></div>
        </div>
        
    </div>
</div>


<div class="modal  fade clearfix" id="editNewUser" tabindex="-1" role="dialog" aria-labelledby="editNewUserLabel"
         aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editNewUserLabel">Edit</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => '/restaurant/users/update', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
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

<script type="text/javascript">
    $('body').on('click', '.editUser', function () {
        var id = $(this).attr('data-id');
        $.get("{{ url("restaurant/users/edit") }}/" + id, {}, function (result) {
            $('#editContents').html(result);
        });
    });
</script>
<script src="{{ url("assets/global/scripts/provinces.js") }}" type="text/javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" title="edituser.blade" async defer></script>
@stop