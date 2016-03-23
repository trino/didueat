<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%">

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
                        <?php
                            $data = \Input::all();
                            printfile("views/emails/newsletter.blade.php");
                            if(!isset($data['message'])){
                                $data['message']=$body;
                            }
                            $alts = array(
                                    "contactus" => "Contact us"
                            );
                        ?>
                        <tr>
                            <td align="left" valign="top"><!-- BEGIN BODY // -->
                                @if(isset($name))
                                <h2>Dear {{ $name }},</h2>
                                @endif
                                
                                {{ $data['message'] }}
                                <br /><br />
                                If you have any questions, please contact us at <a href="mailto:<?php echo \Config::get('app.admin_mail'); ?>" title="{{ $alts["contactus"] }}"><?php echo \Config::get('app.admin_mail'); ?></a>.
                                <br /><br />
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