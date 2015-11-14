<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Newsletter
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Newsletter extends BaseModel
{

    protected $table = 'newsletter';
    protected $primaryKey = 'id';
    public $timestamps = true;

    /**
     * @param array
     * @return Array
     */
    public function populate($data)
    {
        $cells = array('email', 'status', 'guid');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }


////////////////////////////////////Newsletter API//////////////////////////////////
    public static function add_subscriber($email, $authorized = false)
    {
        $email = clean_email($email);
        if (is_valid_email($email)) {
            $Entry = get_entry("newsletter", $email, "email");
            $guid = "";
            if ($Entry) {
                if (!$Entry->guid) {
                    return true;
                }
                if (!$authorized) {
                    $guid = $Entry->guid;
                }
                update_database("newsletter", "id", $Entry->id, array("guid" => $guid));
            } else {
                if (!$authorized) {
                    $guid = com_create_guid();
                }
                new_entry("newsletter", "id", array("guid" => $guid, "email" => $email));
            }
            $path = '<A HREF="' . webroot() . "cuisine?action=subscribe&key=" . $guid . '">Click here to finish registration</A>';
            return handleevent($email, "subscribe", array("Path" => $path));
        }
    }

    public static function remove_subscriber($email)
    {
        $email = clean_email($email);
        delete_all("newsletter", array("email" => $email));
    }

    public static function is_subscribed($email)
    {
        $email = clean_email($email);
        return get_entry("newsletter", $email, "email");
    }

    public static function finish_subscription($Key)
    {
        $Entry = get_entry("newsletter", $Key, "guid");
        if ($Entry) {
            update_database("newsletter", "id", $Entry->id, array("guid" => ""));
            update_database("profiles", "email", $Entry->email, array("subscribed" => 1));
            return $Entry->email;
        }
    }

    function set_subscribed($email, $Status = false)
    {
        $email = clean_email($email);
        $is_subscribed = $this->is_subscribed($email) == true;
        if ($is_subscribed != $Status) {
            if ($Status) {
                $this->add_subscriber($email, True);
            } else {
                $this->remove_subscriber($email);
            }
        }
    }

    public static function enum_subscribers()
    {
        $Data = enum_all("newsletter", array("guid" => ""));
        return my_iterator_to_array($Data, "id", "email");
    }


}