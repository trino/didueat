<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * CreditCard
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class CreditCard extends BaseModel
{

    protected $table = 'credit_cards';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data)
    {
        $cells = array('first_name', 
                       'user_type',  
                       'profile_id',  
                       'last_name', 
                       'card_type', 
                       'card_number', 
                       'expiry_date', 
                       'expiry_month', 
                       'expiry_year', 
                       'ccv');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}