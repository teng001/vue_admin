<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/21
 * Time: 18:07
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\RepositoryInterface\Admin\UserRepositoryInterface;
use App\Traits\Controller\AjaxTraits;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;


class UserController extends Controller
{
    use AjaxTraits;

    public function userInfo(JWTAuth $JWTAuth, Request $request)
    {
        $token = $JWTAuth->setRequest($request)->getToken();
        $user = $JWTAuth->toUser($token);
        $data['role'] = ['editor'];
        $data['token'] = 'admin';
        $data['introduction'] = '我是超级管理员';
        $data['avatar'] = 'https://wpimg.wallstcn.com/f778738c-e4f8-4870-b634-56703b4acafe.gif';
        $data['name'] = 'Super Admin';
        $data['info'] = $user;
        return $this->ajaxSuccess('success', $data);
    }

    public function userList(Request $request, UserRepositoryInterface $userRepository)
    {
        $where = [];
        $perPage = $request->input('perPage', 10);
        $keyWord = $request->input('keyWord', '');
        if ($keyWord) {
            $where['username'] = ['like', '%' . $keyWord . '%'];
        }
        $order = ['id' => 'desc'];
        $pageList = $userRepository->getUserPageList($where, $perPage, $order)->toArray();
        return $this->ajaxSuccess('success', $pageList);
    }

    public function userDetail($id, UserRepositoryInterface $userRepository)
    {
        $result = $userRepository->userDetail($id);
        return $this->ajaxSuccess('success', $result);
    }

    public function saveUser(Request $request, UserRepositoryInterface $userRepository)
    {
        try {
            $postData = $request->input();
            $result = $userRepository->saveUser($postData);
            return $this->ajaxSuccess('success', $result);
        } catch (\Exception $e) {
            return $this->ajaxTipError($e->getMessage(), '');
        }
    }
}