<?php
//Access this message in global scope like this below.
//echo trans('messages.logout.code');
return [
    "user_logout" => array('message' => "You have been logged out successfully."),
    "user_session_exp" => array('message' => "Session expired. Please re-login."),
    "user_login" => array('message' => "You have been logged in successfully."),
    "email_unvarified" => array('message' => "Email address has not been verified yet."),
    "exception" => array('code' => '100', 'message' => "An unexpected error has occurred."),
    "user_inactive" => array('code' => '101', 'message' => "This account has been blocked. Please contact us at .... to re-activate."),
    "user_login_invalid" => array('code' => '102', 'message' => "Invalid username and/or password."),

    "user_not_registered" => array('code' => '103', 'message' => "User not registered."),
    "user_passwords_mismatched" => array('code' => '104', 'message' => "Password fields are mis-matched."),
    "user_missing_email" => array('code' => '105', 'message' => "User email missing."),
    "user_invalid_data_parse" => array('code' => '106', 'message' => "Invalid data set parse."),
    "user_email_already_exist" => array('code' => '107', 'message' => "That email address already exists."),
    "user_pass_field_missing" => array('code' => '108', 'message' => "User password field missing."),
    "user_confim_pass_field_missing" => array('code' => '109', 'message' => "User confirm password field missing."),
    "user_registration_success" => array('message' => "User account has been created successfully."),
    "user_forgot_password_request" => array('message' => "You'll receive a email with a replacement password."),
    "user_email_verify" => array('message' => "Email address registered."),
    "user_email_not_verify" => array('code' => '110', 'message' => "Email address not registered."),
    "user_password_changed" => array('message' => "Your password has been changed successfully."),
    "user_invalid_parameters" => array('code' => '111', 'message' => "Invalid parameter parsed."),
    "no_record_found" => array('code' => '112', 'message' => "No record found."),
    "id_param_not_valid" => array('code' => '113', 'message' => "Parameter ID is not valid."),
    "date_missing" => array('code' => '114', 'message' => "Date is missing."),
    "new_record" => array('message' => "New record added successfully."),
    "delete_record" => array('message' => "Record has been deleted successfully."),

];
