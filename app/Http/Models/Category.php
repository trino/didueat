<?php
namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;

/**
 * Category
 * @package    Laravel 5.1.11
 * @subpackage Model
 * @author     Skp Software Technologies
 * @developer  Waqar Javed
 * @date       20 September, 2015
 */
class Category extends BaseModel {

    protected $table = 'category';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    /**
     * @param array
     * @return Array
     */
    

}