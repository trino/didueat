<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%">
    <?php printfile("views/emails/order_approve.blade.php"); ?>
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
                                <h4>Dear {{ $name }},</h4>
                                Your order has been approved.
                                <br /><br />
                                <? if(isset($note) && $note !=""){ ?>
                                Note:
                                <span> {{ $note }} </span>
                                <br /><br />
                                <? } ?>
                                If you have any questions about your order, login to contact the restaurant directly. You can find their contact info on your receipt by logging in. <!--a href="mailto:<?php echo \Config::get('app.admin_mail'); ?>"><?php echo \Config::get('app.admin_mail'); ?></a-->
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