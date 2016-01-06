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
            initialize("users");
        });
    }
    
    /**
     * Users List
     * @param null
     * @return view
     */
    public function index() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            //check for missing data
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure('[Name] field is missing','users/list', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/list', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->count();
            if ($is_email > 0) {
                return $this->failure( trans('messages.user_email_already_exist.message'),'users/list', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure( trans('messages.user_pass_field_missing.message'),'users/list', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure(trans('messages.user_confim_pass_field_missing.message'),'users/list', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'users/list', true);
            }

            \DB::beginTransaction();
            try {//construct profile as an array
                $post['status'] = 1;
                $post['is_email_varified'] = 0;
                $post['profile_type'] = 2;
                $post['subscribed'] = (isset($post['subscribed']))?$post['subscribed']:0;
                $post['created_by'] = \Session::get('session_id');

                $browser_info = getBrowser();//get user's web browser/OS data
                $post['ip_address'] = get_client_ip_server();
                $post['browser_name'] = $browser_info['name'];
                $post['browser_version'] = $browser_info['version'];
                $post['browser_platform'] = $browser_info['platform'];

                $user = new \App\Http\Models\Profiles();
                $user->populate(array_filter($post));
                $user->save();
                event(new \App\Events\AppEvents($user, "User created"));
                
                if(isset($user->id)){//save address
                    $add = new \App\Http\Models\ProfilesAddresses();
                    $post['user_id'] = $user->id;
                    $add->populate(array_filter($post));
                    $add->save();

                    $userArray = $user->toArray();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    \DB::commit();
                }

                return $this->success('User has been added successfully. A confirmation email has been sent to the selected email address for verification.', 'users/list', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return $this->failure(trans('messages.user_email_already_exist.message'), 'users/list', true);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure( handleexception($e), 'users/list', true);
            }
        } else {//get data to load the page
            $data['title'] = 'Users List';
            $data['states_list'] = \App\Http\Models\States::get();
            $data['restaurants_list'] = \App\Http\Models\Restaurants::where('open', 1)->orderBy('id', 'DESC')->get();
            return view('dashboard.user.index', $data);
        }
    }
    
    /**
     * Listing Ajax
     * @return Response
     */
    public function listingAjax() {
        $per_page = \Input::get('showEntries');
        $page = \Input::get('page');
        $cur_page = $page;
        $page -= 1;
        $start = $page * $per_page;

        $data = array(
            'page' => $page,
            'cur_page' => $cur_page,
            'per_page' => $per_page,
            'start' => $start,
            'meta' => (\Input::get('meta')) ? \Input::get('meta') : 'id',
            'order' => (\Input::get('order')) ? \Input::get('order') : 'DESC',
            'searchResults' => \Input::get('searchResults')
        );
        
        $Query = \App\Http\Models\Profiles::listing($data, "list")->get();
        $recCount = \App\Http\Models\Profiles::listing($data)->count();
        $no_of_paginations = ceil($recCount / $per_page);
        
        $data['Query'] = $Query;
        $data['recCount'] = $recCount;
        $data['Pagination'] = getPagination($recCount, $no_of_paginations, $cur_page, TRUE, TRUE, TRUE, TRUE);
        
        \Session::flash('message', \Input::get('message'));
        return view('dashboard.user.ajax.list', $data);
    }

    
    /**
     * Edit User Form
     * @param $id
     * @return view
     */
    public function ajaxEditUserForm($id=0) {
        if($id) {
            $data['user_detail'] = \App\Http\Models\Profiles::find($id);
            $data['address_detail'] = \App\Http\Models\ProfilesAddresses::where('user_id', $data['user_detail']->id)->orderBy('id', 'DESC')->first();
        }
        $data['restaurants_list'] = \App\Http\Models\Restaurants::where('open', 1)->orderBy('id', 'DESC')->get();
        $data['states_list'] = \App\Http\Models\States::get();
        //echo '<pre>'; print_r($data['address_detail']); die;
        return view('common.edituser', $data);
    }


    /**
     * Users List
     * @param null
     * @return view
     */
    public function userUpdate() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing or duplicate data
            if (!isset($post['id']) || empty($post['id'])) {
                return $this->failure('[ID] field is missing', 'users/list', true);
            }
            if (!isset($post['name']) || empty($post['name'])) {
                return $this->failure('[Name] field is missing','users/list', true);
            }
            if (!isset($post['email']) || empty($post['email'])) {
                return $this->failure(trans('messages.user_missing_email.message'),'users/list', true);
            }
            $is_email = \App\Http\Models\Profiles::where('email', '=', $post['email'])->where('id', '!=', $post['id'])->count();
            if ($is_email > 0) {
                return $this->failure(trans('messages.user_email_already_exist.message'),'users/list', true);
            }
            if (!isset($post['password']) || empty($post['password'])) {
                return $this->failure( trans('messages.user_pass_field_missing.message'),'users/list', true);
            }
            if (!isset($post['confirm_password']) || empty($post['confirm_password'])) {
                return $this->failure(trans('messages.user_confim_pass_field_missing.message'),'users/list', true);
            }
            if ($post['password'] != $post['confirm_password']) {
                return $this->failure(trans('messages.user_passwords_mismatched.message'),'users/list', true);
            }
            \DB::beginTransaction();
            try {//save user's browser/OS info
                $browser_info = getBrowser();
                $post['ip_address'] = get_client_ip_server();
                $post['browser_name'] = $browser_info['name'];
                $post['browser_version'] = $browser_info['version'];
                $post['browser_platform'] = $browser_info['platform'];

                $user = \App\Http\Models\Profiles::find($post['id']);
                $user->populate(array_filter($post));
                $user->save();
                
                event(new \App\Events\AppEvents($user, "User updated"));

                if(isset($post['adid']) && !empty($post['adid'])){
                    $add = \App\Http\Models\ProfilesAddresses::find($post['adid']);
                    $add->populate(array_filter($post));
                    $add->save();

                    \DB::commit();
                }

                return $this->success( 'User has been updated successfully.', 'users/list', true);
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                return $this->failure( trans('messages.user_email_already_exist.message'), 'users/list', true);
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->failure(handleexception($e),'users/list', true);
            }
        } else {
            return $this->failure( "Invalid parsed data!",'users/list', true);
        }
    }
    
    /**
     * Users Action
     * @param $type
     * @param $id
     * @return redirect
     */
    public function usersAction($type = '', $id = 0) {
        //check for missing type/id
        if (!isset($type) || empty($type)) {
            return $this->failure("[Type] is missing!", 'users/list');
        }
        if (!isset($id) || empty($id) || $id == 0) {
            return $this->failure("[Profile Id] is missing!", 'users/list');
        }
        try {
            $ob = \App\Http\Models\Profiles::find($id);//search for user $id
            switch ($type){
                case "user_fire"://fire user by deleting them
                    $ob->delete();
                    break;
                case "user_hire"://hire user by changing the profile type to employee
                    $ob->populate(array('profile_type' => 1));
                    $ob->save();
                    break;
                case "user_possess":
                    login($id, true);
                    break;
                case "user_depossess":
                    login(read("oldid"));
                    break;
                default:
                    return $this->failure("'" . $type . "' is not handled", 'users/list');
            }
            event(new \App\Events\AppEvents($ob, "User Status Changed"));//log event
            return $this->success('Status has been changed successfully!', 'users/list');
        } catch (\Exception $e) {
            return $this->failure( handleexception($e), 'users/list');
        }
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
                $ob2->populate($res, "guid");
                
                $ob2->save();
                $oid = $ob2->id;
                
                $data['email'] = $post['email'];
                $data['phone'] = $post['contact'];
                $data['name'] = trim($post['ordered_by']);
                $data['profile_type'] = 2;
                $data['created_by'] = 0;
                $data['subscribed'] = 0;
                $data['restaurant_id'] = 0;

                //if the user is not logged in and specified a password, make a new user
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
                            $nd2->populate(array("is_default" => 1, 'type' => "Phone", 'user_id' => $uid->id, 'address' => $ad->phone));
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
                        $userArray3['mail_subject'] = '[' . $u2->name . '] placed a new order!';
                        $userArray3["guid"] = $ob2->guid;
                        foreach ($notificationEmail->get() as $resValue) {
                            if ($resValue->type == "Email") {
                                $userArray3['name'] = $resValue->name;
                                $userArray3['email'] = $resValue->address;
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
                echo handleexception($e);
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
        $user = \App\Http\Models\Profiles::select('profiles.id as user_id', 'profiles.name', 'profiles.email', 'profiles_addresses.phone as phone', 'profiles_addresses.address as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        
        //$user = \DB::table('profiles')->select('profiles.name', 'profiles.phone', 'profiles.email', 'profiles_addresses.street as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        
        return json_encode($user);
    }
}
