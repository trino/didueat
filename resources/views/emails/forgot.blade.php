<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%">
    <?php
        printfile("views/emails/forgot.blade.php");
        $alts = array(
            "contactus" => "Contact us"
        );
    ?>

        <table align="left" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="margin-left:10px">
            <tr>
                <td align="left" valign="top" id="bodyCell">
                    <!-- BEGIN TEMPLATE // -->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="templateContainer">
                        <tr>
                            <td align="center" valign="top"><!-- BEGIN HEADER // --><!-- // END HEADER --></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><!-- BEGIN BODY // -->
                                <h2>Dear {{ $name }},</h2>
                                We received a request to change your account password. Please use the text below as your new password. 
                                <br /><br />
                                Your new password is:
                                <span style="color:#b02128; font-weight: bold;"> {{ $new_pass }} </span>
                                <br /><br />
                                If you have any questions or concerns, please contact us at <a href="mailto:<?php echo \Config::get('app.admin_mail'); ?>" title="{{ $alts["contactus"] }}"><?php echo \Config::get('app.admin_mail'); ?></a>.
                                <br /><br />
                                Regards,
                                <br />
                                Team <?php echo \Config::get('app.company_name'); ?>
                            </td>
                        </tr>
                    </table>
                    <!-- // END TEMPLATE -->
                </td>
            </tr>
        </table>
        @include("emails.footer")
    </body>
</html>