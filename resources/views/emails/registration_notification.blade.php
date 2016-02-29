<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="width:100%">
    <?php printfile("views/emails/registration_notification.blade.php"); ?>
        <table align="left" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="left" valign="top" id="bodyCell"><!-- BEGIN TEMPLATE // -->

                    <table width="100%" border="0" cellpadding="0" cellspacing="0" id="templateContainer">
                        <tr>
                            <td align="center" valign="top"><!-- BEGIN HEADER // --> 

                                <!-- // END HEADER --></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top"><!-- BEGIN BODY // -->
                                Dear Admin, 
                                <br /><br />
                                &nbsp;&nbsp; A new account has been registered on onlinejobstreet.com. Following are the details of users.
                                <br /><br />
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                    <tr>
                                        <td valign="top" class="bodyContent" mc:edit="body_content">
                                            <table width="100%">
                                                @if(isset($firstName))
                                                <tr>
                                                    <td width="25%"><b>First Name:</b></td>
                                                    <td width="75%">&nbsp;{{ $firstName }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($lastName))
                                                <tr>
                                                    <td><b>Last Name:</b></td>
                                                    <td>&nbsp;{{ $lastName }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($username))
                                                <tr>
                                                    <td><b>Username:</b></td>
                                                    <td>&nbsp;{{ $username }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($emailAddress))
                                                <tr>
                                                    <td><b>Email Address:</b></td>
                                                    <td>&nbsp;{{ $emailAddress }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($mobileNumber))
                                                <tr>
                                                    <td><b>Cell Phone</b></td>
                                                    <td>&nbsp;{{ $mobileNumber }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($address))
                                                <tr>
                                                    <td><b>Address:</b></td>
                                                    <td>&nbsp;{{ $address }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($referredBy))
                                                <tr>
                                                    <td><b>Referred By:</b></td>
                                                    <td>&nbsp;{{ $referredBy }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($jobType))
                                                <tr>
                                                    <td><b>Job Type:</b></td>
                                                    <td>&nbsp;{{ $jobType }}</td>
                                                </tr>
                                                @endif
                                                @if(isset($referalName) && $referalName != "")
                                                <tr>
                                                    <td><b>Referal Name:</b></td>
                                                    <td>&nbsp;{{ $referalName }}</td>
                                                </tr>
                                                @endif
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                                <br /><br /><br />
                                Regards,
                                <br /><br />
                                Online Job Street Team 
                                <br />
                                <b>Contact Number:</b> 0323-1466515, 0323-1466516 <br />
                                <b>E-mail Address:</b> {{ADMIN_EMAIL}}
                            </td>
                        </tr>
                    </table>
                    @include("emails.footer")
                    <!-- // END TEMPLATE --></td>
            </tr>
        </table>
        
    </body>
</html>