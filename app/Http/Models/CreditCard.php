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
class CreditCard extends BaseModel {
    protected $table = 'credit_cards';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {
        $cells = array('first_name'     => true,
                       'user_type'      => false,
                       'profile_id'     => false,
                       'last_name'      => true,
                       'card_type'      => false,
                       'card_number'    => true,
                       'expiry_date'    => true,
                       'expiry_month'   => true,
                       'expiry_year'    => true,
                       'ccv'            => true,
                       'order'          => false,
        );
        foreach ($cells as $cell => $NeedsEncryption) {
            if (array_key_exists($cell, $data)) {
                if($NeedsEncryption){
                    $data[$cell] = \Crypt::encrypt($data[$cell]);
                    //use \Crypt::decrypt($encryptedValue); to decrypt
                }
                $this->$cell = $data[$cell];
            }
        }
    }
}