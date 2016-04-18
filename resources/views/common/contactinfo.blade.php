<?php
    printfile("views/common/contactinfo.blade.php");
    $size = "2";

    //if (!isset($new)) {$new = false;}
    $new = false;

    $PasswordRequired = iif(isset($user_detail), "", " REQUIRED");
    //copies user/old data to the proper variables
    $Fields = array("name", "email", "phone", "mobile", "subscribed", "password");//, "confirm_password");
    foreach ($Fields as $Field) {
        if (isset($user_detail->$Field)) {
            $$Field = $user_detail->$Field;
        } else {
            $$Field = old($Field);
        }
    }

    //which name to use for the phone number input
    $phonetype = "phone";
    if(isset($ismobile) && $ismobile){
        $phonetype = "mobile";
    }

    //handles the disabling of fields
    if(!isset($disabled)){$disabled = array();}
    if(!function_exists("isdisabled")){
        function isdisabled($disabled, $field){
            if(in_array($field, $disabled)){
                return " DISABLED";
            }
            return "";
        }
    }

    $is_new = '';
    if (isset($emaillocked)) {
        $is_new = 'New ';
    }

echo newrow($new, "Your Name", $size, true); ?>
<div class="input-icon">
    <input type="text" name="name" class="form-control" id="full_name" placeholder="" value="{{ $name  }}" {{ isdisabled($disabled, "name") }} required />
    <input type="hidden" name="gmt" id="gmt" class="gmt">
</div>
<?php echo newrow();

echo newrow($new, "Cell Phone", $size, true); ?>
<div class="input-icon">
    <input type="text" name="{{ $phonetype }}" class="form-control" id="{{ $phonetype }}" placeholder="" value="{{ $$phonetype }}" {{ isdisabled($disabled, $phonetype) }} required />
</div>
<?php echo newrow();

echo newrow($new, "Email", $size, true); ?>
<div class="input-icon">
    <input type="email" name="email" class="form-control" id="email" placeholder="" value="{{ $email }}" required
           @if(isset($emaillocked)) readonly @endif />
</div>
<?php echo newrow(); ?>

@if(isset($user_detail))
    <?= newrow(false, "Old Password", $size); ?>
    <div class="input-icon">
        <input type="password" name="old_password" class="form-control" id="old_password" placeholder="" value="" autocomplete="off" />
    </div>
    <?php echo newrow(); ?>
@endif

<?= newrow($new, $is_new . "Create Password", $size, $PasswordRequired); ?>
<div class="input-icon">
    <input type="password" name="password" class="form-control" id="password" placeholder="" autocomplete="new-password" value="" {{ $PasswordRequired }} />
</div>
<?php echo newrow();

if(isset($user_detail) && false){
echo newrow(false, " ", "", false, 7, false); ?>
<label class="c-input c-checkbox">
    <input type="checkbox" name="subscribed" id="subscribed" value="true"
           @if($subscribed || (!isset($subscribed))) checked @endif />
    <span class="c-indicator"></span>
    Signup for our newsletter
</label>
<?= newrow();
}

//echo newrow($new, "Re-type Password", $size, $PasswordRequired); ?>
        <!--div class="input-icon">
    <input type="password" name="confirm_password" class="form-control" id="confirm_password"
           autocomplete="off" placeholder="" value=" $confirm_password " $PasswordRequired >
</div></div></div-->

<SCRIPT>
    var visitortime = new Date();
    var visitortimezone = -visitortime.getTimezoneOffset() / 60;
    $(".gmt").val(visitortimezone);//save the user's timezone offset

    $(document).ready(function () {
        setTimeout(function () {$("#password").val("");}, 500);//overwrite chrome's autocomplete
    });
</SCRIPT>