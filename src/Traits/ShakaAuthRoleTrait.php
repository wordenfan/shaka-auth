<?php

namespace Cty\ShakaAuth\Traits;

use HSOHealth\Models\PermissionMenu;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */


trait ShakaAuthRoleTrait
{
    //添加和更新 return bool
    public function save(array $options = [])
    {
        $result = parent::save($options);
        return $result;
    }

    //删除 return int
    public function delete(array $options = []){
        $result = parent::delete($options);
        return $result;
    }

    //查询该角色的所有用户 return array
    //TODO 目前暂只支持id,username
    public function userList(array $select=[]){
        $select = array_merge($select,['id','username']);

        $user_list = $this->users()->select($select)->get()->toArray();

        $return_arr = [];
        foreach($user_list as $user){
            $return_arr[$user['id']] = $user['username'];
        }

        return $return_arr;
    }

    /** 权限判定
     * @param int|array 支持id或name的单个 或数组形式
     * return bool
     */
    public function hasPermission($attr)
    {
        $check_arr = is_array($attr) ? $attr : [$attr];
        $permission_list = $this->permissionList();

        foreach ($check_arr as $permItem) {
            if(is_int($permItem)) {
                $res = array_key_exists($permItem, $permission_list);
            }else{
                $res = in_array($permItem,$permission_list);
            }

            if(!$res){
                return false;
            }
        }

        return true;
    }

    //权限添加,支持int型id 或obj,或arr
    public function attachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }elseif (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->perms()->attach($permission);
    }

    //权限删除
    public function detachPermission($permission)
    {
        if (is_object($permission)) {
            $permission = $permission->getKey();
        }elseif (is_array($permission)) {
            $permission = $permission['id'];
        }

        $this->perms()->detach($permission);
    }

    //权限列表 return array
    //TODO 目前暂只支持id,name
    public function permissionList(array $select=[])
    {
        $select = array_merge($select,['id','name']);

        $permission_list = $this->perms()->select($select)->get()->toArray();

        $return_arr = [];
        foreach($permission_list as $perm){
            $return_arr[$perm['id']] = $perm['name'];
        }

        return $return_arr;
    }

    public function permissionMenuList()
    {
        $permission_list = $this->perms()->where('type',2)->get()->toArray();

        $return_arr = [];
        foreach($permission_list as $perm){
            $res = DB::table(Config::get('shaka-auth.permission_menu_table'))->where('id',$perm['ref_id'])->first();
            $return_arr[$res->id] = $res;
        }

        return $return_arr;
    }

    public function perms()
    {
        return $this->belongsToMany(Config::get('shaka-auth.permission'), Config::get('shaka-auth.permission_role_table'));
    }

    public function users()
    {
//        return $this->belongsToMany(Config::get('auth.model'), Config::get('shaka-auth.role_user_table'));
        return $this->belongsToMany(Config::get('shaka-auth.user'), Config::get('shaka-auth.role_user_table'));
    }
}
