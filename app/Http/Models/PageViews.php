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
class PageViews extends BaseModel
{

    protected $table = 'page_views';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function populate($data)
    {
        $cells = array('user_id', 'target_id', 'ip_address', 'browser_name', 'browser_version', 'browser_platform', 'type');
        foreach ($cells as $cell) {
            if (array_key_exists($cell, $data)) {
                $this->$cell = $data[$cell];
            }
        }
    }

    public static function insertView($restaurant_id = 0)
    {
        $browser_info = getBrowser();
        $browser_name = $browser_info['name'];
        $browser_version = $browser_info['version'];
        $browser_platform = $browser_info['platform'];

        $data['user_id'] = (\Session::has('session_id')) ? \Session::get('session_id') : 0;
        $data['target_id'] = $restaurant_id;
        $data['ip_address'] = get_client_ip_server();
        $data['browser_name'] = $browser_name;
        $data['browser_version'] = $browser_version;
        $data['browser_platform'] = $browser_platform;
        $data['type'] = 'restaurant';

        $count = \App\Http\Models\PageViews::where('ip_address', $data['ip_address'])->where('browser_name', $data['browser_name'])->where('target_id', $restaurant_id)->where('type', 'restaurant')->count();
        if ($count == 0) {
            $ob = new PageViews();
            $ob->populate($data);
            $ob->save();
        }
    }

    public static function getView($restaurant_id = 0)
    {
        return \App\Http\Models\PageViews::where('target_id', $restaurant_id)->where('type', 'restaurant')->count();
    }


}