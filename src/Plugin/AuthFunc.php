<?php

namespace Cty\ShakaAuth\Plugin;

use DB;
use Illuminate\Support\Facades\Config;

class AuthFunc extends AbstractPermission
{
    /*
     * Tips:
     * 1.插件类的方法只有public方法会被检测到从而继承
     * 2.各插件间名字不能重复
    */

    public function __construct()
    {
        parent::__construct();
        $this->table_name = Config::get('shaka-auth.plugin.func.table');
        $this->auth_type = Config::get('shaka-auth.plugin.func.type');
    }

    /*
     * web管理后台获得的api的勾选菜单树
     *
     * @param $attr 获取的字段
     * return Array
     */
    public function func(Array $select=[]){
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

    /*
     * @param $mca 包含mca的数组
     *
     * return 实例 或 bool
     */
    public function getFuncIdWithPermissionId(Array $mca){
        $ref_id = $this->getFuncId($mca);
        if(!$ref_id){
            return $ref_id;
        }

        $cond['type'] = $this->auth_type;
        $cond['ref_id'] = $ref_id;

        $res = DB::table($this->base_permission_table)->where($cond)->first();
        return $res ? $res->id : false;
    }

    /*
     * @param $mca 包含mca的数组
     *
     * return 实例 或 bool
     */
    private function getFuncId(Array $mca){
        $cond['m'] = strtolower($mca['m']??'');
        $cond['c'] = strtolower($mca['c']??'');
        $cond['a'] = strtolower($mca['a'])??'';
        $cond = array_filter($cond);

        if(count($cond)!=3){
            throw new \Exception('the parameters of getFuncIdByMCA of AuthFunc has error');
        }

        if(strpos($cond['c'],'controller') !== false){
            $cond['c'] = rtrim($cond['c'],'controller');
        }

        $res = DB::table($this->table_name)->where($cond)->first();
        return $res ? $res->id : false;
    }

}
