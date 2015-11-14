<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Profiles
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Profiles extends BaseModel
{

    protected $table = 'profiles';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $hidden = array('password');

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('profile_type', 'name', 'email', 'password', 'photo', 'subscribed', 'restaurant_id', 'created_by', 'status', 'created_at', 'updated_at', 'deleted_at');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                if (isset($data['password']) && $data[$cell] == $data['password'] && trim($data['password']) != "") {
                    $this->generatePassword($data['password']);
                } else {
                    $this->$cell = $data[$cell];
                }
            }
        }
    }

    /**
     * Function generatePassword
     * This function will generate a random string for encrypted passwords
     * @param $password
     * @return encrypted string
     */
    public function generatePassword($password)
    {
        $this->password = \bcrypt($password);
    }

    function edit_profile($id, $name, $email_address, $phone, $password, $subscribed = 0, $profile_type = 0)
    {
        $data = array("name" => trim($name), "email" => clean_email($email_address), "phone" => clean_phone($phone), "subscribed" => $subscribed);
        if ($password) {
            $data["password"] = \bcrypt($password);
        }
        if ($profile_type) {
            $data["profile_type"] = $profile_type;
        }
        $this->set_subscribed($email_address, $subscribed);
        return update_database("profiles", "id", $id, $data);
    }

    function set_subscribed($email_address, $status = false)
    {
        $ob = new \App\Http\Models\Newsletter();
        $ob->set_subscribed($email_address, $status);
    }

    function forgot_password($email, $password = "")
    {
        $email = clean_email($email);
        $profile = get_entry("profiles", $email, "email");
        if ($profile) {
            if (!$password) {
                $password = randomPassword();
            }
            $Encrypted = \bcrypt($password);
            update_database("profiles", "id", $profile->id, array("password" => $Encrypted));
            return $password;
        }
    }

    function find_profile($email_address, $password)
    {
        $email_address = clean_email($email_address);
        $password = \bcrypt($password);
        $ProfileMatch = enum_all("profiles", array("email" => $email_address, "password" => $password));
        return first($ProfileMatch);
    }

    function new_profile($created_by, $name, $password, $profile_type, $email_address, $photo, $restaurant_id, $subscribed = "")
    {
        $email_address = is_valid_email($email_address);
        $photo = clean_phone($photo);
        if (!$email_address) {
            return false;
        }
        if (get_entry("profiles", $email_address, "email")) {
            return false;
        }
        if (!$password) {
            $password = randomPassword();
        }
        if ($subscribed) {
            $subscribed = 1;
        } else {
            $subscribed = 0;
        }
        $Encrypted = \bcrypt($password);
        $data = array("Name" => trim($name), "ProfileType" => $profile_type, "photo" => $photo, "email" => $email_address, "created_by" => 0, "restaurant_id" => $restaurant_id, "subscribed" => $subscribed, "password" => $Encrypted);
        if ($created_by) {
            if (!$this->can_profile_create($created_by, $profile_type)) {
                return false;
            }//blocks users from creating users of the same type
            $data["created_by"] = $created_by;
        }
        $data = edit_database("profiles", "id", "", $data);
        $data["password"] = $password;
        if ($created_by) {
            logevent("Created user: " . $data["id"] . " (" . $data["name"] . ")");
        }

        handleevent($email_address, "new_profile", array("Profile" => $data));
        $this->set_subscribed($email_address, $subscribed);
        return $data;
    }

    function can_profile_create($ProfileID, $profile_type)
    {
        $creatorprofiletype = get_profile_type($ProfileID);
        if ($creatorprofiletype->can_create_profiles) {
            $profile_type = get_profile_type($profile_type, true);
            return $creatorprofiletype->hierarchy < $profile_type->hierarchy;
        }
    }
}