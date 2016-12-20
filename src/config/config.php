<?php
/**
 * Created by PhpStorm.
 * User: benchao
 * Date: 16/11/22
 */
return [
    //基础表名
    'roles_table' => 'roles',
    'permissions_table' => 'permissions',
    'role_user_table' => 'role_user',
    'permission_role_table' => 'permission_role',

    //插件
    'plugin' =>[
        'func'=>[
            'table' => 'permission_func',
            'type'  => 1,
        ],
        'menu'=>[
            'table' => 'permission_menu',
            'type'  => 2,
        ],
    ],

    //Eloquent实例
    'role' => 'HSOHealth\Models\Role',
    'user' => 'HSOHealth\Models\User',
    'permission' => 'HSOHealth\Models\Permission',

    //目录树层级
    'menu_level'=>5,
    //空间前缀
    'namespace_prefix'=>'HSOHealth\Http\Controllers',

    //白名单
    'white_list'=>[
//        'API\V1\Admin\PatientMgmtController',
//        'API\V1\Admin\PatientMgmtController\getList',
    ]
];