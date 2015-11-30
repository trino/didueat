<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Tag
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Tag extends BaseModel
{

    protected $table = 'tags';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function populate($data)
    {
        $cells = array('name', 'is_active');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

}