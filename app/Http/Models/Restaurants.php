<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Restaurants
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Restaurants extends BaseModel {

    protected $table = 'restaurants';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    public function populate($data) {
        $cells = array('Name', 'Slug', 'Genre', 'Email', 'Phone', 'Address', 'City', 'Province', 'Country', 'PostalCode', 'Description', 'Logo', 'DeliveryFee', 'Minimum', 'Status');
        foreach($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
        /*
        if (array_key_exists('Name', $data)) {
            $this->Name = $data['Name'];
        }
        if (array_key_exists('Slug', $data)) {
            $this->Slug = $data['Slug'];
        }
        if (array_key_exists('Genre', $data)) {
            $this->Genre = $data['Genre'];
        }
        if (array_key_exists('Email', $data)) {
            $this->Email = $data['Email'];
        }
        if (array_key_exists('Phone', $data)) {
            $this->Phone = $data['Phone'];
        }
        if (array_key_exists('Address', $data)) {
            $this->Address = $data['Address'];
        }
        if (array_key_exists('City', $data)) {
            $this->City = $data['City'];
        }
        if (array_key_exists('Province', $data)) {
            $this->Province = $data['Province'];
        }
        if (array_key_exists('Country', $data)) {
            $this->Country = $data['Country'];
        }
        if (array_key_exists('PostalCode', $data)) {
            $this->PostalCode = $data['PostalCode'];
        }
        if (array_key_exists('Description', $data)) {
            $this->Description = $data['Description'];
        }
        if (array_key_exists('Logo', $data)) {
            $this->Logo = $data['Logo'];
        }
        if (array_key_exists('DeliveryFee', $data)) {
            $this->DeliveryFee = $data['DeliveryFee'];
        }
        if (array_key_exists('Minimum', $data)) {
            $this->Minimum = $data['Minimum'];
        }
        if (array_key_exists('Status', $data)) {
            $this->Status = $data['Status'];
        }*/
    }
    
}