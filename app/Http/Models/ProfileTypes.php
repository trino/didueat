<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * ProfileTypes
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class ProfileTypes extends BaseModel {

    protected $table = 'profiletypes';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('Name', 'Hierarchy', 'CanCreateProfiles', 'CanEditGlobalSettings', 'CanHireOrFire', 'CanPossess');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }

        /*
        if (array_key_exists('Name', $data)) {
            $this->Name = $data['Name'];
        }
        if (array_key_exists('Hierarchy', $data)) {
            $this->Hierarchy = $data['Hierarchy'];
        }
        if (array_key_exists('CanCreateProfiles', $data)) {
            $this->CanCreateProfiles = $data['CanCreateProfiles'];
        }
        if (array_key_exists('CanEditGlobalSettings', $data)) {
            $this->CanEditGlobalSettings = $data['CanEditGlobalSettings'];
        }
        if (array_key_exists('CanHireOrFire', $data)) {
            $this->CanHireOrFire = $data['CanHireOrFire'];
        }
        if (array_key_exists('CanPossess', $data)) {
            $this->CanPossess = $data['CanPossess'];
        }*/
    }
    
}