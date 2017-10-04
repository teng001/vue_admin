<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/24
 * Time: 14:26
 */

namespace App\Services\Admin;


use App\Contracts\Admin\PermissionContractInterface;
use App\Models\Permission;

class PermissionService implements PermissionContractInterface
{
    public function __construct(Permission $permissions)
    {
        $this->permissionModel = $permissions;
    }

    public function savePermission($postData)
    {
        $saveData = $this->permissionModel->filterRequestData($postData);
        return $this->permissionModel->saveInfo($saveData);
    }

    public function delPermission($id)
    {
        return $this->permissionModel->where('id', $id)->delete();
    }
}