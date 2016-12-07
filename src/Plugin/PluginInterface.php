<?php

namespace Cty\ShakaAuth\Plugin;

use Illuminate\Support\Collection;

interface PluginInterface
{
    /**
     * Get the method name.
     *
     * @return string
     */
//    public function getAuthType();

    /**
     * Get the method name.
     *
     * @return string
     */
//    public function getTableName();

    /**
     * Get the method name.
     *
     * @return string
     */
    public function setBasePermission(Array $basePermission);
}
