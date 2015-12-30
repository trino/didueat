<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UsersController extends Controller {
    
    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        $this->beforeFilter(function () {
            $act = str_replace('user.', '', \Route::currentRouteName());
            $act = str_replace('.store', '', $act);
            /*if (!\Session::has('is_logged_in') && $act != 'ajax_register') {
                //\Session::flash('message', trans('messages.user_session_exp.message'));
                //\Session::flash('message-type', 'alert-danger');
                //\Session::flash('message-short', 'Oops!');
                //return \Redirect::to('auth/login');
            }*/
            initialize("users");
        });
    }
    
    /**
     * adds an address to a profile, or edits an existing one
     * @param null
     * @return view
     */
    public function addresses($id = 0) {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['address']) || empty($post['address'])) {
                return $this->failure( "[Street address] field is missing!",'user/addresses');
            }
            if (!isset($post['city']) || empty($post['city'])) {
                return $this->failure("[City] field is missing!",'user/addresses');
            }
            if (!isset($post['province']) || empty($post['province'])) {
                \Session::flash('message', "[Province] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            if (!isset($post['country']) || empty($post['country'])) {
                return $this->failure( "[Country] field is missing!",'user/addresses');
            }
            try {
                $post['user_id'] = \Session::get('session_id');
                $idd = (isset($post['id'])) ? $post['id'] : '';
                
                if ($idd) {//id specified, edit it
                    $ob = \App\Http\Models\ProfilesAddresses::findOrNew($idd);
                } else {//no id specified, make one
                    $ob = new \App\Http\Models\ProfilesAddresses();
                }
                $ob->populate($post);
                $ob->save();

                return $this->success("Address created successfully",'user/addresses');
            } catch(\Exception $e) {
                return $this->failure( $e->getMessage(),'user/addresses');
            }
        } else {
            $data['title'] = "Addresses Manage";
            $data['countries_list'] = \App\Http\Models\Countries::get();//load all countries
            $data['states_list'] = \App\Http\Models\States::get();//load all provinces/states
            $data['addresses_list'] = \App\Http\Models\ProfilesAddresses::where('user_id', \Session::get('session_id'))->orderBy('order', 'ASC')->get();//load this user's addressess
            $data['addresse_detail'] = \App\Http\Models\ProfilesAddresses::find($id);//load a specific address id
            //echo '<pre>';print_r($data['addresses_list']->toArray()); die;
            return view('dashboard.user.addresses', $data);
        }
    }
    
    /**
     * Credit Card Sequance Change
     * @param none
     * @return response
     */
    public function addressesSequence() {
        $this->saveCreditCardsSequance();
    }
    
    /**
     * Address
     * @param $id
     * @returns a view, or a JSON object
     */
    public function addressesUpdate($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            echo json_encode(array('type' => 'error', 'message' => "[Id] is missing!"));
            die;
        }
        try {
            $data['countries_list'] = \App\Http\Models\Countries::get();//load all countries
            $data['states_list'] = \App\Http\Models\States::get();//load all states/provinces
            $data['addresse_detail'] = \App\Http\Models\ProfilesAddresses::find($id);//load a specific address id
            ob_start();
            return view('ajax.addresse_edit', $data);
            ob_get_contents();//code will never run
            ob_get_flush();
        } catch(\Exception $e) {
            echo json_encode(array('type' => 'error', 'message' => $e->getMessage()));
            die;
        }
    }
    
    /**
     * Delete profile Address $id
     * @param $id
     * @return redirect
     */
    public function addressesDelete($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {//check for missing data
            return $this->failure("[Id] is missing!", 'user/addresses');
        }
        try {
            $ob = \App\Http\Models\ProfilesAddresses::find($id);
            $ob->delete();
            return $this->success("Address has been deleted successfully!", 'user/addresses');
        } catch(\Exception $e) {
            return $this->failure(handleexception($e),'user/addresses');
        }
    }
    
    /**
     * edit review $id
     * @param $id
     * @return view
     */
    public function reviews($id = 0) {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['id']) || empty($post['id'])) {//check for missing data
                return $this->failure( '[ID] field is missing','user/reviews',true);
            }
            
            \DB::beginTransaction();
            try {
                $review = \App\Http\Models\RatingUsers::find($post['id']);
                $review->populate(array_filter($post));
                $review->save();
                \DB::commit();

                return $this->success('Review has been updated successfully.', 'user/reviews', true);
            } catch(\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return $this->failure( trans('messages.user_email_already_exist.message'), 'restaurant/users', true);
            } catch(\Exception $e) {
                \DB::rollback();
                return $this->failure(handleexception($e),'restaurant/users', true);
            }
        } else {
            $data['title'] = "User Reviews";
            $data['ratings'] = \App\Http\Models\RatingUsers::get();//get all reviews
            return view('dashboard.administrator.user_reviews', $data);
        }
    }
    
    /**
     * delete Reviews $id
     * @param $id
     * @return redirect
     */
    public function reviewAction($id = 0) {
        $ob = \App\Http\Models\RatingUsers::find($id);
        $ob->delete();

        return $this->success('Review has been deleted successfully!', 'user/reviews');
    }
    
    /**
     * Edit User Review Form
     * @param $id
     * @return view
     */
    public function ajaxEditUserReviewForm($id = 0) {
        $data['user_review_detail'] = \App\Http\Models\RatingUsers::find($id);
        
        //echo '<pre>'; print_r($data['address_detail']); die;
        return view('common.edituserreview', $data);
    }
    
    /**
     * change a profile image
     * @param null
     * @return view
     */
    public function images() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['restaurant_id']) || empty($post['restaurant_id'])) {
                return $this->failure("[Restaurant] field is missing!", 'user/images');
            }
            if (!isset($post['title']) || empty($post['title'])) {
                return $this->failure( "[Title] field is missing!",'user/images');
            }
            if (!\Input::hasFile('image')) {
                return $this->failure( "[Image] field is missing!",'user/images');
            }
            try {
                if (\Input::hasFile('image')) {
                    $image = \Input::file('image');
                    $ext = $image->getClientOriginalExtension();
                    $newName = substr(md5(uniqid(rand())), 0, 8) . '.' . $ext;
                    $destinationPath = public_path('assets/images/users');
                    $image->move($destinationPath, $newName);
                    $post['filename'] = $newName;
                }
                $post['user_id'] = \Session::get('session_id');
                
                $ob = new \App\Http\Models\ProfilesImages();
                $ob->populate($post);
                $ob->save();

                return $this->success( "Image uploaded successfully", 'user/images');
            }
            catch(\Exception $e) {
                return $this->failure(handleexception($e),'user/images');
            }
        } 
        else {
            $data['title'] = 'Images Manage';
            $data['restaurants_list'] = \App\Http\Models\Restaurants::get();//get all restaurants
            $data['images_list'] = \App\Http\Models\ProfilesImages::get();//get all profile images
            return view('dashboard.user.manage_image', $data);
        }
    }

    //create a new order via AJAX
    public function ajax_register() {
        $post = \Input::all();
        //echo '<pre>'.print_r($post); die;
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            \DB::beginTransaction();
            try {//populate data array
                $msg = "";
                $res['restaurant_id'] = $post['hidden_rest_id'];
                $res['user_id'] = $post['user_id'];
                $res['order_type'] = $post['order_type'];
                $res['order_time'] = date('Y-m-d h:i:s');
                $res['delivery_fee'] = $post['delivery_fee'];
                $res['res_id'] = $post['res_id'];
                $res['subtotal'] = $post['subtotal'];
                $res['g_total'] = $post['g_total'];
                $res['tax'] = $post['tax'];
                $res['listid'] = implode(',', $post['listid']);
                $res['prs'] = implode(',', $post['prs']);
                $res['qtys'] = implode(',', $post['qtys']);
                $res['extras'] = implode(',', $post['extras']);
                $res['menu_ids'] = implode(',', $post['menu_ids']);
                $res['restaurant_id'] = $post['res_id'];
                $res['order_till'] = $post['order_till'];
                
                if (\Input::has('address')) {
                    $res['address2'] = $post['address'];
                }
                if (\Input::has('city')) {
                    $res['city'] = $post['city'];
                }
                if (\Input::has('province')) {
                    $res['province'] = $post['province'];
                }
                if (\Input::has('country')) {
                    $res['country'] = $post['country'];
                }
                if (\Input::has('postal_code')) {
                    $res['postal_code'] = $post['postal_code'];
                }
                //echo '<pre>';print_r($res); die;
                $ob2 = new \App\Http\Models\Reservations();
                $ob2->populate($res);
                
                $ob2->save();
                $oid = $ob2->id;
                
                $data['email'] = $post['email'];
                $data['phone_no'] = $post['contact'];
                $data['name'] = trim($post['ordered_by']);
                $data['profile_type'] = 2;
                $data['created_by'] = 0;
                $data['subscribed'] = 0;
                $data['restaurant_id'] = 0;

                //if the user is not logged in, make a new user
                if (!\Session::has('session_id') && (isset($post['password']) && $post['password'] != '')) {
                    $data['password'] = encryptpassword($post['password']);
                    if (\App\Http\Models\Profiles::where('email', $data['email'])->first()) {
                        echo '1';
                        die();
                    } else {
                        //$data = array("name" => trim($name), "profile_type" => 2, "email" => $email_address, "created_by" => 0, "subscribed" => 0, 'password' => encryptpassword($password), 'restaurant_id' => '0');
                        $uid = new \App\Http\Models\Profiles();
                        $uid->populate($data);
                        $uid->save();
                        
                        event(new \App\Events\AppEvents($uid, "User Created"));
                        
                        $data['user_id'] = $uid->id;
                        
                        $nd1 = new \App\Http\Models\NotificationAddresses();
                        $nd1->populate(array("is_default" => 1, 'type' => "Email", 'user_id' => $uid->id, 'address' => $uid->email));
                        $nd1->save();
                        
                        if ($uid->id) {
                            $ad = new \App\Http\Models\ProfilesAddresses();
                            $ad->populate($data);
                            $ad->save();
                            
                            $nd2 = new \App\Http\Models\NotificationAddresses();
                            $nd2->populate(array("is_default" => 1, 'type' => "Phone", 'user_id' => $uid->id, 'address' => $ad->phone_no));
                            $nd2->save();
                            
                            $userArray = $uid->toArray();
                            $userArray['mail_subject'] = 'Thank you for registration.';
                            $this->sendEMail("emails.registration_welcome", $userArray);
                        }
                        $msg = "78";
                    }
                }
                
                $data['restaurant_id'] = $res['restaurant_id'];
                $data['remarks'] = $post['remarks'];
                $data['order_till'] = $post['order_till'];
                $data['contact'] = $post['contact'];
                $data['ordered_by'] = $data['name'];
                
                //$res_data = array('email' => $post['email'], /*'address2' => $post['address2'], 'city' => $post['city'], 'ordered_by' => $post['postal_code'],*/ 'remarks' => $post['remarks'], 'order_till' => $post['order_till'], 'contact' => $phone);
                $res = \App\Http\Models\Reservations::find($oid);
                $res->populate($data);
                $res->save();
                //echo '<pre>';print_r($res); die;
                event(new \App\Events\AppEvents($res, "Order Created"));
                
                if ($res->user_id) {
                    $u2 = \App\Http\Models\Profiles::find($res->user_id);
                    $userArray2 = $u2->toArray();
                    $userArray2['mail_subject'] = 'Your order has been received!';
                    $this->sendEMail("emails.order_user_notification", $userArray2);
                    
                    $notificationEmail = \App\Http\Models\Profiles::select('notification_addresses.*', 'profiles.name')->RightJoin('notification_addresses', 'profiles.id', '=', 'notification_addresses.user_id')->where('profiles.restaurant_id', $res->restaurant_id);
                    
                    //->where('is_default', 1)
                    if ($notificationEmail->count() > 0) {
                        foreach ($notificationEmail->get() as $resValue) {
                            if ($resValue->type == "Email") {
                                $userArray3['name'] = $resValue->name;
                                $userArray3['email'] = $resValue->address;
                                $userArray3['mail_subject'] = '[' . $u2->name . '] placed a new order!';
                                $this->sendEMail("emails.order_owner_notification", $userArray3);
                            }
                        }
                    }
                }
                
                echo $msg . '6';
                
                \DB::commit();
            } catch(\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                echo "Some Error occured. Please Try Again.";
                die();
            } catch(\Exception $e) {
                \DB::rollback();
                echo $e->getMessage();
                die();
            }
        } else {
            echo "Invalid request!";
        }
        die();
    }

    //converts the current profile to JSON
    function json_data() {
        $id = $_POST['id'];
        $user = \App\Http\Models\Profiles::select('profiles.id as user_id', 'profiles.name', 'profiles.email', 'profiles_addresses.phone_no as phone', 'profiles_addresses.address as street', 'profiles_addresses.post_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        
        //$user = \DB::table('profiles')->select('profiles.name', 'profiles.phone', 'profiles.email', 'profiles_addresses.street as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        
        return json_encode($user);
    }
}
