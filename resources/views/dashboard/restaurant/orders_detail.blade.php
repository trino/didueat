@extends('layouts.default')
@section('content')
<div class="margin-bottom-40">
    <!-- BEGIN CONTENT -->
    <div class="col-md-12 col-xs-12">
        <div class="row content-page">
            <div class="col-xs-12">
                <div class="">

                </div>
            </div>

            <div class="col-md-12 no-padding">
                @include('layouts.includes.leftsidebar')

                <div class="col-xs-12 col-md-9 col-sm-8">
                    @if(Session::has('message'))
                        <div class="alert alert-info">
                            <strong>Alert!</strong> &nbsp; {!! Session::get('message') !!}
                        </div>
                    @endif
                    
                    <div class="deleteme">
                        <h3 class="sidebar__title">Pending Orders Manager</h3>
                        <hr class="shop__divider">

                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="portlet box red-intense">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="fa fa-globe"></i>Orders List
                                </div>
                                <div class="tools">
                                </div>
                            </div>
                                <div class="portlet-body">
                                <?php
                                
                                    $restaurant = \App\Http\Models\Restaurants::where('id', $order->restaurantId)->first();    ?>
                                      <div class="infolist noprint"><strong>RESTAURANT NAME: </strong><?= $restaurant->Name;?></div>
                                      <div class="infolist noprint"><strong>ORDERED BY: </strong><?= $order->ordered_by;?></div>
                                      <div class="infolist noprint"><strong>EMAIL: </strong><?= $order->email;?></div>
                                      <div class="infolist noprint"><strong>CONTACT: </strong><?= $order->contact;?></div>
                                      <div class="infolist noprint"><strong>ORDER TYPE: </strong><?= ($order->order_type=='1')?'Delivery':'Pickup'?></div>
                                      <div class="infolist noprint"><strong>ORDERED ON: </strong><?php $date = new DateTime($order->order_time);echo $date->format('l jS \of F Y h:i:s A'); ?></div>
                                      <div class="infolist noprint"><strong>ORDER READY: </strong><?= $order->order_till;?></div>
                                    <?php
                                    if ($order->remarks!='') {
                                        echo '<div class="infolist noprint"><strong>ADDITIONAL NOTES:</strong>' . $order->remarks . '</div>';
                                    }
                                        //echo  $this->element('receipt');
                                ?>
                                    @include('common.receipt')
                                    <div class="clearfix"></div>
                            </div>
                        </div>
                        <!-- END EXAMPLE TABLE PORTLET-->
                        
                        <hr class="shop__divider">
                    </div>        
                </div>

            </div>
        </div>
    </div>                
    <!-- END CONTENT -->
</div>

@stop