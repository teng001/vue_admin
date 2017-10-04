<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/25
 * Time: 19:35
 */

namespace App\Repository\Admin;


use App\Models\RoleUser;
use App\Models\User;
use App\RepositoryInterface\Admin\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        User $user,
        RoleUser $roleUser
    )
    {
        $this->userModel = $user;
        $this->roleUserModel = $roleUser;
    }

    public function getUserPageList($where, $perPage, $order)
    {
        $result = $this->userModel->getPaginateList($where, $order, $perPage);
        return $result;
    }

    public function userDetail($id)
    {
        $result = $this->userModel->findOne(['id' => $id]);
        if ($result) {
            $result->user_roles = $this->roleUserModel->where('user_id', $id)->lists('role_id');
        }
        return $result;
    }

    public function saveUser($postData)
    {
        $saveData = $this->userModel->filterRequestData($postData);
        $userData = $this->userModel->saveInfo($saveData);
        if (is_array($postData['user_roles']) && !empty($postData['user_roles'])) {
            $userData->roles()->sync($postData['user_roles']);
        }
        return $userData;
    }
}