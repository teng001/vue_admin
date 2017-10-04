<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/26
 * Time: 10:09
 */

namespace App\Contracts\Admin;


interface UserContractInterface
{
    //保存用户信息
    public function saveUser($postData);
    //删除用户
    public function delUser($id);
}