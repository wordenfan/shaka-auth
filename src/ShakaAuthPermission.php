<?php
/**
 * Created by PhpStorm.
 * User: benchao
 * Date: 16/11/22
 */

namespace Cty\ShakaAuth;

use Cty\ShakaAuth\Plugin\AbstractPlugin;
use Cty\ShakaAuth\Traits\ShakaAuthRoleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class ShakaAuthPermission extends Model
{
    use ShakaAuthRoleTrait;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('shaka-auth.permissions_table');
    }
}
