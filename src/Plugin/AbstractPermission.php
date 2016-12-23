<?php

namespace Cty\ShakaAuth\Plugin;

use DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

abstract class AbstractPermission extends Model implements PluginInterface
{
    protected $base_permission;
    protected $base_permission_table;
    protected $auth_type;
    protected $table_name;
    protected $menu_level;

    public function __construct()
    {
        $this->menu_level = Config::get('shaka-auth.menu_level');
        $this->base_permission_table = Config::get('shaka-auth.permissions_table');
    }

    public function setBasePermission(Array $basePermission){
        $this->base_permission = $basePermission;
    }

    //
    protected function getMenuDetail($basePermissionItem){
        $return_arr = [];
        foreach($basePermissionItem as $perm){
            $res = DB::table($this->table_name)->where('id',$perm['ref_id'])->first();
            $return_arr[$res->id] = $res;
        }
        return $return_arr;
    }

    /* 菜单进行目录树整理
     * @param array 待整理的以为原始目录集
     * @param int 层级 默认三级
     * $param array 不需传递,递归时调用
     * return array
     */
    protected function rankMenuList($originArr,$level=3,$child_arr=[])
    {
        if($level < 1){
            return $originArr;
        }

        $loop_child_arr = [];
        $final_arr = [];
        foreach($originArr as $i=>$item){
            $item = (array)$item;
            if($item['level'] == $level){
                if(!empty($child_arr)){
                    foreach($child_arr as $j=>$cItem){
                        if($item['id'] == $cItem['pid']){
                            $item['list'][] = $cItem;
                        }
                    }
                }
                $loop_child_arr[] = $item;
            }
            if($item['level']<=$level){
                $final_arr[] = $item;
            }
        }

        rsort($loop_child_arr);
        $level--;
        return $this->rankMenuList($final_arr,$level,$loop_child_arr);
    }

}
