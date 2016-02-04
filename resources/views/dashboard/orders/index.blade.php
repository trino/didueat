@extends('layouts.default')
@section('content')
    <?php if(!isset($id)){$id  = '';} ?>
    <script type="text/javascript">
        window.showEntries = 10;
        window.page = 1;
        window.pageUrlLoad = "{{ url('orders/list/ajax/' . $type . '/' . $id) . "?" . http_build_query($_GET) }}";
    </script>
    <script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
    <!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
    <script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>

    <div class="row">
        @include('layouts.includes.leftsidebar')
        <div class="col-lg-9">
            <?php printfile("views/dashboard/orders/index.blade.php"); ?>
            <div id="ajax_message_jgrowl"></div>
            <div id="loadPageData">
                <div id="ajaxloader"></div>
            </div>
        </div>
    </div>

    @include('popups.approve_cancel')
@stop