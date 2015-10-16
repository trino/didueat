@extends('layouts.default')
@section('content')


<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="content-page">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="">

                </div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 no-padding">
            <div class="row">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-10 col-sm-8">
                    @if(\Session::has('message'))
                        <div class="alert {!! Session::get('message-type') !!}">
                            <strong>{!! Session::get('message-short') !!}</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif
                    
                    <div class="deleteme orders_details">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Orders List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                                <div class="portlet-body">
                                <?php
                                
                                    $restaurant = \App\Http\Models\Restaurants::where('id', $order->restaurant_id)->first();    ?>
                                      <div class="infolist noprint margin-top-10"><strong>RESTAURANT NAME: </strong><?= $restaurant->name;?></div>
                                      <div class="infolist noprint"><strong>ORDERED BY: </strong><?= $order->ordered_by;?></div>
                                      <div class="infolist noprint"><strong>EMAIL: </strong><?= $order->email;?></div>
                                      <div class="infolist noprint"><strong>CONTACT: </strong><?= $order->contact;?></div>
                                      <div class="infolist noprint"><strong>ORDER TYPE: </strong><?= ($order->order_type=='1')?'Delivery':'Pickup'?></div>
                                      <div class="infolist noprint"><strong>ORDERED ON: </strong><?php $date = new DateTime($order->order_time);echo $date->format('l jS \of F Y h:i:s A'); ?></div>
                                      <div class="infolist noprint"><strong>ORDER READY: </strong><?= $order->order_till;?></div>
                                    <?php
                                    if ($order->remarks!='') {
                                        echo '<div class="infolist noprint" style="border-bottom: 1px solid #dfdfdf;padding-bottom:15px;margin-bottom:20px;"><strong>ADDITIONAL NOTES:</strong>' . $order->remarks . '</div>';
                                    }
                                        //echo  $this->element('receipt');
                                ?>
                                    @include('common.receipt')
                                    <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                        
                        
                    </div>        
                </div>

            </div>
            </div>
        </div>
    </div>                
    <!-- END CONTENT -->
</div>

@stop