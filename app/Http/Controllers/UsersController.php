<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Users
 * @package    Laravel 5.1.11
 * @subpackage Controller
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       15 September, 2015
 */
class UsersController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {

        $this->beforeFilter(function() {
            $act = str_replace('user.', '', \Route::currentRouteName());
            $act = str_replace('.store', '', $act);
            if (!\Session::has('is_logged_in') && $act != 'ajax_register') {
                //\Session::flash('message', trans('messages.user_session_exp.message')); 
                //\Session::flash('message-type', 'alert-danger');
                //\Session::flash('message-short', 'Oops!');
                //return \Redirect::to('auth/login');
            }
            initialize("users");
        });
    }

    /**
     * Addresses
     * @param null
     * @return view
     */
    public function addresses($id = 0) {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['street']) || empty($post['street'])) {
                \Session::flash('message', "[Street address] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            if (!isset($post['apt']) || empty($post['apt'])) {
                \Session::flash('message', "[Apartment/Unit/ Room] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            if (!isset($post['city']) || empty($post['city'])) {
                \Session::flash('message', "[City] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            if (!isset($post['province']) || empty($post['province'])) {
                \Session::flash('message', "[Province] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            if (!isset($post['country']) || empty($post['country'])) {
                \Session::flash('message', "[Country] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
            try {
                $post['user_id'] = \Session::get('session_id');
                $idd = (isset($post['id']))?$post['id']:'';
                
                if($idd){
                    $ob = \App\Http\Models\ProfilesAddresses::findOrNew($idd);
                } else {
                    $ob = new \App\Http\Models\ProfilesAddresses();
                }
                $ob->populate($post);
                $ob->save();
                
                \Session::flash('message', "Address created successfully");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('user/addresses/' . $ob->id);
            } catch (\Exception $e) {
                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/addresses');
            }
        } else {
            $data['title'] = "Addresses Manage";
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['addresses_list'] = \App\Http\Models\ProfilesAddresses::get();
            $data['addresse_detail'] = \App\Http\Models\ProfilesAddresses::find($id);
            return view('dashboard.user.addresses', $data);
        }
    }

    /**
     * Addresse Update
     * @param $id
     * @return response
     */
    public function addressesUpdate($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            echo json_encode(array('type' => 'error', 'message' => "[Id] is missing!")); die;
        }

        try {
            $data['countries_list'] = \App\Http\Models\Countries::get();
            $data['addresse_detail'] = \App\Http\Models\ProfilesAddresses::find($id);
            ob_start();
            return view('ajax.addresse_edit', $data);
            ob_get_contents();
            ob_get_flush();
        } catch (\Exception $e) {
            echo json_encode(array('type' => 'error', 'message' => $e->getMessage())); die;
        }
    }

    /**
     * Addresses Delete
     * @param $id
     * @return redirect
     */
    public function addressesDelete($id = 0) {
        if (!isset($id) || empty($id) || $id == 0) {
            \Session::flash('message', "[Id] is missing!");
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('user/addresses');
        }

        try {
            $ob = \App\Http\Models\ProfilesAddresses::find($id);
            $ob->delete();

            \Session::flash('message', "Address has been deleted successfully!");
            \Session::flash('message-type', 'alert-sucess');
            \Session::flash('message-short', 'Congratulations!');
            return \Redirect::to('user/addresses');
        } catch (\Exception $e) {

            \Session::flash('message', $e->getMessage());
            \Session::flash('message-type', 'alert-danger');
            \Session::flash('message-short', 'Oops!');
            return \Redirect::to('user/addresses');
        }
    }

    /**
     * View Orders
     * @param null
     * @return view
     */
    public function viewOrders() {
        return view('dashboard.user.orders_view', array('title' => 'View Orders'));
    }

    /**
     * Upload Meal
     * @param null
     * @return view
     */
    public function uploadMeal() {
        return view('dashboard.user.manage_meal', array('title' => 'Upload Meal'));
    }

    /**
     * Images Manage
     * @param null
     * @return view
     */
    public function images() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {
            if (!isset($post['restaurant_id']) || empty($post['restaurant_id'])) {
                \Session::flash('message', "[Restaurant] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/images');
            }
            if (!isset($post['title']) || empty($post['title'])) {
                \Session::flash('message', "[Title] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/images');
            }
            if (!\Input::hasFile('image')) {
                \Session::flash('message', "[Image] field is missing!");
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/images');
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

                \Session::flash('message', "Image uploaded successfully");
                \Session::flash('message-type', 'alert-success');
                \Session::flash('message-short', 'Congratulations!');
                return \Redirect::to('user/images');
            } catch (\Exception $e) {

                \Session::flash('message', $e->getMessage());
                \Session::flash('message-type', 'alert-danger');
                \Session::flash('message-short', 'Oops!');
                return \Redirect::to('user/images');
            }
        } else {
            $data['title'] = 'Images Manage';
            $data['restaurants_list'] = \App\Http\Models\Restaurants::get();
            $data['images_list'] = \App\Http\Models\ProfilesImages::get();
            return view('dashboard.user.manage_image', $data);
        }
    }

    public function ajax_register() {
        if (isset($_POST)) {
            \DB::beginTransaction();
            try {
                $res['user_id'] = $_POST['user_id'];
                $res['order_type'] = $_POST['order_type'];
                $res['order_time'] = date('Y-m-d h:i:s');
                $res['delivery_fee'] = $_POST['delivery_fee'];
                $res['res_id'] = $_POST['res_id'];
                $res['subtotal'] = $_POST['subtotal'];
                $res['g_total'] = $_POST['g_total'];
                $res['tax'] = $_POST['tax'];
                $res['listid'] = implode(',', $_POST['listid']);
                $res['prs'] = implode(',', $_POST['prs']);
                $res['qtys'] = implode(',', $_POST['qtys']);
                $res['extras'] = implode(',', $_POST['extras']);
                $res['menu_ids'] = implode(',', $_POST['menu_ids']);
                $res['restaurant_id'] = $_POST['res_id'];
                $res['order_till'] = $_POST['order_till'];
                $ob2 = new \App\Http\Models\Reservations();
                $ob2->populate($res);
                $ob2->save();
                $order_id = $ob2->id;
                \DB::commit();
            } catch (\Illuminate\Database\QueryException $e) {
                \DB::rollback();
                echo "Some Error occured. Please Try Again.";
                die();
            } catch (\Exception $e) {
                \DB::rollback();
                echo $e->getMessage();
                die();
            }

            $email_address = $_POST['email'];
            $password = $_POST['password'];
            $phone = $_POST['contact'];
            $name = $_POST['ordered_by'];
            $oid = $order_id;

            if (isset($_POST['password']) && $_POST['password'] != '') {
                if (\DB::table('profiles')->where('email', $email_address)->first()) {
                    echo '1';
                    die();
                } else {
                    $uid = \DB::table('profiles')->insertGetId(
                            array("name" => trim($name), "profile_type" => 2, "phone" => $phone, "email" => $email_address, "created_by" => 0, "subscribed" => 0, 'password' => encryptpassword($password), 'restaurant_id' => '0')
                    );

                    $user = \DB::table('profiles')->where('id', $uid)->first();
                    $userArray = (array) $user;
                    //var_dump($userArray); die();
                    $userArray['mail_subject'] = 'Thank you for registration.';
                    $this->sendEMail("emails.registration_welcome", $userArray);
                    //$this->Manager->new_profile(0, $name, $password, 2, $email_address, $phone, 0, '0');
                }
            }
            \DB::table('reservations')
                    ->where('id', $oid)
                    ->update(array('email' => $_POST['email'], 'address2' => $_POST['address2'], 'city' => $_POST['city'], 'ordered_by' => $_POST['postal_code'], 'remarks' => $_POST['remarks'], 'order_till' => $_POST['order_till'], 'province' => $_POST['province'], 'contact' => $phone));
            echo '0';
        }
        die();
    }

    function json_data() {
        $id = $_POST['id'];
        $user = \App\Http\Models\Profiles::select('profiles.name', 'profiles.phone', 'profiles.email', 'profiles_addresses.street as street', 'profiles_addresses.post_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();
        //$user = \DB::table('profiles')->select('profiles.name', 'profiles.phone', 'profiles.email', 'profiles_addresses.street as street', 'profiles_addresses.postal_code', 'profiles_addresses.city', 'profiles_addresses.province')->where('profiles.id', \Session::get('session_id'))->LeftJoin('profiles_addresses', 'profiles.id', '=', 'profiles_addresses.user_id')->first();

        return json_encode($user);
    }

}
