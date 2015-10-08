<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Postalcodes
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Postalcodes extends BaseModel {

    protected $table = 'postalcodes';
    protected $primaryKey = 'id';
    public $timestamps = true;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('postal_code', 'number', 'street', 'city', 'province', 'lattitude', 'longitude', 'short_street', 'short_street_type', 'short_street_dir');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('PostalCode', $data)) {
            $this->PostalCode = $data['PostalCode'];
        }
        if (array_key_exists('Number', $data)) {
            $this->Number = $data['Number'];
        }
        if (array_key_exists('Street', $data)) {
            $this->Street = $data['Street'];
        }
        if (array_key_exists('City', $data)) {
            $this->City = $data['City'];
        }
        if (array_key_exists('Province', $data)) {
            $this->Province = $data['Province'];
        }
        if (array_key_exists('Lattitude', $data)) {
            $this->Lattitude = $data['Lattitude'];
        }
        if (array_key_exists('Longitude', $data)) {
            $this->Longitude = $data['Longitude'];
        }
        if (array_key_exists('ShortStreet', $data)) {
            $this->ShortStreet = $data['ShortStreet'];
        }
        if (array_key_exists('ShortStreetType', $data)) {
            $this->ShortStreetType = $data['ShortStreetType'];
        }
        if (array_key_exists('ShortStreetDir', $data)) {
            $this->ShortStreetDir = $data['ShortStreetDir'];
        }*/
    }
    
}