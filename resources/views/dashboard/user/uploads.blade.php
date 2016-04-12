@extends('layouts.default')
@section('content')

    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
    <script type="text/javascript">
        window.showEntries = 10;
        window.page = 1;
        window.pageUrlLoad = "{{ url('user/uploads/ajax/' . $userid) . "?" . http_build_query($_GET) }}";
    </script>
    <script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
    <!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
    <script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>
    <STYLE>
        .thumbnail {
            max-width: 128px;
            max-height: 128px;
        }
    </STYLE>

    <div class="container">
        <div class="row">
            @include('layouts.includes.leftsidebar')

            <div class="col-lg-9">
                <?= printfile("views/dashboard/user/uploads.blade.php<BR>"); ?>
                <div id="ajax_message_jgrowl"></div>
                <div id="loadPageData">

                </div>
            </div>
        </div>
    </div>
    <SCRIPT>
        function deletepic(PicID, UserID, Filename) {
            if (confirm('Are you sure you want to delete "' + Filename + '"?')) {
                $("#deletepicbtn" + PicID).html('<i class="fa fa-spinner fa-spin"></i>');
                $.post("{{ url('ajax')}}", {
                    _token: "{{ csrf_token() }}",
                    type: "deletepic",
                    userid: UserID,
                    filename: Filename
                }, function (result) {
                    $("#deletepic" + PicID).fadeOut();
                });
            }
        }

        function deleteitem(ID, Name, Slug) {
            if (confirm('Are you sure you want to delete "' + Name + '"?')) {
                $("#deleteitembtn" + ID).html('<i class="fa fa-spinner fa-spin"></i>');
                $.post("{{ url('restaurant/deleteMenu')}}/" + ID + "/" + Slug, {_token: "{{ csrf_token() }}"}, function (result) {
                    $("#deleteitem" + ID).fadeOut();
                });
            }
        }
    </SCRIPT>
@stop