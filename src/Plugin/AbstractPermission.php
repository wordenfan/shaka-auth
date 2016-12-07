<?php

namespace Cty\ShakaAuth\Plugin;


use Illuminate\Database\Eloquent\Model;

abstract class AbstractPermission extends Model implements PluginInterface
{
    protected $base_permission;

    public function setBasePermission(Array $basePermission){
        $this->base_permission = $basePermission;
    }
}
