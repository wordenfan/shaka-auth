<?php

namespace Cty\ShakaAuth\Traits;

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */


trait ShakaAuthPermissionTrait
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

}
