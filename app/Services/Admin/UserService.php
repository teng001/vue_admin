<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/26
 * Time: 10:09
 */

namespace App\Services\Admin;


use App\Contracts\Admin\UserContractInterface;
use App\Models\User;

class UserService implements UserContractInterface
{
    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function saveUser($postData)
    {
        if (isset($postData['password'])) {
            $postData['password'] = $this->userModel->_passSecret($postData['password']);
        }
        $saveData = $this->userModel->filterRequestData($postData);
        $userData = $this->userModel->saveInfo($saveData);
        if (is_array($postData['user_roles']) && !empty($postData['user_roles'])) {
            $userData->roles()->sync($postData['user_roles']);
        }
        return $userData;
    }

    public function delUser($id)
    {
        return $this->userModel->where('id', $id)->delete();
    }
}