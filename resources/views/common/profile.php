<?php
    echo $Manager->fileinclude(__FILE__);
    date_default_timezone_set('America/Toronto');
    //echo date('M t, h:i');
?>
<div class="form-group">
    <div class="col-xs-12">
        <h2 class="profile_delevery_type"></h2>
    </div>
</div>
<form id="profiles">
<div class="form-group">
    <div class="col-xs-12 margin-bottom-10">
    <input type="text" style="padding-top: 0;margin-top: 0;" placeholder="Name" class="form-control  form-control--contact" name="ordered_by" id="fullname" required="">
    </div>                        
  </div>
  <div class="form-group">
  <div class="col-xs-12 col-sm-6 margin-bottom-10">
    <input type="email" placeholder="Email" class="form-control  form-control--contact" name="email" id="ordered_email" required="">                        
  </div>
  <div class="col-xs-12 col-sm-6">
    <input type="text" placeholder="Phone Number" class="form-control  form-control--contact" name="contact" id="ordered_contact" required="">
    </div>
    <div class="clearfix"></div>                        
  </div>
  <div class="form-group">
  <div class="col-xs-12">
    <input type="password" name="password" id="password1" class="form-control  form-control--contact" placeholder="Password" onkeyup="check_val(this.value);" />
  </div>
    <div class="clearfix"></div>
  </div>
  <div class="form-group confirm_password" style="display: none;">
      <div class="col-xs-12">
        <input type="password" id="confirm_password" name="" class="form-control  form-control--contact" placeholder="Confirm Password"   />
      </div>
    <div class="clearfix"></div>
  </div>
  
  <div class="form-group">
      <div class="col-xs-12">
        
        <select class="form-control  form-control--contact" name="order_till" id="ordered_on_time" required="">
            <option value="ASAP">ASAP</option>
            <?php
            for($i=30;$i<570;$i=$i+30)
            {
                
                echo "<option value='".date('M t, ', strtotime("+".($i-30)." minutes")). date('h:i', strtotime("+".($i-30)." minutes")) . ' - '. date('h:i', strtotime("+".$i." minutes"))."'>". date('M t, ', strtotime("+".($i-30)." minutes")). date('h:i', strtotime("+".($i-30)." minutes")) . ' - '. date('h:i', strtotime("+".$i." minutes"))."</option>";
                
                
            }
                ?>        
        </select>
      </div>
      <div class="clearfix"></div> 

</div>
<div class="profile_delivery_detail" style="display: none;">
<div class="form-group margin-bottom-10">
<!--textarea placeholder="Address 2" name="address2"></textarea-->   
<div class="col-xs-12 col-sm-6  margin-bottom-10">
<input type="text" placeholder="Address 2" class="form-control  form-control--contact" name="address2" />
</div>                        



<div class="col-xs-12 col-sm-6  margin-bottom-10">                        
    <input type="text" placeholder="City" class="form-control  form-control--contact" name="city" id="city" />                        
</div>
</div>
<div class="form-group">
<div class="col-xs-12 col-sm-6">
<select class="form-control form-control--contact" name="province">
    <option value="Alberta">Alberta</option>
    <option value="British Columbia">British Columbia</option>
    <option value="Manitoba">Manitoba</option>
    <option value="New Brunswick">New Brunswick</option>
    <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
    <option value="Nova Scotia">Nova Scotia</option>
    <option selected="selected" value="Ontario">Ontario</option>
    <option value="Prince Edward Island">Prince Edward Island</option>
    <option value="Quebec">Quebec</option>
    <option value="Saskatchewan">Saskatchewan</option>
</select>
                        
</div>
<div class="col-xs-12 col-sm-6">
    <input type="text" placeholder="Postal Code" class="form-control  form-control--contact" name="postal_code" id="postal_code" />
</div>                        
<div class="clearfix"></div>
</div>
</div>
<div class="form-group">
<div class="col-xs-12">
<textarea placeholder="Additional Notes" class="form-control  form-control--contact"  name="remarks"></textarea>
</div> 
<div class="clearfix"></div>                       
</div>
<div class="form-group">
<div class="col-xs-12">
<a href="javascript:void(0)" class="btn btn-default back">Back</a>
<button type="submit" class="btn btn-primary" >Checkout</button>
</div>
<div class="clearfix"></div>  
</div>
</form>
<script>
function check_val(v)
{
    if(v!=''){
        $('.confirm_password').show();
    $('#confirm_password').attr('required','required');}
}
var password = document.getElementById("password1")
  , confirm_password = document.getElementById("confirm_password");

function validatePassword(){
    
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
    $('#confirm_password').removeAttr('required');
  }
}

password.onchange = validatePassword;

confirm_password.onkeyup = validatePassword;
$(function(){
    
    $('.back').live('click',function(){
       $('.receipt_main').show();
       $('.profiles').hide(); 
    });
    $('#profiles').submit(function(e){
            e.preventDefault();
            var datas = $('#profiles input, select, textarea').serialize();
            var order_data = $('.receipt_main input').serialize();
            $.ajax({
                type:'post',
                url:'http://localhost/Foodie/users/ajax_register',
                data: datas+'&'+order_data,
                success:function(msg){
                  if(msg =='0')
                  {
                    $('.top-cart-content ').html('<span class="thankyou">Thank You.</span>');
                  }
                  else if(msg == '1')
                    alert('Email Already Registred.');
                }
            })
        });
    
});   

</script>
