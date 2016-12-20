<?php

namespace Cty\ShakaAuth\Plugin;

use Exception;

trait PluginTrait
{
    /**
     * @var array
     */
    protected $plugins = [];

    /**
     * Register a plugin.
     *
     * @param PluginInterface $plugin
     *
     * @return $this
     */
    public function addPlugin(PluginInterface $plugin)
    {
        $class_url_arr = explode("\\",get_class($plugin));
        $class_name = array_pop($class_url_arr);
        $this->plugins[$class_name]['instance'] = $plugin;

        $par_fun_arr = get_class_methods(get_parent_class($plugin));
        $child_fun_arr = get_class_methods(get_class($plugin));
        $func_arr = array_diff($child_fun_arr,$par_fun_arr);

        $this->plugins[$class_name]['func'] = array_map(function($n){return strtolower($n);},$func_arr);

        return $this;
    }

    /**
     * Find a specific plugin.
     *
     * @param string $method
     *
     * @throws LogicException
     *
     * @return PluginInterface $plugin
     */
    protected function findPlugin($method)
    {
        $target = null;
        foreach($this->plugins as $plugin){
            if(in_array(strtolower($method),$plugin['func'])){
                if (!isset($plugin['instance'])) {
                    throw new Exception('Plugin not found of method: ' . $method);
                }
                $target = $plugin['instance'];
                break;
            }
        }
        if ( !$target) {
            throw new Exception('Plugin not found for method: ' . $method);
        }
        return $target;
    }

    //
    protected function invokePlugin($method, array $arguments, Array $basePermission)
    {
        $plugin = $this->findPlugin($method);
        $plugin->setBasePermission($basePermission);
        $callback = [$plugin, $method];

        return call_user_func_array($callback, $arguments);
    }

    //
    public function __call($method, array $arguments)
    {
        try {
            return $this->invokePlugin($method, $arguments, $this->belongToManyArr);
        } catch (Exception $e) {
            throw new Exception('Call to undefined method '. get_class($this). '::' . $method);
        }
    }
}
