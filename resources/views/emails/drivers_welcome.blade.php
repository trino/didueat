<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%;padding-left:10px">
    <?php
        printfile("views/emails/registration_welcome.blade.php");
        $requireEmailVerify=false;
        $alts = array(
            "verify" => "Verify your email address is valid"
        );
    ?>
        <table align="left" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="left" valign="top" id="bodyCell"><!-- BEGIN TEMPLATE // -->

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="templateContainer">
                        <tr>
                            <td align="center" valign="top">
                                <!-- BEGIN HEADER // --> 

                                <!-- // END HEADER -->
                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><!-- BEGIN BODY // -->
                                <h2>Dear {{ $name }},</h2>
                                Thank you for registering with {{ DIDUEAT  }}.
                                <br /><br />
                                We will contact you as soon as possible.                              
                                <br/><br/>As a reminder, your login credentials have been included below:
                                <br /><br />  
                                <b>Login Email:</b> {{ $email }}
                                <br />
                                <b>Login Password:</b> {{ $password }}
                                <br /><br />
                                @if(!$is_email_varified && $requireEmailVerify)
                                    Please click on the verification link below to activate your account.
                                    <br /><br />
                                    <a href="{{ url('auth/verify_email') }}/<?php echo base64_encode($email) ?>" style="padding: 6px 12px; background-color: #31a3c9; border-color: #3C5C7B; color: #FFFFFF; text-decoration: none;" target="_blank" title="{{ $alts["verify"] }}">Activate Now</a>
                                    <br /><br />
                                    Please note that your account will not be activated until you verify your email address.
                                    <br /><br />                        
                                    Thank You
                                    <br /><br />
                                @endif

                                Regards,
                                <br />
                                Team <?php echo \Config::get('app.company_name'); ?>
                            </td>
                        </tr>
                    </table>
                    @include("emails.footer")
                    <!-- // END TEMPLATE --></td>
            </tr>
        </table>
        
    </body>
</html>