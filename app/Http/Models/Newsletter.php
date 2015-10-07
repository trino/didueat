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
class Newsletter extends BaseModel {

    protected $table = 'newsletter';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('Email', 'GUID');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('Email', $data)) {
            $this->Email = $data['Email'];
        }
        if (array_key_exists('GUID', $data)) {
            $this->GUID = $data['GUID'];
        }*/
    }


////////////////////////////////////Newsletter API//////////////////////////////////
    function add_subscriber($EmailAddress, $authorized = false){
        $EmailAddress = clean_email($EmailAddress);
        if(is_valid_email($EmailAddress)) {
            $Entry = get_entry("newsletter", $EmailAddress, "Email");
            $GUID="";
            if ($Entry) {
                if (!$Entry->GUID) { return true; }
                if(!$authorized){$GUID = $Entry->GUID;}
                update_database("newsletter", "ID", $Entry->ID, array("GUID" => $GUID));
            } else {
                if(!$authorized){$GUID = com_create_guid();}
                new_entry("newsletter", "ID", array("GUID" => $GUID, "Email" => $EmailAddress));
            }
            $path = '<A HREF="' . webroot() . "cuisine?action=subscribe&key=" . $GUID . '">Click here to finish registration</A>';
            return handleevent($EmailAddress, "subscribe", array("Path" => $path));
        }
    }

    function remove_subscriber($EmailAddress){
        $EmailAddress = clean_email($EmailAddress);
        delete_all("newsletter", array("Email" => $EmailAddress));
    }

    function is_subscribed($EmailAddress){
        $EmailAddress = clean_email($EmailAddress);
        return get_entry("newsletter", $EmailAddress, "Email");
    }

    function finish_subscription($Key){
        $Entry = get_entry("newsletter", $Key, "GUID");
        if($Entry){
            update_database("newsletter", "ID", $Entry->ID, array("GUID" => ""));
            update_database("profiles", "Email", $Entry->Email, array("subscribed" => 1));
            return $Entry->Email;
        }
    }

    function set_subscribed($EmailAddress, $Status = false){
        $EmailAddress = clean_email($EmailAddress);
        $is_subscribed = $this->is_subscribed($EmailAddress) == true;
        if($is_subscribed != $Status){
            if($Status){
                $this->add_subscriber($EmailAddress, True);
            } else {
                $this->remove_subscriber($EmailAddress);
            }
        }
    }
    function enum_subscribers(){
        $Data = enum_all("newsletter", array("GUID" => ""));
        return my_iterator_to_array($Data, "ID", "Email");
    }


}