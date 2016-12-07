<?php

namespace Cty\ShakaAuth\Traits;

use Cty\ShakaAuth\BasePermission;
use Cty\ShakaAuth\Plugin\PluginInterface;
use HSOHealth\Models\Role;
use Illuminate\Support\Facades\Config;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */


trait ShakaAuthUserTrait
{

    /**
     * 校验是否有某个角色或全部角色
     * @param array|int
     * @param bool
     * return bool
     */
    public function hasRole($attr, $requireAll = false)
    {
        $check_arr = is_array($attr) ? $attr : [$attr];
        $role_list = $this->roleList();

        foreach ($check_arr as $k=>$roleItem) {
            if(is_int($roleItem)) {
                $res = array_key_exists($roleItem, $role_list);
            }else{
                $res = in_array($roleItem,$role_list);
            }
            $result_arr[] = $res;

            if($requireAll && !$res){
                return false;
            }elseif(!$requireAll && $res){
                return true;
            }
        }
        return $requireAll ? true : false;
    }

    /** 校验是否具备某个权限
     * @param int|string|array 支持id或name的单个 或数组形式
     * return bool
     */
    public function canDo($permission_name)
    {
        $role_list = $this->roles()->get();
        foreach($role_list as $role){
            $chk_res = $role->hasPermission($permission_name);
            if($chk_res){
                return true;
            }
        }
        return false;
    }

    /**
     * 增加角色
     * @param mixed
     * return null
     */
    public function attachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }elseif (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->attach($role);
    }

    /**
     * 删除角色
     * @param mixed
     * return null
     */
    public function detachRole($role)
    {
        if (is_object($role)) {
            $role = $role->getKey();
        }elseif (is_array($role)) {
            $role = $role['id'];
        }

        $this->roles()->detach($role);
    }

    /**
     * 角色列表
     * @param array
     * return array
     * TODO 目前暂只支持id,name
     */
    public function roleList(array $select=[])
    {
        $select = array_merge($select,['id','name']);

        $role_list = $this->roles()->select($select)->get()->toArray();

        $return_arr = [];
        foreach($role_list as $role){
            $return_arr[$role['id']] = $role['name'];
        }

        return $return_arr;
    }

    /**
     * 权限插件的连贯操作
     * return BasePermission实例
     */
    public function basePermission()
    {
        $role_arr = $this->roles()->select(['*'])->get()->all();
        return new BasePermission($role_arr);
    }

    public function roles()
    {
        return $this->belongsToMany(Config::get('shaka-auth.role'), Config::get('shaka-auth.role_user_table'));
    }

}
