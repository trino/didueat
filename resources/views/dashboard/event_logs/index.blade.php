@extends('layouts.default')
@section('content')

<meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>
<script type="text/javascript">
    window.showEntries = 10;
    window.page = 1;
    window.pageUrlLoad = "{{ url('eventlogs/list/ajax') . "?" . http_build_query($_GET) }}";
</script>
<script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
<!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
<script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>
<div class="container">

<div class="row">
    @include('layouts.includes.leftsidebar')

    <div class="col-lg-9">
        <?php printfile("views/dashboard/user/event_logs/index.blade.php"); ?>

        <div id="ajax_message_jgrowl"></div>

        <!-- Panels Start -->
        <div id="loadPageData">
            
        </div>

    </div>
</div>
</div>


@stop