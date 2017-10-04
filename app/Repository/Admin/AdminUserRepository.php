<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/21
 * Time: 17:38
 */

namespace App\Repository\Admin;


use App\Models\User;
use App\RepositoryInterface\Admin\AdminUserRepositoryInterface;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    public function __construct(User $adminUser)
    {
        $this->adminUserModel = $adminUser;
    }

    public function checkAdminUser($userName, $passWord)
    {
        return $this->adminUserModel->select('id', 'username')->where('username', $userName)->where('password', $this->adminUserModel->_passSecret($passWord))->first();
    }
}