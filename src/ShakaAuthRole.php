<?php
/**
 * Created by PhpStorm.
 * User: benchao
 * Date: 16/11/22
 */

namespace Cty\ShakaAuth;

use Cty\ShakaAuth\Contracts\ShakaAuthRoleInterface;
use Cty\ShakaAuth\Traits\ShakaAuthRoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ShakaAuthRole extends Model implements ShakaAuthRoleInterface
{
    use ShakaAuthRoleTrait;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('shaka-auth.roles_table');
    }

//    public function packageTest($str)
//    {
//        echo $str;
//        dump(Config::get('shaka-auth.roles_table'));
//        dump(Config::get('entrust.permission_role_table'));
//
//    }
//
//    public function __call($method, $parameters)
//    {
//        return $this->$method(...$parameters);
//    }
//
//    public function testClosure($str,$arr){
//        dump($str,$arr);
//    }

}
