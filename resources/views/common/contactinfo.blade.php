<?php
printfile("views/common/contactinfo.blade.php");
$size = "2";

if (!isset($new)) {
    $new = false;
}
$new = false;

$PasswordRequired = iif(isset($user_detail), "", " REQUIRED");
$Fields = array("name", "email", "phone", "mobile", "subscribed", "password");//, "confirm_password");
foreach ($Fields as $Field) {
    if (isset($user_detail->$Field)) {
        $$Field = $user_detail->$Field;
    } else {
        $$Field = old($Field);
    }
}
?>

<?= newrow($new, "Your Name", $size, true);
?>
<div class="input-icon">
    <input type="text" name="name" class="form-control" id="full_name" placeholder="" value="{{ $name  }}" required>
    <input type="hidden" name="gmt" id="gmt" class="gmt">
</div>
<?php echo newrow();

echo newrow($new, "Email", $size, true); ?>
<div class="input-icon">
    <input type="email" name="email" class="form-control" id="email" placeholder="" value="{{ $email }}" required>
</div>
<?php echo newrow(); ?>

<?php
echo newrow($new, "Cell Phone", $size, true); ?>
<div class="input-icon">
    <input type="text" name="mobile" class="form-control" id="mobile" placeholder="" value="{{ $mobile }}" required>
</div>
<?php echo newrow(); ?>



<?= newrow(false, " ", "", false, 7, false); ?>

<label class="c-input c-checkbox">
    <input type="checkbox" name="subscribed" id="subscribed" value="true"
           @if($subscribed || (!isset($subscribed))) checked @endif />
    <span class="c-indicator"></span>
    Signup for our newsletter
</label>
</div></div>


@if(isset($user_detail))
    <?= newrow(false, "Old Password", $size); ?>
    <div class="input-icon">
        <input type="password" name="old_password" class="form-control" id="old_password" placeholder=""
               autocomplete="off">
    </div>
    <?php echo newrow(); ?>
@endif

<?= newrow($new, "Password", $size, $PasswordRequired); ?>
<div class="input-icon">
    <input type="password" name="password" class="form-control" id="password" placeholder=""
           autocomplete="off" value="{{ $password }}" {{ $PasswordRequired }}>
</div>
<?php echo newrow();

//echo newrow($new, "Re-type Password", $size, $PasswordRequired); ?>
<!--div class="input-icon">
    <input type="password" name="confirm_password" class="form-control" id="confirm_password"
           autocomplete="off" placeholder="" value=" $confirm_password " $PasswordRequired >
</div></div></div-->

<SCRIPT>
    var visitortime = new Date();
    var visitortimezone = -visitortime.getTimezoneOffset() / 60;
    $(".gmt").val(visitortimezone);
</SCRIPT>