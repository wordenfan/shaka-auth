<?php

namespace Cty\ShakaAuth\Plugin;

use DB;
use Illuminate\Support\Facades\Config;

class AuthMenu extends AbstractPermission
{
    /*
     * Tips:
     * 1.插件类的方法只有public方法会被检测到从而继承
     * 2.各插件间名字不能重复
    */

    public function __construct()
    {
        parent::__construct();
        $this->table_name = Config::get('shaka-auth.plugin.menu.table');
        $this->auth_type = Config::get('shaka-auth.plugin.menu.type');
    }

    /*
     * @param $attr 获取的字段
     */
    public function menu(Array $select=[]){
        $select = array_merge($select,['id','name','ref_id']);

        $return_arr = [];
        foreach($this->base_permission as $perm){
            $item = $perm->where('type',$this->auth_type)->select($select)->get()->toArray();
            $res = $this->getMenuDetail($item);
            $return_arr = $return_arr + $res;
        }

        $return_arr = $this->rankMenuList($return_arr,$this->menu_level);
        return $return_arr;
    }
}
