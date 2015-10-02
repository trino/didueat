   <?php if(!isset($order)){?>
   <div class="top-cart-info">
        <div class="col-md-6">
            <a href="javascript:void(0);" class="top-cart-info-count" id="cart-items">3 items</a>
        </div>
        <div class="col-md-6">
            <a href="javascript:void(0);" class="top-cart-info-value" id="cart-total">$1260</a>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-3">
            <a href="#cartsz" class="fancybox-fast-view" ><i class="fa fa-shopping-cart" onclick="#cartsz" ></i></a>
        </div>
   </div>
   <?php }?>
    <div id="cartsz">
            <div class="row  resturant-logo-desc">
               <div class="col-md-12 col-sm-12 col-xs-12">
                   <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
                        <img src="<?php echo url('assets/images/restaurants/'.$restaurant->Logo);?>" class='img-responsive' />
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 resturant-desc">
                        <span><?php echo $restaurant->Address.",". $restaurant->City;?></span>
                        <span><?php echo $restaurant->Phone;?></span>
                      </div>
                   </div>  
               </div> 
           </div>  
                        
          <div class="top-cart-content-wrapper">
         
            <div class="top-cart-content "  >
                <div class="receipt_main">
                
                  @include('common.items')
                    <div class="totals col-md-12 col-sm-12 col-xs-12">
                    <table class="table">
                        <tbody>
                        <?php if(!isset($order)){?>
                        <tr>
                            <td><label class="radio-inline"><input type="radio" name="delevery_type" checked='checked' onclick="delivery('hide');">Pickup</label></td>
                            <td><label class="radio-inline"><input type="radio" name="delevery_type" onclick="delivery('show');">Delivery</label></td>
                        </tr>
                        <?php }?>
                        <tr>
                            <td><strong>Subtotal&nbsp;</strong></td><td>&nbsp;$<div class="subtotal" style="display: inline-block;"><?php echo (isset($order))?$order->subtotal:'0';?></div>
                            <input type="hidden" name="subtotal" class="subtotal" value="<?php echo (isset($order))?$order->subtotal:'0';?>"></td>
                        </tr>
                        <tr>
                            <td><strong>Tax&nbsp;</strong></td><td>&nbsp;$<div class="tax" style="display: inline-block;"><?php echo (isset($order))?$order->tax:'0';?></div>&nbsp;(<div id="tax" style="display: inline-block;">13</div>%)
                            <input type="hidden" value="<?php echo (isset($order))?$order->tax:'0';?>" name="tax" class="tax"/></td>
                        </tr>
    
                        <tr <?php echo (isset($order)&& $order->order_type == '1')?'style="display: block;"':'style="display: none;"';?> id="df">
                            <td><strong>Delivery Fee&nbsp;</strong></td><td>&nbsp;$<?php echo (isset($order))?$order->delivery_fee:$restaurant->DeliveryFee;?>
                                <input type="hidden" value="<?php echo (isset($order))?$order->delivery_fee:$restaurant->DeliveryFee;?>" class="df" name="delivery_fee" />
                                <input type="hidden" value="0" id="delivery_flag" name="order_type"  />
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong>&nbsp;</td><td>&nbsp;$<div style="display: inline-block;" class="grandtotal"><?php echo (isset($order))?$order->g_total:'0';?></div>
                            <input type="hidden" name="g_total" class="grandtotal" value="<?php echo (isset($order))?$order->g_total:'0';?>"/>
                            <input type="hidden" name="res_id"  value="<?php if(isset($restaurant))echo $restaurant->ID;?>"/>
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            <?php if(!isset($order)){?>
              <div class="text-right">
                <input type="button" onclick="printDiv('printableArea')" value="Print" />
                <a href="javascript:void(0)" class="btn btn-default">Clear</a>
                <a href="javascript:void(0)" class="btn btn-primary" onclick="checkout();">Checkout</a>
              </div>
              <?php }?>
              </div>
               <div class="profiles" style="display: none;">
                    <?php //include('common/profile.php');?>
               </div>
            </div>
        </div>
            
     </div>
<script>


function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

    
</script>