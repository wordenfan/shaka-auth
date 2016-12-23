## 概述

This is a shaka-auth for test
inspire by [Zizaco/entrust](https://github.com/Zizaco/entrust)

## 安装方法

```bash
composer require "worden/shaka-auth-for-laravel:1.0.x-dev"
```
## 使用说明

kernel.php的$routeMiddleware增加中间件
```bash
'shakaAuth' => \Cty\ShakaAuth\Middleware\ShakaAuth::class,
```

user的调用方法
```bash
$user = User::where('id',1056)->first();
$res = $user->roleList();
$res = $user->hasRole([25,26]);
$res = $user->attachRole(27);
$res = $user->detachRole(27);
$res = $user->canDo([12,'manage_posts3']);
$res = $user->basePermission()->menu();
$res = $user->basePermission()->func();
```
role的调用方法
```bash
$role = Role::where('id',25)->first();
$res2 = $role->attachPermission(17);
$res2 = $role->detachPermission([18]);
$res2 = $role->userList();
$res2 = $role->hasPermission(['manage_posts2','manage_posts3']);
$res2 = $role->permissionList();
$res2 = $role->basePermission()->menu();
```
