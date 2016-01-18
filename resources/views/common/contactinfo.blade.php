<?php
printfile("views/common/contactinfo.blade.php");
$size = "col-md-12 col-sm-12 col-xs-12";
echo newrow($new, "Full Name", $size);
?>
    <div class="input-icon">
        <input type="text" name="full_name" class="form-control" id="full_name" placeholder="" value="{{ old('full_name') }}" required>
        <input type="hidden" name="gmt" id="gmt" value="">
    </div>
<?php echo newrow();

if(!isset($email)){
echo newrow($new, "Email", $size); ?>
    <div class="input-icon">
        <input type="email" name="email" class="form-control" id="email" placeholder="" value="{{ old('email') }}" required>
    </div>
<?php echo newrow();} ?>

<?php echo newrow($new, "Password", $size); ?>
    <div class="input-icon">
        <input type="password" name="password1" class="form-control" id="password1" placeholder="" required>
    </div>
<?php echo newrow();

echo newrow($new, "Re-type Password", $size); ?>
    <div class="input-icon">
        <input type="password" name="confirm_password1" class="form-control" id="confirm_password1" placeholder="" required>
    </div>
<?php echo newrow();

if(isset($mobile)){
    echo newrow($new, "Cell Phone", $size);
    echo '<input type="number" name="mobile" class="form-control" required placeholder="" value="' . old('mobile') . '"></div></div>';
}
?>

<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="form-group clearfix">
        <label for="subscribed" class="col-md-12 col-sm-12 col-xs-12 control-label">&nbsp;</label>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <label>
                <input type="checkbox" name="subscribed" id="subscribed" value="1" checked />
                Sign up for our Newsletter
            </label>
        </div>
    </div>
</div>
<SCRIPT>
    var visitortime = new Date();
    var visitortimezone = -visitortime.getTimezoneOffset()/60;
    document.getElementById("gmt").value = visitortimezone;
</SCRIPT>