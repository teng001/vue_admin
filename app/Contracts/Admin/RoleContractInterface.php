<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/25
 * Time: 10:55
 */

namespace App\Contracts\Admin;


interface RoleContractInterface
{
    //保存角色
    public function saveRole($postData);
    //保存角色权限信息
    public function saveRolePermissionList($roleId, $permissionList);
}