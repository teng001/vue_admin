<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/24
 * Time: 18:17
 */

namespace App\Http\Controllers\Admin;


use App\Contracts\Admin\RoleContractInterface;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\Admin\RoleRepositoryInterface;
use App\Traits\Controller\AjaxTraits;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use AjaxTraits;

    public function roleList(Request $request, RoleRepositoryInterface $roleRepository)
    {
        $where = [];
        $perPage = $request->input('perPage', 10);
        $keyWord = $request->input('keyWord', '');
        if ($keyWord) {
            $where['display_name'] = ['like', '%' . $keyWord . '%'];
        }
        $order = ['id' => 'desc'];
        $pageList = $roleRepository->getRolePageList($where, $perPage, $order)->toArray();
        return $this->ajaxSuccess('success', $pageList);
    }

    public function roleDetail($id, RoleRepositoryInterface $roleRepository)
    {
        $result = $roleRepository->roleDetail($id);
        return $this->ajaxSuccess('success', $result);
    }

    public function saveRole(Request $request, RoleContractInterface $roleService)
    {
        try {
            $postData = $request->input();
            $result = $roleService->saveRole($postData);
            return $this->ajaxSuccess('success', $result);
        } catch (\Exception $e) {
            return $this->ajaxTipError($e->getMessage(), $e->getMessage());
        }
    }

    public function saveRolePermission(Request $request, RoleContractInterface $roleService)
    {
        try {
            $roleId = $request->input('id');
            $permissionList = $request->input('permissionArr');
            $roleService->saveRolePermissionList($roleId, $permissionList);
            return $this->ajaxTipSuccess('添加成功', '');
        } catch (\Exception $e) {
            return $this->ajaxTipError($e->getMessage(), '');
        }
    }

    public function getUserRoleList(RoleRepositoryInterface $roleRepository)
    {
        $roleList = $roleRepository->getUserRoleList();
        return $this->ajaxSuccess('success', $roleList);
    }
}