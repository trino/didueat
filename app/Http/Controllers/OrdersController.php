<?php

    namespace App\Http\Controllers;

    use App\Http\Controllers\Controller;
    use App\Http\Models\Profiles;
    use App\Http\Models\Restaurants;

    class OrdersController extends Controller {
        /**
         * Constructor
         * @param null
         * @return redirect
         */
        public function __construct(){
            date_default_timezone_set('America/Toronto');
        }

        /**
         * Orders List
         * @param $type
         * @return view
         */
        public function index($type = '', $id = ''){
            $data['title'] = 'Orders';
            $data['type'] = $type;
            $data['id'] = $id;
            return view('dashboard.orders.index', $data);
        }

        /**
         * Ajax Listing Ajax
         * @return Response
         */
        public function listingAjax($type = '', $id = ''){
            \DB::enableQueryLog();
            $per_page = \Input::get('showEntries');
            $defaults = array("per_page" => 10, "meta" => "order_time", "order" => "DESC", "searchResults" => "");
            if($per_page == "undefined"){$per_page = $defaults["per_page"];}
            $page = \Input::get('page');
            $cur_page = $page;
            $page -= 1;
            $start = $page * $per_page;

            $data = array(
                'type' => $type,
                'page' => $page,
                'cur_page' => $cur_page,
                'per_page' => $per_page,
                'start' => $start,
                'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'order_time',
                'order' => (\Input::get('order')) ? \Input::get('order') : 'DESC',
                'searchResults' => \Input::get('searchResults')
            );
            foreach($data as $key => $value){
                if ($value == "undefined" && isset($defaults[$key])){
                    $data[$key] = $defaults[$key];
                }
            }

            if ($id) {
                $data["id"] = $id;
            }

            $Query = \App\Http\Models\Orders::listing($data, "list", $recCount);

            $no_of_paginations = ceil($recCount / $per_page);

            $data['Query'] = $Query;
            $data["SQL"] = lastQuery();
            $data['recCount'] = $recCount;
            $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
            $data["_GET"] = $_GET;

            \Session::flash('message', \Input::get('message'));
            return view('dashboard.orders.ajax.list', $data);
        }

        public function order_pass($ID, $Note = "No reason specified"){
            update_database("reservations", "id", $ID, array("driver_id" => 0));
            $this->sendSMS("van", "The driver declined order " . $ID);
            return debugprint("Passed on the order (" . $Note . ")", $ID);
        }

        public function order_assign($ID, $type, $Driver_ID){
            update_database("reservations", "id", $ID, array( "driver_id" => $Driver_ID, "assigned_at" => now() ));
            debugprint("Assigned driver: " . $Driver_ID . " to the order", $ID);
            $driver = select_field("profiles", "id", $Driver_ID);
            $driver->mail_subject = 'You have an order pending';
            $driver->message = '<A HREF="' . url('orders/list/driver') . '">' . $driver->mail_subject . '. Click here to view it</A>';
            $this->sendSMS($driver->phone, $driver->message);
            $this->sendEMail("emails.newsletter", object_to_array($driver));
            return $this->success("Order " . $ID . " assigned to driver " . $Driver_ID, "orders/order_detail/" . $ID . '/' . $type);
        }

        /**
         * Orders Detail
         * @param $id
         * @return view
         */
        public function order_detail($ID, $type){
            $data['order'] = select_field("orders", "id", $ID);
            $data['order']->guid = $ID;
            //$data['items'] = enum_all("orderitems", array("order_id" => $ID));
            $data['items'] = select_field("orderitems", "order_id", $ID, false, "restaurant_id", "ASC");

            $post = \Input::all();
            if (isset($post) && count($post) > 0 && !is_null($post)) {
                if(isset($post["stripeToken"]) && $post["stripeToken"]){
                    if (app('App\Http\Controllers\CreditCardsController')->stripepayment($ID, $post["stripeToken"], $data['order']->guid, $data['order']->g_total)) {
                        $this->success("Your order has been paid for");
                        $data['order']->paid = 1;
                    }else {
                        $this->failure("There was an issue with your credit card payment. Please email us at info@didueat.ca");
                    }
                }
            }
            $data['ID'] = $ID;
            $data['title'] = 'Orders Detail';
            $data['type'] = $type;
            $data['user_detail'] = \App\Http\Models\Profiles::find($data['order']->user_id);//load user that placed the order
            return view('dashboard.orders.orders_detail', $data);

        }

        //gets all orders for this restaurant
        public function history($id = 0){
            $data['title'] = 'Orders History';
            $data['type'] = 'History';
            $data['orders_list'] = \App\Http\Models\Reservations::where('restaurant_id', ($id > 0) ? $id : \Session::get('session_restaurant_id'))->orderBy('order_time', 'DESC')->get();
            return view('dashboard.restaurant.orders_pending', $data);
        }

        /**
         * Change Order Status to Cancel
         * @param $id
         * @return redirect
         */
        public function changeOrderCancel($type = "", $OrderID = false, $Note = false){
            return $this->changeOrderStatus('cancelled', 'Your order has been cancelled.', "emails.order_cancel", 'Order has been cancelled successfully!', "orders/list/" . $type, $OrderID, $Note);
        }

        /**
         * Change Order Status to Approved
         * @param $id
         * @return redirect
         */
        public function changeOrderApprove($type = "", $OrderID = false, $Note = false){
            return $this->changeOrderStatus('approved', DIDUEAT . ' - Order Approved', "emails.order_approve", 'Your order has been approved!', "orders/list/" . $type, $OrderID, $Note);
        }

        /**
         * Change Order Status to Disapproved
         * @param $id
         * @return redirect
         */
        public function changeOrderDisapprove($type = "", $OrderID = false, $Note = false){
            return $this->changeOrderStatus('pending', DIDUEAT . ' - Order Declined', "emails.order_disapprove", 'Order has been disapproved!', "orders/list/" . $type, $OrderID, $Note);
        }

        public function changeOrderDelivered($type = "", $OrderID = false, $Note = false){
            update_database("reservations", "id", $OrderID, array("driver_note" => $Note));
            return $this->changeOrderStatus('delivered', DIDUEAT . ' - Order Delivered', "", 'Order has been delivered!', "orders/list/" . $type, $OrderID, $Note);
        }

        /**
         * Change Order Status to $status, send email (using $subject/$email) and $flash
         * @param $id (POST)
         * statuses can be cancelled, approved or pending
         * @return redirect
         */
        public function changeOrderStatus($status, $subject = "", $email = "", $flash = "", $URL = "", $OrderID = false, $Note = false){
            $post = \Input::all();
            if($OrderID) {
                $post['id'] = $OrderID;
                $post['note'] = $Note;
            } else if(isset($_POST["id"])) {
                $OrderID = $_POST["id"];
                $Note = $_POST["note"];
            } else {
                echo "OrderID not specified";
                var_dump($post);
                die();
            }
            debugprint("Set order status to " . $status, $OrderID);

            if (isset($post) && count($post) > 0 && !is_null($post)) {
                if (!isset($post['id']) || empty($post['id'])) {
                    return $this->failure("[Order Id] is missing!", $URL);
                }
                try {
                    if (is_numeric($post['id'])) {
                        $ob = \App\Http\Models\Orders::find($post['id']);
                    } else {
                        return $this->failure($post['id'] . " is not a valid order ID", "/");
                    }

                    $ob->populate(array('status' => $status, 'note' => $post['note'], 'time' => now()));
                    $ob->save();

                    if ($ob->user_id && $subject && $email && $status != "approved") {
                        $userArray = \App\Http\Models\Profiles::find($ob->user_id)->toArray();
                        $userArray['mail_subject'] = $subject;
                        $userArray['note'] = $post['note'];
                        $this->sendEMail($email, $userArray);
                        debugprint("Email sent to: " . $userArray["email"], $OrderID);

                        if($userArray["mobile"] && !$userArray["phone"]){$userArray["phone"] = $userArray["mobile"];}
                        if($post['note']) { $subject .= " The reason specifed was: " . $post['note']; }
                        $this->sendSMS( $userArray["phone"], $subject);
                        debugprint("Text message sent to: " . $userArray["phone"], $OrderID);
                    }

                    return $this->success($flash, $URL);
                } catch (\Exception $e) {
                    return $this->failure(handleexception($e), $URL);
                }
            } else {
                return $this->failure("Invalid request made!", $URL);
            }
        }

        /**
         * Delete Order $id
         * @param $id
         * @return redirect
         */
        public function deleteOrder($type = "", $id = 0){
            if (!isset($id) || empty($id) || $id == 0) {
                return $this->failure("[Order Id] is missing!", 'orders/list/' . $type);
            }
            try {
                $ob = \App\Http\Models\Orders::find($id);
                $ob->delete();
                @unlink(public_path('assets/logs' . ReceiptVersion. '/' . $id . '.txt'));
                return $this->listingAjax($type);
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'orders/list/' . $type);
            }
        }

        /**
         * gets orders between from and to time
         * @param $res_id (restaurant ID)
         * @return view
         */
        public function report($res_id = 0){
            if (!$res_id) {
                $res_id = \Session::get('session_restaurant_id');
            }//gets all orders for this restaurant
            $order = \App\Http\Models\Reservations::where('restaurant_id', $res_id)->leftJoin('restaurants', 'reservations.restaurant_id', '=', 'restaurants.id');
            if (isset($_GET['from'])) {
                $order = $order->where('order_time', '>=', $_GET['from']);//equal to and greater than from time
            }
            if (isset($_GET['to'])) {
                $order = $order->where('order_time', '<=', $_GET['to']);//equal to and lesser than to time
            }
            $data['orders'] = $order->get();
            $data['title'] = 'Report';
            return view('dashboard.restaurant.report', $data);
        }










        //alias of notifystore, but only uses email
        public function emailstore($RestaurantID, $Message, $EmailParameters = [], $EmailTemplate = "emails.newsletter"){
            $this->notifystore($RestaurantID, $Message, $EmailParameters, $EmailTemplate, false, true, false, false);
        }

        //will notify every user belonging to the restaurant via their notification addresses
        //if no notification addresses are found, it will fall back to the restaurant's email address
        //$RestaurantID = the restaurant to notify
        //$Message = the message to be sent, will be passed as $body into the email template
        //$EmailParameters = any extra parameters to be passed to the email template
        //$EmailTemplate = the email template to use, defaults to the newsletter as it just sends the message
        //$IncludeVan = If "call", calls Van. If any other value (except false) it sends an SMS to Van (only works on live site)
        //$Emails/$Calls/$SMS = enable/disable that type of notification method
        //returns a multidimensional array, first dimension = type of address ("email", "sms", "call", "total"), second dimension = addresses contacted, except for total which is the sum of all 3 types
        //example usage outside of this controller: app('App\Http\Controllers\OrdersController')->notifystore(1, "TEST");
        public function notifystore($RestaurantID, $Message, $EmailParameters = [], $EmailTemplate = "emails.newsletter", $IncludeVan = false, $Emails = true, $Calls = true, $SMS = true) {
            $OnlyVan = false;//if true, only Van will get the message
            if(!$RestaurantID){$OnlyVan = true;}
            $EmailParameters["body"] = $Message;
            if (!isset($EmailParameters["mail_subject"])) {
                $EmailParameters["mail_subject"] = $Message;
            }
            //list of words to replace for easier pronunciation by the computer
            $CallMessage = str_replace(array(DIDUEAT), array("did you eat"), strtolower($Message));
            //if(($OnlyVan || $IncludeVan) && islive()){$this->sendSMS("van", $Message, strtolower($IncludeVan) == "call");}
            $ret = array("email" => array(), "sms" => array(), "call" => array(), "total" => 0, "ret");
            if(!$OnlyVan) {
                $NotificationAddresses = \DB::select('SELECT * FROM notification_addresses LEFT JOIN profiles ON notification_addresses.user_id=profiles.id WHERE profiles.restaurant_id = ' . $RestaurantID);
                foreach ($NotificationAddresses as $NotificationAddress) {
                    if ($NotificationAddress->address) {
                        $NotificationAddress->address = trim($NotificationAddress->address);
                        if ($NotificationAddress->type == "Email") {
                            if ($Emails) {
                                $EmailParameters['name'] = $NotificationAddress->name;
                                $EmailParameters["email"] = $NotificationAddress->address;
                                $this->sendEMail($EmailTemplate, $EmailParameters);
                                $ret["email"][] = $NotificationAddress->address;
                            }
                        } else if ($NotificationAddress->is_sms) {
                            if ($SMS) {
                                $ret["ret"]["sms " . $NotificationAddress->address] = $this->sendSMS($NotificationAddress->address, $Message);
                                $ret["sms"][] = $NotificationAddress->address;
                            }
                        } else if ($Calls) {
                            $ret["ret"]["call " . $NotificationAddress->address] = $this->sendSMS($NotificationAddress->address, $CallMessage, true);
                            $ret["call"][] = $NotificationAddress->address;
                        }
                        $ret["total"] = $ret["total"] + 1;
                    }
                }
            }
            if (!$ret["total"] && $Emails && $RestaurantID) {//emergency fallback email
                $restaurant = \App\Http\Models\Restaurants::find($RestaurantID);
                $EmailParameters['name'] = $restaurant->name;
                $EmailParameters['email'] = $restaurant->email;
                $this->sendEMail($EmailTemplate, $EmailParameters);
                $ret["email"][] = $restaurant->email;
                $ret["total"] = 1;
            }
            return $ret;
        }

        //alert stores for all pending orders
        public function alertstore(){
            $Field = 'reservations.status';
            $value = "pending";
            if (isset($_GET["orderid"]) && $_GET["orderid"]) {
                $Field = 'reservations.id';
                $value = $_GET["orderid"];
            }
            $Orders = \DB::table('reservations')
                ->select(\DB::raw("reservations.*, restaurants.*, reservations.id as order_id"))
                ->leftJoin('restaurants', 'reservations.restaurant_id', '=', 'restaurants.id')
                ->where($Field, '=', $value)
                ->get();

            $array = array('mail_subject' => "An order has been placed with didueat.ca");

            echo '<H1>Pending orders: ' . count($Orders) . '</H1><TABLE BORDER="1"><TR><TH>Order</TH><TH>Restaurant</TH><TH>Address</TH><TH>Delivery Time</TH><TH>GUID</TH><TH>Actions</TH></TR>';
            $TotalActions = array("Email" => array(), "SMS" => array(), "Call" => array());
            $Addresses = array();
            foreach ($Orders as $Order) {
                echo '<TR>';
                echo '<TD>' . $Order->order_id . '</TD>';
                echo '<TD>' . $Order->restaurant_id . '</TD>';
                echo '<TD>' . $Order->address1 . ' ' . $Order->address2 . '<BR>' . $Order->city . ' ' . $Order->province . '<BR>' . $Order->country . ' ' . $Order->postal_code . '</TD>';
                echo '<TD>' . $Order->order_till . '</TD>';
                echo '<TD>' . $Order->guid . '</TD>';

                $NotificationAddresses = \DB::select('SELECT * FROM notification_addresses LEFT JOIN profiles ON notification_addresses.user_id=profiles.id WHERE profiles.restaurant_id = ' . $Order->restaurant_id);
                echo '<TD>';//is_call, is_sms, type, address, profile: email,phone, mobile
                $Actions = array();

                //enumerate all notification methods, separated by type
                foreach ($NotificationAddresses as $NotificationAddress) {
                    if ($NotificationAddress->address) {
                        $NotificationAddress->address = trim($NotificationAddress->address);
                        if (isset($Addresses[$NotificationAddress->address])) {
                            $Addresses[$NotificationAddress->address] = $Addresses[$NotificationAddress->address] + 1;
                        } else {
                            $Addresses[$NotificationAddress->address] = 1;
                        }
                        if ($NotificationAddress->type == "Email") {
                            $Actions["Email"][] = $NotificationAddress->address;
                            $Actions["Email"] = array_unique($Actions["Email"]);
                            $TotalActions["Email"][] = $NotificationAddress->address;

                            $array["email"] = $Actions["Email"];
                            $array["orderid"] = $Order->order_id;
                            $this->sendEMail("emails.receipt", $array);

                        } else if ($NotificationAddress->is_sms) {
                            $Actions["SMS"][] = phonenumber($NotificationAddress->address);
                            $Actions["SMS"] = array_unique($Actions["SMS"]);
                            $TotalActions["SMS"][] = $NotificationAddress->address;
                        } else {
                            $Actions["Call"][] = phonenumber($NotificationAddress->address);
                            $Actions["Call"] = array_unique($Actions["Call"]);
                            $TotalActions["Call"][] = $NotificationAddress->address;
                        }
                    }
                }
                var_dump($Actions);
                echo '</TD>';

                echo '</TR>';
            }
            echo '</TABLE>';

            //contact each notification method
            echo '<TABLE BORDER="1"><TR><TH>Action</TH><TH>Address</TH><TH>Orders</TH></TR>';
            foreach ($TotalActions as $Key => $Value) {
                $Value = array_unique($Value);
                foreach ($Value as $Address) {
                    $Orders = $Addresses[$Address];
                    if ($Orders == 1) {
                        $Message = "There is 1 order pending for your approval at ";
                    } else {
                        $Message = "There are " . $Orders . " orders pending for your approval at ";
                    }
                    echo '<TR><TD>' . $Key . '</TD><TD>' . $Address . '</TD><TD>' . $Orders . '</TD></TR>';
                    if (true) {//set to false to disable contacting
                        switch ($Key) {
                            case "Call":
                                $this->sendSMS($Address, $Message . "did you eat dot see ay", true);
                                break;
                            case "SMS":
                                $this->sendSMS($Address, $Message . "didueat.ca");
                                break;
                            case "Email":
                                $Email = array("mail_subject" => $Message . "didueat.ca", "email" => $Address, "body" => $Message . "didueat.ca", "name" => "didueat.ca user");
                                $this->sendEMail("emails.newsletter", $Email);
                                break;
                        }
                    }
                }
            }
            echo '</TABLE>';
            echo '<input type="button" value="Go Back" onclick="history.back(-1);" />';
            die();
        }

        //is data JSON-parseable?
        function isJson($string){
            if ($string && !is_array($string)) {
                json_decode($string);
                return (json_last_error() == JSON_ERROR_NONE);
            }
        }

        //used for making raw HTTP requests
        function cURL($URL, $data = "", $username = "", $password = ""){
            $session = curl_init($URL);
            curl_setopt($session, CURLOPT_HEADER, false);
            curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);//not in post production
            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($session, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($session, CURLOPT_POSTFIELDS, $data);
            }

            $datatype = "x-www-form-urlencoded;charset=UTF-8";
            if ($this->isJson($data)) {
                $datatype = "json";
            }
            $header = array('Content-type: application/' . $datatype, "User-Agent: Charlies");
            if ($username && $password) {
                $header[] = "Authorization: Basic " . base64_encode($username . ":" . $password);
            } else if ($username) {
                $header[] = "Authorization: Bearer " . $username;
                $header[] = "Accept-Encoding: gzip";
            } else if ($password) {
                $header[] = "Authorization: AccessKey " . $password;
            }
            curl_setopt($session, CURLOPT_HTTPHEADER, $header);

            $response = curl_exec($session);
            if (curl_errno($session)) {
                $response = "Error: " . curl_error($session);
            }
            curl_close($session);
            return $response;
        }

        //$0.0075 per SMS, + $1 per month
        function sendSMS($Phone, $Message, $Call = false){//works if you can get the from number....
            //https://www.twilio.com/
            debugprint( iif($Call, "Calling", "Sending an SMS to") . ": " . $Phone . " - " .  $Message);
            if (islive()) {
                $sid = 'AC81b73bac3d9c483e856c9b2c8184a5cd';
                $token = "3fd30e06e99b5c9882610a033ec59cbd";
                $fromnumber = "2897685936";
                if($Phone == "van"){$Phone = "9055315331";}
                if ($Call) {
                    $Message = "http://charlieschopsticks.com/pages/call?message=" . urlencode($Message);
                    $URL = "https://api.twilio.com/2010-04-01/Accounts/" . $sid . "/Calls";
                    $data = array("From" => $fromnumber, "To" => $Phone, "Url" => $Message);
                } else {
                    $URL = "https://api.twilio.com/2010-04-01/Accounts/" . $sid . "/Messages";
                    $data = array("From" => $fromnumber, "To" => $Phone, "Body" => $Message);
                }
                return $this->cURL($URL, http_build_query($data), $sid, $token);
            }
            return "Is not live, did not contact";
        }

        //change an order status without being logged in
        function orderstatus($action, $email, $guid){
            $post = \Input::all();
            if (isset($post) && count($post) > 0 && !is_null($post)) {
                $URL = url('/orders/list/' . $action . '/email/' . $email . '/' . $guid);
                /*
                if (!isset($post['note']) || empty($post['note'])) {
                    return $this->failure("[Note Field] is missing!", $URL);
                } else {
                */
                    $Order = select_field("reservations", "guid", $guid);
                    if ($Order) {
                        $Restaurant = select_field("restaurants", "id", $Order->restaurant_id);
                        if ($Restaurant->email != $email) {//check if the email address specified is registed to this restaurant
                            $NotificationAddress = select_field("notification_addresses", "address", $email);
                            if ($NotificationAddress && $Order) {
                                $User = select_field("profiles", "id", $NotificationAddress->user_id);
                                if ($Order->restaurant_id != $User->restaurant_id) {
                                    $action = "Email address does not belong to the restaurant";
                                }
                            } else {
                                $action = "Email address not found";
                            }
                        }

                        if ($action) {
                            if ($action == "approve") {
                                return $this->changeOrderApprove("restaurant", $Order->id, $post['note']);
                            } else if ($action == "cancel") {
                                return $this->changeOrderCancel("restaurant", $Order->id, $post['note']);
                            }
                        }
                    } else {
                        $action = "Order not found";

                    return $this->failure($action, "/");
                }
            } else {
                $Order = select_field("reservations", "guid", $guid);
                if ($Order && $Order->status == "pending") {
                    return view('popups.mini_approve', array("action" => $action, "email" => $email, "guid" => $guid));
                }
                return $this->failure("That order either doesn't exist or has already been approved or denied", "/");
            }
        }

        function driverorders(){
            return view("orders.driverorders", $_GET);
        }
}
