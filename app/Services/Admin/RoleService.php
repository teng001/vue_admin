<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/25
 * Time: 10:55
 */

namespace App\Services\Admin;


use App\Contracts\Admin\RoleContractInterface;
use App\Models\Role;

class RoleService implements RoleContractInterface
{
    public function __construct(Role $role)
    {
        $this->roleModel = $role;
    }

    public function saveRole($postData)
    {
        $saveData = $this->roleModel->filterRequestData($postData);
        return $this->roleModel->saveInfo($saveData);
    }

    public function saveRolePermissionList($roleId, $permissionList)
    {
        $roleInfo = $this->roleModel->where('id', $roleId)->first();
        return $roleInfo->perms()->sync($permissionList);
    }
}