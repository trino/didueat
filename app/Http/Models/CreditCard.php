<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CreditCard extends BaseModel {
    protected $table = 'credit_cards';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data) {//    encrypted
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