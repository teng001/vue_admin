<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/24
 * Time: 14:25
 */

namespace App\Contracts\Admin;


interface PermissionContractInterface
{
    //保存权限
    public function savePermission($postData);
    //删除权限
    public function delPermission($id);
}