<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PageViews extends BaseModel {

    protected $table = 'page_views';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function populate($data) {
        $cells = array('user_id', 'target_id', 'ip_address', 'browser_name', 'browser_version', 'browser_platform', 'type');
        $this->copycells($cells, $data);
    }

    public static function insertView($id = 0, $type = "") {
        $browser_info = getBrowser();
        $data['user_id'] = (\Session::has('session_id')) ? \Session::get('session_id') : 0;
        $data['target_id'] = $id;
        $data['ip_address'] = get_client_ip_server();
        $data['browser_name'] = $browser_info['name'];
        $data['browser_version'] = $browser_info['version'];
        $data['browser_platform'] = $browser_info['platform'];
        $data['type'] = $type;

        $count = \App\Http\Models\PageViews::where('ip_address', $data['ip_address'])->where('browser_name', $data['browser_name'])->where('target_id', $id)->where('user_id', $data['user_id'])->where('type', $type)->count();
        if ($count == 0) {
            $ob = new PageViews();
            $ob->populate($data);
            $ob->save();
        }
    }

    public static function getView($id = 0, $type = "") {
        return \App\Http\Models\PageViews::where('target_id', $id)->where('type', $type)->count();
    }
}