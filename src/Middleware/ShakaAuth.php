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

class ShakaAuth
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
	public function handle($request, Closure $next)
	{
		$user = \HSOHealth\Models\User::find(1056);

		$controller_arr = $this->getControllerAction();
		$controller = $controller_arr['controller'];
		$action = $controller_arr['action'];

//		dump($request->fullUrl());
//        dump($request->route()->getActionName());
//        dump($request->route()->getAction());
//        dump($request->route()->getController());

		return $next($request);
	}

	/**
	 * 获取当前控制器与方法
	 *
	 * @return array
	 */
	private function getControllerAction()
	{
		$action = \Route::current()->getActionName();
		list($class, $method) = explode('@', $action);
		$class_arr = explode("\\", $class);

		return ['controller' => array_pop($class_arr), 'action' => $method];
	}
}
