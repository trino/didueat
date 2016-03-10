@extends('layouts.default')
@section('content')
    <meta name="_token" class="csrftoken" content="{{ csrf_token() }}"/>

    <script type="text/javascript">
        window.showEntries = 10;
        window.page = 1;
        window.pageUrlLoad = "{{ url('user/addresses/ajax/list') . "?" . http_build_query($_GET) }}";
    </script>
    <script src="{{ asset('assets/global/scripts/custom-datatable/blockUI.js') }}" type="text/javascript"></script>
    <!--script src="{{ asset('assets/global/scripts/custom-datatable/toastr.min.js') }}"></script-->
    <script src="{{ asset('assets/global/scripts/custom-datatable/custom-plugin-datatable.js') }}" type="text/javascript"></script>

    <div class="container">
        <?php printfile("views/dashboard/profiles_address/index.blade.php"); ?>
        <div class="row">
            @include('layouts.includes.leftsidebar')
            <div class="col-lg-9">
                <div id="ajax_message_jgrowl"></div>

                <!-- Panels Start -->
                <div id="loadPageData">

                </div>
            </div>
        </div>
    </div>


    @include('popups.addaddress')

    <script type="text/javascript">

        //handle the up/down change priority buttons
        $('body').on('click', '.up, .down', function () {
            var row = $(this).parents("tr:first");
            var token = $('#addressesForm input[name=_token]').val();
            var order = $(this).parents("tr:first").attr('data-order');

            if ($(this).is(".up")) {
                row.insertBefore(row.prev());
            } else {
                row.insertAfter(row.next());
            }

            $(".rows").each(function (index) {
                $(this).attr("data-order", index);
            });

            var data_id = $(".rows").map(function () {
                return $(this).attr("data-id");
            }).get();

            var data_order = $(".rows").map(function () {
                return $(this).attr("data-order");
            }).get();

            $.post("{{ url('user/addresses/sequence') }}", {
                id: data_id.join('|'),
                order: data_order.join('|'),
                _token: token
            }, function (result) {
                if (result) {
                    alert(result);
                }
            });
        });
    </script>

@stop