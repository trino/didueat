
<div class="alert alert-success" role="alert"
     style="<?php if(!isset($_GET['menuadd'])){?>display: none;<?php }?>">
    Item has been added/updated successfully
</div>

<div class="alert alert-success" role="alert"
     style="<?php if(!isset($_GET['sorted'])){?>display: none;<?php }?>">
    Menu item moved successfully
</div>

<?php Session();?>
@if (session('status')|| isset($_GET['flash']))
    <div class="alert alert-success">
        <?php if(isset($_GET['flash'])){?>
        <strong>Thank you!</strong>
        <?php if ($_GET['flash'] == '1')
            echo "your order has been received.";
        elseif ($_GET['flash'] == '2')
            echo "your order has been received and your account has been created successfully and you'll receive an activation email in shortly. Check your email to validate your account and login.";
        }else {
            session('status');
        }?>
    </div>
@endif

@if(\Session::has('invalid-data'))
    <?
    $fields = Session::get('invalid-data');
    $message = "The following field" . iif(count($fields) == 1, " is", "s are") . " invalid: <SPAN
                ID='invalid-fields'>" . implode(", ", $fields) . '</SPAN>';
    echo '
        <div class="alert alert-danger" ID="invalid-data"><STRONG>Invalid Data</STRONG>&nbsp;' . $message . '</DIV>';
    \Session::forget('invalid-data');
    ?>
@endif

@if(\Session::has('message-type') && Session::get('message'))
    <div class="alert {!! Session::get('message-type') !!}">
        <strong>{!! Session::get('message-short') !!}</strong>
        &nbsp; {!! Session::get('message') !!}
    </div>
    <?php \Session::forget('message'); ?>
@endif