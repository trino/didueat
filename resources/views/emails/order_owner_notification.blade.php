<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%">
    <?php
        printfile("views/emails/order_owner_notification.blade.php");
        $alts = array(
                "contactus" => "Contact us",
                "approved" => "Approve of the order",
                "cancelled" => "Cancel the order"
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
                                <br /><br />
                                New order has been received.
                                <br /><br />
                                You can change the status of the order by clicking any of these links:
                                <A HREF="{{ url("restaurant/changeOrderStatus/approved") }}?id={{ $guid }}" title="{{ $alts["approved"] }}">Approve</A>
                                <A HREF="{{ url("restaurant/changeOrderStatus/cancelled") }}?id={{ $guid }}" title="{{ $alts["cancelled"] }}">Cancel</A>
                                <br /><br />
                                If you have any questions, please contact us at <a href="mailto:<?= \Config::get('app.admin_mail'); ?>" title="{{ $alts["contactus"] }}"><?= \Config::get('app.admin_mail'); ?></a>.
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