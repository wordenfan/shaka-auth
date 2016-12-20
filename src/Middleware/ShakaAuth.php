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
use HSOHealth\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Config;

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
		$user = User::where('id',1056)->first();

		$controller_arr = $this->getControllerAction();
		$controller = $controller_arr['controller'];
		$action = $controller_arr['method'];

		//白名单
		$auth_res = $this->chkWhiteList($controller,$action);
		if($auth_res){
			return $next($request);
		}

		//接口权限校验
		$prefix = Config::get('shaka-auth.namespace_prefix');
		if(strpos($controller,$prefix)===false){
			throw new \Exception('the prefix of controller has fatal error');
		}
		$origin_url = ltrim(substr($controller,strlen($prefix)),'\\');
		$delimit_index = strrpos($origin_url,'\\');
		$cond['m'] = substr($origin_url,0,$delimit_index);
		$cond['c'] = substr($origin_url,$delimit_index+1);
		$cond['a'] = $action;
		$func_id = $user->basePermission()->getFuncIdWithPermissionId($cond);

		if(!$func_id){
			echo '您不具有去权限!';
			exit;
		}

		$auth_res = $user->canDo($func_id);
		if(!$auth_res){
			echo '您不具有去权限!';
			exit;
		}
		echo '恭喜,您有权限,中断!';
		exit;

		return $next($request);
	}

	/**
	 * 检查白名单
	 *
	 * @return bool
	 */
	private function chkWhiteList($controller,$action)
	{
		$white_list = Config::get('shaka-auth.white_list');
		$path_url = rtrim($controller,'/').'\\'.ltrim($action,'/');
		foreach($white_list as $k=>$v){
			if(strpos($path_url,$v) !== false){
				return true;
			}
		}
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

		return ['controller' => $class, 'method' => $method];
	}
}
