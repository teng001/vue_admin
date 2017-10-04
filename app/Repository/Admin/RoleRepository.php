<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/24
 * Time: 18:18
 */

namespace App\Repository\Admin;


use App\Models\Role;
use App\Models\RolePermission;
use App\RepositoryInterface\Admin\RoleRepositoryInterface;
use DB;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct(
        Role $role,
        RolePermission $rolePermission
    )
    {
        $this->roleModel = $role;
        $this->rolePermissionModel = $rolePermission;
    }

    public function getRolePageList($where, $perPage, $order)
    {
        $result = $this->roleModel->getPaginateList($where, $order, $perPage);
        return $result;
    }

    public function roleDetail($id)
    {
        $result = $this->roleModel->where('id', $id)->first();
        if ($result) {
            $result->checklist = $this->rolePermissionModel->where('role_id', $id)->lists('permission_id');
        }
        return $result;
    }

    public function getUserRoleList()
    {
        return $this->roleModel->select('id', 'display_name')->get();
    }
}