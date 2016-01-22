<?php
    printfile("views/common/contactinfo.blade.php");
    $size = "col-md-12 col-sm-12 col-xs-12";
    if(!isset($new)){$new = false;}
    $PasswordRequired = iif(isset($user_detail), "", " REQUIRED");
    $Fields = array("name", "email", "phone", "mobile", "subscribed", "password", "confirm_password");
    foreach($Fields as $Field){
        if(isset($user_detail->$Field)){
            $$Field = $user_detail->$Field;
        } else {
            $$Field = old($Field);
        }
    }
    echo newrow($new, "Your Full Name", $size, true);
?>
    <div class="input-icon">
        <input type="text" name="name" class="form-control" id="full_name" placeholder="Full Name" value="{{ $name  }}" required>
        <input type="hidden" name="gmt" id="gmt" value="">
    </div>
<?php echo newrow();

echo newrow($new, "Email", $size, true); ?>
    <div class="input-icon">
        <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" value="{{ $email }}" required>
    </div>
<?php echo newrow(); ?>

@if(!isset($user_detail))
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-long-arrow-right"></i> Choose Password
            </div>
        </div>
    </div>
@else
    <?= newrow(false, "Old Password", $size); ?>
    <div class="input-icon">
        <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old Password" autocomplete="off">
    </div>
    </div></div>
@endif

<?php echo newrow($new, "Password", $size, $PasswordRequired); ?>
    <div class="input-icon">
        <input type="password" name="password" class="form-control" id="password" placeholder="Password" value="{{ $password }}" {{ $PasswordRequired }}>
    </div>
<?php echo newrow();

echo newrow($new, "Re-type Password", $size, $PasswordRequired); ?>
    <div class="input-icon">
        <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Re-type Password" value="{{ $confirm_password }}" {{ $PasswordRequired }}>
    </div>
<?php echo newrow();

echo  newrow(false, "Newsletter", "", false, 9, true); ?>
    <LABEL><input type="checkbox" name="subscribed" id="subscribed" value="1" @if($subscribed) checked @endif /> &nbsp;<b>Sign up for our Newsletter</b></LABEL>
</div></div>

<SCRIPT>
    var visitortime = new Date();
    var visitortimezone = -visitortime.getTimezoneOffset()/60;
    document.getElementById("gmt").value = visitortimezone;
</SCRIPT>