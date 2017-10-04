<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/21
 * Time: 16:46
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\RepositoryInterface\Admin\AdminUserRepositoryInterface;
use App\Traits\Controller\AjaxTraits;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AccountController extends Controller
{
    use  AjaxTraits;

    public function login(JWTAuth $JWTAuth, Request $request, AdminUserRepositoryInterface $adminUserRepository)
    {

        $userName = $request->input('username', 'admin');
        $passWord = $request->input('password', '111111');
        $userInfo = $adminUserRepository->checkAdminUser($userName, $passWord);
        if($userInfo){
            $data['token'] =  $JWTAuth->fromUser($userInfo);
            return $this->ajaxTipSuccess('登录成功', $data);
        }else{
            return $this->ajaxTipError('账号或密码错误', '');
        }

    }
}