<div class="">
<?php
    Session();

    $data= array("menuadd", "sorted");
    foreach($data as $get){
        if(isset($_GET[$get])){
            popup(true, "message:" . $get);
        }
    }

    if(\Session::has('message-type') && Session::get('message')){
        popup(\Session::get('message-type'), Session::get('message'), \Session::get('message-short'));
        \Session::forget('message');
    }
?>

@if (session('status')|| isset($_GET['flash']))
    <div class="alert alert-success" style="margin-bottom:0px !important;">
        <div class="container" style="padding-top:0px !important;">
            <div class="row">
            <div class="col-md-12">

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <?php
            if(isset($_GET['flash'])){
                echo '';
                if ($_GET['flash'] == '1') {
                    echo "Your order has been received";
                } elseif ($_GET['flash'] == '2') {
                    echo "Your order has been received and your account has been created";
                }else {
                    session('status');
                }
            }

        ?>
<div class="clearfix"></div>
    </div>
    </div>
    </div>
    </div>

@endif


    <?
    $Restaurant = \Session::get('session_restaurant_id', 0);

    ?>

<?
  //  echo Session::get('session_restaurant_id');
    ?>
    @if ($Restaurant)



                    @include('common.required_to_open')

    @endif




@if(\Session::has('invalid-data'))
    <?php
        $fields = Session::get('invalid-data');
        $message = "The following field" . iif(count($fields) == 1, " is", "s are") . " invalid: <SPAN ID='invalid-fields'>" . implode(", ", $fields) . '</SPAN>';
        popup(false, $message, "Invalid Data", "invalid-data");
        \Session::forget('invalid-data');
    ?>
    <SCRIPT>
        //attempts to replace the field name with it's label for invalid data
        $(document).ready(function () {
            var element = document.getElementById("invalid-fields");
            if (element) {
                var fields = element.innerHTML.split(", ");
                for (i = 0; i < fields.length; i++) {
                    fields[i] = getfieldlabel(fields[i]);
                }
                element.innerHTML = fields.join(", ");
            }
        });

        function getfieldlabel(field) {
            element = document.getElementsByName(field)[0];
            if (element) {
                element = element.parentElement.parentElement;
                if (element) {
                    var children = element.children;
                    for (var j = 0; j < children.length; j++) {
                        element = children[j];
                        if (element.tagName = "label" && element.innerText) {
                            field = element.innerText;
                        }
                    }
                }
            }
            return field.replace(":", "");
        }
    </SCRIPT>
@endif
