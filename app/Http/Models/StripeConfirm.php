<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
 
class StripeConfirm extends BaseModel {

    protected $table = 'reservations';
    protected $primaryKey = 'id';

    /**
     * @param array
     * @return Array
     */

    public function populate($data) {
        $cells=array('stripeToken','status','user_id');
        $this->copycells($cells, $data);
    }

}  