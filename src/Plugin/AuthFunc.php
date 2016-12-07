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

    const AUTH_TYPE = 2;
    const TABLE_NAME = 'permission_func';


    public function __construct()
    {

    }

    /*
     * @param $attr 获取的字段
     */
    public function menu(Array $select=[]){
        $select = array_merge($select,['id','name','ref_id']);

        $return_arr = [];
        foreach($this->base_permission as $perm){
            $item = $perm->where('type',self::AUTH_TYPE)->select($select)->get()->toArray();
            $res = $this->getMenuDetail($item);
            $return_arr = $return_arr + $res;

        }

        $return_arr = $this->rankMenuList($return_arr,Config::get('shaka-auth.menu_level'));
        return $return_arr;
    }

    private function getMenuDetail($basePermissionItem){
        $return_arr = [];
        foreach($basePermissionItem as $perm){
            $res = DB::table(self::TABLE_NAME)->where('id',$perm['ref_id'])->first();
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
    private function rankMenuList($originArr,$level=3,$child_arr=[])
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
