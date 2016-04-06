<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AdministratorController extends Controller {

    /**
     * Constructor
     * @param null
     * @return redirect
     */
    public function __construct() {
        $this->beforeFilter(function () {
            initialize("admin");
        });
    }
    /**
     * Dashboard
     * @param null
     * @return view
     */
    public function dashboard($is_first_login=false) {

        $post = \Input::all();
        $todaytime = date("Ymdhis");

        if (isset($post) && count($post) > 0 && !is_null($post)) {
            //check for missing name/email
            if (!isset($post['name']) || empty($post['name'])) {
                //return $this->failure("[Name] field is missing!",'dashboard');
            }
            try {
                $ob = \App\Http\Models\Profiles::find(\Session::get('session_id'));
                //check old password, and both new passwords
                if (isset($post['old_password']) && !empty($post['old_password'])) {
                    $password = \Input::get('old_password');
                    if (!\Hash::check($password, $ob->password)) {
                        return $this->failure("[Old Password] is incorrect!",'dashboard');
                    }
                    if (empty($post['password'])) {
                        return $this->failure( "[New Password] is missing!",'dashboard');
                    }
                    $data['password'] = $post['password'];
                } else if ($post['password']){// || $post['confirm_password']) {
                    return $this->failure("[Old Password] is missing!",'dashboard');
                }

                $update=$post;
                $addlogo='';
                if (isset($post['userPhotoTemp']) && $post['userPhotoTemp'] != '') {
                    $im = explode('.', $post['photo']);
                    $ext = strtolower(end($im));
                    $newName="profile." . $ext;
    
                    $destinationPath = public_path('assets/images/users/' . $post['user_idDir']);
                    
                    //$imgVs=getimagesize($destinationPath . "/" . $post['photo']);

                    if (!file_exists($destinationPath)) {
                        mkdir('assets/images/users/' . $post['user_idDir'], 0777, true);
                    } else{
                        // rename existing images with timestamp, if they exist,
                        $oldImgExpl=explode(".",$ob->photo);
                        foreach(array("/icon-", "/small-", "/big-") as $file){ 
                            if(file_exists($destinationPath . $file . $ob->photo)){
                                rename($destinationPath . $file . $ob->photo, $destinationPath . $file . $oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                            }
                        }
                        
                       if(file_exists($destinationPath.$file.$ob->photo)){ // for original file with no prefix
                           rename($destinationPath . "/" . $ob->photo, $destinationPath . "/" . $oldImgExpl[0] . "_" . $todaytime . "." . $oldImgExpl[1]);
                       }
                    }


                    $filename = $destinationPath . "/" . $newName;
                    copy($post['userPhotoTemp'], $destinationPath.'/' .$newName); // use for copying and saving original image
                    
                    $sizes = ['assets/images/users/' . urldecode($post['user_idDir']) . '/icon-' => TINY_THUMB, 'assets/images/users/' . urldecode($post['user_idDir']) . '/small-' => MED_THUMB, 'assets/images/users/' . urldecode($post['user_idDir']) . '/big-' => BIG_SQ];


                    copyimages($sizes, $filename, $newName, true);
                    @unlink($destinationPath.'/'.$post['photo']); // unlink needs server path, not http path
                    $post['photo'] = $newName;
                    \Session::put('session_photo', $newName);
                    $addlogo=true;
                }

                //copy post data to an array
                $data['subscribed'] = 0;
                foreach(array('name','phone','mobile','status','photo','subscribed') as $key => $field){
                    if(isset($post[$field])){
                       if($key == "photo" && $post[$field] == ""){
                        continue;
                       }
                        $data[$field] = $post[$field];
                    }
                }

                $data['subscribed'] = (isset($post['subscribed'])) ? 1 : 0;
                //save the array to the database
                $ob->populate($data,$addlogo);
                $ob->save();

                event(new \App\Events\AppEvents($ob, "Profile Updated"));//log event

                if(isset($post['phone']) && !empty($post['phone'])){
                    $post['user_id'] = $ob->id;
                    $add = \App\Http\Models\ProfilesAddresses::findOrNew($post['adid']);
                    $add->populate(array_filter($post));
                    $add->save();
                }

                login($ob);//log in as this user
                \Session::flash('logoTS', $todaytime);
                return $this->success("Profile updated successfully", 'dashboard');
            } catch (\Exception $e) {
                return $this->failure(handleexception($e), 'dashboard');
            }
        } else {
            if(\Session::get('session_profiletype') == 2 && $is_first_login == true){
                return redirect('/');
            }
            $data['title'] = 'Dashboard';
            $data['user_detail'] = \App\Http\Models\Profiles::find(\Session::get('session_id'));


            $data['address_detail'] = \App\Http\Models\ProfilesAddresses::where('user_id', $data['user_detail']->id)->orderBy('id', 'DESC')->first();
            return view('dashboard.dashboard', $data);
        }
    }

    /**
     * Newsletter Setting
     * @param null
     * @return view
     */
    public function newsletter() {
        $post = \Input::all();
        if (isset($post) && count($post) > 0 && !is_null($post)) {//check for missing data
            if (!isset($post['subject']) || empty($post['subject'])) {
                return $this->failure("[Subject] field is missing!",'restaurant/newsletter');
            }
            if (!isset($post['message']) || empty($post['message'])) {
                return $this->failure("[Message] field is missing!", 'restaurant/newsletter');
            }
            try {//get each user that has subscribed to the newsletter and email them
                //this currently only works for existing users, but should be fixed so it only needs the email address
                $ob = \App\Http\Models\Newsletter::get();
                foreach ($ob as $value) {
                    $ob_user = \App\Http\Models\Profiles::where('email', $value->email)->where('status', 1)->first();//this should not be done
                    if (isset($ob_user) && count($ob_user) > 0 && !is_null($ob_user)) {
                        $array = $ob_user->toArray();
                        $array['mail_subject'] = $post['subject'];
                        $array['message'] = $post['message'];

                        $this->sendEMail("emails.newsletter", $array);
                    }
                }
                return $this->success( "Newsletter sent successfully",'restaurant/newsletter');
            } catch (\Exception $e) {
                return $this->failure(handleexception($e),'restaurant/newsletter');
            }
        } else {
            $data['title'] = 'Newsletter Send';
            return view('dashboard.administrator.newsletter', $data);
        }
    }



}
