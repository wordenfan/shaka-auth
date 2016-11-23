<?php
namespace Cty\ShakaAuth;

use Illuminate\Support\Facades\Facade;

class ShakaAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ShakaAuth';
    }
}
