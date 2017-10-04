<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/25
 * Time: 19:35
 */

namespace App\RepositoryInterface\Admin;


interface UserRepositoryInterface
{
    //获取用户列表
    public function getUserPageList($where, $perPage, $order);
    //获取用户详情
    public function userDetail($id);
    //保存用户信息
    public function saveUser($postData);
}