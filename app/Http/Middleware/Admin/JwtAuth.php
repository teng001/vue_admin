<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/7/9
 * Time: 18:24
 */

namespace App\Http\Middleware\Admin;

use App\Traits\Controller\AjaxTraits;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;

class JwtAuth extends BaseMiddleware
{
    use AjaxTraits;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $route = $request->route()->getName();
        if (!$token = $this->auth->setRequest($request)->getToken()) {
            return $this->ajaxAdminLoginOutSuccess('token不能为空', 'token_not_provided');
            //return $this->respond('tymon.jwt.absent', 'token_not_provided', 400);
        }

        try {
            $user = $this->auth->authenticate($token);
        } catch (TokenExpiredException $e) {
            return $this->ajaxAdminLoginOutSuccess('token过期', 'token_expired');
            //return $this->respond('tymon.jwt.expired', 'token_expired', $e->getStatusCode(), [$e]);
        } catch (JWTException $e) {
            return $this->ajaxAdminLoginOutSuccess('token错误', 'token_invalid');
            //return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }
        if (!$user) {
            return $this->ajaxAdminLoginOutSuccess('用户token不存在', 'user_not_found');
            //return $this->respond('tymon.jwt.user_not_found', 'user_not_found', 404);
        }
        if (!$user->can($route)) {  //判断登录用户权限
            return $this->ajaxResponse('error', '权限不足啊', '');
        }
        $token = $this->auth->setRequest($request)->getToken();
        $user = $this->auth->toUser($token);

        $this->events->fire('tymon.jwt.valid', $user);
        if($user->is_admin>0){
            return $next($request);
        }else{
            return $this->ajaxAdminLoginOutSuccess('用户类型错误', 'user_type_error');
        }
    }
}