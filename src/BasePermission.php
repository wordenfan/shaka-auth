<?php
/**
 * Created by PhpStorm.
 * User: benchao
 * Date: 16/12/6
 */

namespace Cty\ShakaAuth;


use Cty\ShakaAuth\Plugin\AuthMenu;
use Cty\ShakaAuth\Plugin\PluginTrait;
use Illuminate\Support\Collection;

class BasePermission
{
    use PluginTrait;

    public $belongToManyArr = [];//BelongsToMany实例数组

    public function __construct(Array $roleList)
    {
        foreach($roleList as $role)
        {
            $this->belongToManyArr[] = $role->perms();
        }

        $this->init();
    }

    public function init()
    {
        $this->addPlugin(new AuthMenu());
    }
}