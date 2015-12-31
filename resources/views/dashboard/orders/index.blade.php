@extends('layouts.default')
@section('content')

<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('orders/list/ajax/'.$type) }}";
</script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script>
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>


<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/restaurant/orders_pending.blade.php"); ?>

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

@include('common.tabletools')
@include('popups.approve_cancel')

@stop