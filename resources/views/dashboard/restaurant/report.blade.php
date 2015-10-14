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
                    <div class="deleteme">
                        <div class="toprint">
                            
                            <div class="noprint">
                                <h3 class="sidebar__title">Print Order Report</h3>
                                <hr class="shop__divider">
                                <div>
                                    <strong>FILTER BY DATE</strong>
                                    <form class="col-xs-12" style="height: auto!important;padding:0!important" method="get" action="">
                                        <input type="text" class="datepicker  form-control--contact " name="from" placeholder="FROM (Date)" value="<?php if(isset($_GET['from']))echo $_GET['from'];?>">
                                        <input type="text" class="datepicker  form-control--contact " name="to" placeholder="TO (Date)" value="<?php if(isset($_GET['to']))echo $_GET['to'];?>" >
                                        <input type="submit" style="padding:10px;margin-top:-1px;" class="btn btn-primary" value="Go" onclick="return checkFilter();">
                                        <div class="clearfix"></div>

                                    </form>
                                    <div class="clearfix"></div> 
                                </div>
                                <hr class="shop__divider">
                            </div>
                            <?php if(isset($orders) && count($orders)>0){?>
                                @foreach($orders as $order)
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
                        @endforeach
                        <?php }
                            else
                            {
                                
                                echo "Sorry! No Results Found.";
                            }
                        ?>
                        <div class="clearfix"></div>
                            <!--
                            <div class="dashboard toprint">
                                <div class="infolist noprint"><strong>RESTAURANT NAME: </strong>Charlie's Chopsticks</div>  
                                <div class="infolist noprint"><strong>ORDERED BY: </strong>Brian Le</div>                  
                                <div class="infolist noprint"><strong>EMAIL: </strong>khanggle@gmail.com</div>
                                <div class="infolist noprint"><strong>CONTACT: </strong>2898084976</div>
                                <div class="infolist noprint"><strong>ORDERED ON: </strong>Saturday 18th of July 2015 05:24:20 PM</div>
                                <div class="infolist noprint"><strong>ORDER READY: </strong>Order now</div>
                                <div class="infolistwhite">
                                    <div class="">
                                        <div class="col-xs-12" style="padding: 0;">
                                            <br>
                                            <strong>Ordered On: </strong>
                                            Saturday 18th of July 2015 05:24:20 PM
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>Order Type: </strong> Pickup                    
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>
                                                Order City:
                                            </strong>
                                            Hamilton                        
                                            <br><br>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="shop__divider"></div>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td><strong>Item</strong></td>
                                                    <td><strong>Price</strong></td>
                                                    <td><strong>Total</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Bowl Lover w/ Ice Caf?: </strong> Bowl Type: <br>(B) Brown Rice <br> Bowl Additional Protein: <br>(C) Chicken <br> Bowl Greens: <br>(F) Charlies's Cabbage <br> Bowl Sauce: <br>(A) Teriyaki <br> Ice Caf? Size: <br>(B) Large <br> Ice Caf? Flavour: <br>(C) Vanilla</td>
                                                    <td>1 X $11.88</td>
                                                    <td>$11.88</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><hr></td>
                                                </tr> 
                                                <tr>                         
                                                    <td></td>                    
                                                    <td><strong>Total</strong></td>
                                                    <td><strong>$11.88</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Tax (13%)</strong></td>
                                                    <td><strong>$1.54</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><strong>Grand Total</strong></td>
                                                    <td><strong>$13.42</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>                    

                                    </div>
                                </div>
                                <p>&nbsp;</p>

                                <div class="infolist noprint"><strong>RESTAURANT NAME: </strong>Charlie's Chopsticks</div>  
                                <div class="infolist noprint"><strong>ORDERED BY: </strong>Brendan Thompson</div>                  
                                <div class="infolist noprint"><strong>EMAIL: </strong>brendanjamesthompson@gmail.com</div>
                                <div class="infolist noprint"><strong>CONTACT: </strong>2898206559</div>
                                <div class="infolist noprint"><strong>ORDERED ON: </strong>Sunday 19th of July 2015 04:42:16 PM</div>
                                <div class="infolist noprint"><strong>ORDER READY: </strong>Order now</div>
                                <div class="infolistwhite">
                                    <div class="">
                                        <div class="col-xs-12" style="padding: 0;">
                                            <br>
                                            <strong>Ordered On: </strong>
                                            Sunday 19th of July 2015 04:42:16 PM
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>Order Type: </strong> Pickup                    
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>
                                                Order City:
                                            </strong>
                                            Welland                        
                                            <br><br>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="shop__divider"></div>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td><strong>Item</strong></td>
                                                    <td><strong>Price</strong></td>
                                                    <td><strong>Total</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Roll and Bowl Lover w/ Ice Tea: </strong> Roll Dress Up Items: <br>(A) Sesame Seed <br> Roll Garnishes: <br>(E) Hickory Stick,<br>(P) Jalapeno,<br>(U) Bacon,<br>(X) Tempura Shrimp <br> Roll Dip: <br>(C) Spicy Mayo <br> Bowl Type: <br>(C) Vermicelli <br> Bowl Protein: <br>(D) Beef <br> Bowl Greens: <br>(F) Charlies's Cabbage <br> Bowl Sauce: <br>(E) Korean BBQ <br> Ice Tea Type: <br>(A) Tea <br> Ice Tea Size: <br>(A) Small</td>
                                                    <td>1 X $13.88</td>
                                                    <td>$13.88</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Roll and Bowl Lover w/ Ice Tea: </strong> Roll Dress Up Items: <br>(A) Sesame Seed x(2) <br> Roll Garnishes: <br>(G) Sweet Potatoes,<br>(H) Avocado,<br>(I) Cucumber,<br>(X) Tempura Shrimp <br> Roll Dip: <br>(G) Mild Sweet and Sour <br> Bowl Type: <br>(C) Vermicelli <br> Bowl Protein: <br>(D) Beef <br> Bowl Greens: <br>(B) Broccoli <br> Bowl Sauce: <br>(A) Teriyaki <br> Ice Tea Type: <br>(B) Milk Tea <br> Ice Tea Size: <br>(A) Small</td>
                                                    <td>1 X $13.88</td>
                                                    <td>$13.88</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><hr></td>
                                                </tr> 
                                                <tr>                         
                                                    <td></td>                    
                                                    <td><strong>Total</strong></td>
                                                    <td><strong>$27.76</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Tax (13%)</strong></td>
                                                    <td><strong>$3.61</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Grand Total</strong></td>
                                                    <td><strong>$31.37</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <div class="infolist noprint"><strong>RESTAURANT NAME: </strong>Charlie's Chopsticks</div>  
                                <div class="infolist noprint"><strong>ORDERED BY: </strong>dennie</div>                  
                                <div class="infolist noprint"><strong>EMAIL: </strong>dennienguyen24@gmail.com</div>
                                <div class="infolist noprint"><strong>CONTACT: </strong>2894422401</div>
                                <div class="infolist noprint"><strong>ORDERED ON: </strong>Monday 20th of July 2015 12:01:36 PM</div>
                                <div class="infolist noprint"><strong>ORDER READY: </strong>Order now</div>
                                <div class="infolist noprint"><strong>DELIVERY INFO: </strong>970 upper james, hamilton, Ontario, l9c3a5</div>

                                <div class="infolistwhite">
                                    <div class="">
                                        <div class="col-xs-12" style="padding: 0;">
                                            <br><strong>Ordered On: </strong>
                                            Monday 20th of July 2015 12:01:36 PM
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>Order Type: </strong> Delivery                    
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>
                                                Order City:
                                            </strong>
                                            Hamilton                        
                                            <br><br>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="shop__divider"></div>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td><strong>Item</strong></td>
                                                    <td><strong>Price</strong></td>
                                                    <td><strong>Total</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Roll: </strong> Add Dress Up Items: <br>(A) Sesame Seed <br> Add Garnishes: <br>(A) Smoked Salmon,<br>(G) Pork Pattie,<br>(L) Hickory Stick,<br>(Q) Red Peppers <br> Choose Dip: <br>(B) Soya</td>
                                                    <td>1 X $5.88</td>
                                                    <td>$5.88</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><hr></td>
                                                </tr> 
                                                <tr>                         
                                                    <td></td>                    
                                                    <td><strong>Total</strong></td>
                                                    <td><strong>$5.88</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Tax (13%)</strong></td>
                                                    <td><strong>$0.76</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Delivery</strong></td>
                                                    <td><strong>$3.50</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Grand Total</strong></td>
                                                    <td><strong>$10.14</strong></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><strong>Donate to : Vietnam</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>                    

                                    </div>
                                </div>

                                <p>&nbsp;</p>

                                <div class="infolist noprint"><strong>RESTAURANT NAME: </strong>Charlie's Chopsticks</div>  
                                <div class="infolist noprint"><strong>ORDERED BY: </strong>alyssa ritchie</div>                  
                                <div class="infolist noprint"><strong>EMAIL: </strong>alyssa_ritchiee@yahoo.ca</div>
                                <div class="infolist noprint"><strong>CONTACT: </strong>2894568737</div>
                                <div class="infolist noprint"><strong>ORDERED ON: </strong>Wednesday 22nd of July 2015 02:30:30 PM</div>
                                <div class="infolist noprint"><strong>ORDER READY: </strong>Order now</div>
                                <div class="infolist noprint"><strong>DELIVERY INFO: </strong>15 charnwood court, hamilton, Ontario, l8w 3t1</div>
                                <div class="infolistwhite">
                                    <div class="">
                                        <div class="col-xs-12" style="padding: 0;">
                                            <br><strong>Ordered On: </strong>
                                            Wednesday 22nd of July 2015 02:30:30 PM
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>Order Type: </strong> Delivery                    
                                        </div>
                                        <div class="col-xs-12" style="padding: 0;">
                                            <strong>
                                                Order City:
                                            </strong>
                                            Hamilton                        
                                            <br><br>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="shop__divider"></div>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <td><strong>Item</strong></td>
                                                    <td><strong>Price</strong></td>
                                                    <td><strong>Total</strong></td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><strong>Bottle Drinks: </strong> Choose Drink: <br>(A) Coke</td>
                                                    <td>1 X $2.48</td>
                                                    <td>$2.48</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Bowl: </strong> Choose Type: <br>(A) White Rice <br> Add Protein: <br>(D) Beef <br> Add Greens: <br>(C) Beans <br> Choose Sauce: <br>(A) Teriyaki</td>
                                                    <td>1 X $8.88</td>
                                                    <td>$8.88</td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Roll: </strong>  <br> Add Garnishes: <br>(A) Smoked Salmon,<br>(O) Avocado,<br>(P) Cucumber,<br>(Y) Crab Stick <br> Choose Dip: <br>(D) Spicy Mayo <br> Additional Dip: <br>(A) Soya</td>
                                                    <td>1 X $6.36</td>
                                                    <td>$6.36</td>
                                                </tr>

                                                <tr><td colspan="3"><hr></td></tr> 
                                                <tr>                         
                                                    <td></td>                    
                                                    <td><strong>Total</strong></td>
                                                    <td><strong>$17.72</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Tax (13%)</strong></td>
                                                    <td><strong>$2.30</strong></td>                        
                                                </tr>

                                                <tr>
                                                    <td></td>                    
                                                    <td><strong>Delivery</strong></td>
                                                    <td><strong>$3.50</strong></td>                        
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td><strong>Grand Total</strong></td>
                                                    <td><strong>$23.52</strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <p>&nbsp;</p>
                                <span style="float: right;"><strong>GRAND TOTAL FOR REPORT: </strong>$405.13</span>
                                <div class="clearfix"></div>
                            </div>
-->

                            <div class="clearfix  hidden-xs"></div>
                            <script>
                                function checkFilter()
                                {
                                    var date1 = $('.date1').val();
                                    var date2 = $('.date2').val();
                                    if (date1 == '' || date2 == '')
                                    {
                                        alert('Date can\'t be blank');
                                        return false;
                                    }
                                    else {
                                        date1 = date1.replace('-', '').replace('-', '');
                                        date2 = date2.replace('-', '').replace('-', '');

                                        date1 = parseFloat(date1);
                                        date2 = parseFloat(date2);

                                        if (date1 > date2)
                                        {
                                            alert('Starting date cannot be greater than end date');
                                            return false;
                                        }
                                        else
                                            return true;

                                    }
                                }
                            </script>
                            <style>
                                .date1,.date2{padding-left:5px;}
                            </style>        
                        </div>
                    </div>
                    <a href="javascript:void(0);" class="btn red noprint" onclick="window.print();">Print Receipt</a>
                    <hr class="shop__divider">
                </div>

            </div>
            </div>
        </div>
    </div>                
    <!-- END CONTENT -->
</div>
<script>
$(function(){
    $( ".datepicker" ).datepicker({"dateFormat":'yy-mm-dd'});
    
})
</script>
@stop