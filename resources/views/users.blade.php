
@extends('layouts.default')

@section('content')

<?php
  // test values
  $salesTax=2.99;
  $orderID=80;

?>

<?php printfile("views/users.blade.php"); ?>
    <div class="container">

    <div class="row">

            <div class="card">
                <div class="card-header">
                    <h4 id='paymentmsg'>My Payment Confirm</h4>
									
									{!! Form::open(array('url' => '/users', 'id'=>'paymentForm','class'=>'form-horizontal','method'=>'post','role'=>'form')) !!}


									@include("stripe", array("user_detail" => $user_detail, "mobile" => true))
         
									<br/>(Set to hidden when finished testing)<input name="user_id" type="text" value='{{ Session::get('session_id') }}' /> 
         <input name="taxpd" type="text" value='{{ $salesTax }}' /><input name="orderID" type="text" value='{{ $orderID }}' />

									{!! Form::close() !!}

<script>

<?php

if(isset($user_detail->paymsg)){
 echo 'document.getElementById("paymentmsg").innerHTML="'.$user_detail->paymsg.'";';
}


?>

</script>
                </div>

    </div>

    </div>
    </div>
  

@stop