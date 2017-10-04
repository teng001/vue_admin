<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/22
 * Time: 17:11
 */

namespace App\Http\Controllers\Admin;


use App\Contracts\Admin\PermissionContractInterface;
use App\Http\Controllers\Controller;
use App\RepositoryInterface\Admin\PermissionRepositoryInterface;
use App\Traits\Controller\AjaxTraits;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    use AjaxTraits;

    public function permissionList(PermissionRepositoryInterface $permissionRepository)
    {
        $data = $permissionRepository->getAllPermissionList();
        return $this->ajaxSuccess('success', $data);
    }

    public function permissionDetail($id, PermissionRepositoryInterface $permissionRepository)
    {
        $data = $permissionRepository->permissionDetail($id);
        return $this->ajaxSuccess('success', $data);
    }

    public function savePermission(Request $request, PermissionContractInterface $permissionService)
    {
        try {
            $postData = $request->input();
            $result = $permissionService->savePermission($postData);
            return $this->ajaxSuccess('success', $result);
        } catch (\Exception $e) {
            return $this->ajaxTipError($e->getMessage(), $e->getMessage());
        }
    }

    public function getTreeMenu(PermissionRepositoryInterface $permissionRepository)
    {
        $data = $permissionRepository->getTreeMenu();
        return $this->ajaxSuccess('success', $data);
    }

    public function delPermission($id, PermissionContractInterface $permissionService)
    {
        try {
            $result = $permissionService->delPermission($id);
            return $this->ajaxSuccess('success', $result);
        } catch (\Exception $e) {
            return $this->ajaxTipError($e->getMessage(), $e->getMessage());
        }
    }
}