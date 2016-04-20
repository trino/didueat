@extends('layouts.default')
@section('content')
<?php
    if(read("profiletype") > 1 && !read("restaurant_id")){
        $_GET["user_id"] = read("id");
    }
?>
<meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('user/reviews/list/ajax') . "?" . http_build_query($_GET) }}";
</script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>
<div class="container">

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/user_reviews/index.blade.php"); ?>
        
        <div id="ajax_message_jgrowl"></div>
        
        <!-- Panels Start -->
        <div id="loadPageData">
            
        </div>
        
    </div>
</div>


<div class="modal clearfix" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        {!! Form::open(array('url' => '/user/reviews', 'name'=>'editForm', 'id'=>'addNewForm', 'class'=>'form-horizontal form-restaurants','method'=>'post','role'=>'form')) !!}
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="editModalLabel">Edit Review</h4>
            </div>
            <!--<div id="ajaxloader"></div>-->
            <div class="modal-body" id="contents">
                
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
</div>

<script>    
    $('body').on('click', '.editRow, #addNew', function() {
        var id = $(this).attr('data-id');
        if(id == null || id == undefined || id == ""){
            id = 0;
            $('#editLabel').text('Add Address');
        }
        $('.overlay_loader').show();
        $('#editModel #contents').html('');
        $.get("{{ url('user/reviews/edit') }}/" + id, {}, function (result) {
            $('.overlay_loader').hide();
            try {
                if (jQuery.parseJSON(result).type == "error") {
                var json = jQuery.parseJSON(result);
                        $('#editModel #message').show();
                        $('#editModel #message p').html(json.message);
                        $('#editModel #contents').html('');
                }
            } catch (e) {
                $('#editModel #message').hide();
                $('#editModel #contents').html(result);
            }
        });
    });
</script>
@stop