<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileTypes extends BaseModel {

    protected $table = 'profiletypes';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('name', 'hierarchy', 'can_create_profiles', 'can_edit_global_settings', 'can_hire_or_fire', 'can_possess');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

    function edit_profiletype($id = "", $name, $hierarchy, $permissions = "") {
        if (!$id) {
            $id = $this->new_profiletype($name);
        }
        logevent("Changed profile type: " . $id . " (" . $name . ", " . $hierarchy . ", " . print_r($permissions, true) . ")", false);
        $data = array("name" => $name, "hierarchy" => $hierarchy);
        if ($permissions == "ALL") {
            $permissions = $this->get_profile_permissions();
        }
        if (!is_array($permissions) && $permissions) {
            $permissions = array($permissions);
        }
        if (is_array($permissions)) {
            foreach ($permissions as $Permission) {
                $data[$Permission] = "1";
            }
        }
        update_database("profiletypes", "id", $id, $data);
        return $id;
    }

    //creates a new profile type with the name of $name
    function new_profiletype($name) {
        logevent("Made a new profile type: " . $name, false);
        return new_anything("profiletypes", array("name" => $name));
    }

    //returns an array of permissions available for profile types
    function get_profile_permissions() {
        return getColumnNames("profiletypes", array("id", "name", "hierarchy"));
    }
}