<?php
namespace Cty\ShakaAuth\Middleware;

/**
 * This file is part of ShakaAuth,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 *
 * Route::get('patient_mgmt/patient_detail', ['middleware' => ['role:visitor2'], 'uses' => 'Admin\PatientMgmtController@getDetail']);
 */

use Closure;
use Illuminate\Contracts\Auth\Guard;

class ShakaAuthRole
{
	protected $auth;

	/**
	 * Creates a new instance of the middleware.
	 *
	 * @param Guard $auth
	 */
	public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  Closure $next
	 * @param  $roles
	 * @return mixed
	 */
	public function handle($request, Closure $next, $roles)
	{
		$user = \HSOHealth\Models\User::find(1056);

		if(strpos($roles,'&')){
			$requireAll = true;
			$role_arr = explode('&', $roles);
		}else{
			$requireAll = false;
			$role_arr = explode('|', $roles);
		}
		$chk_res = $user->hasRole($role_arr,$requireAll);

		if (!$chk_res) {
			echo '您没有访问权限';
			exit;
		}
		echo '有权限';

		return $next($request);
	}
}
