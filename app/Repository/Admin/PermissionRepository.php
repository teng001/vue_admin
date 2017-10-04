<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/22
 * Time: 15:49
 */

namespace App\Repository\Admin;


use App\Models\Permission;
use App\RepositoryInterface\Admin\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function __construct(
        Permission $permission
    )
    {
        $this->permissionModel = $permission;
    }

    /**
     * [
     * 'path' => '/permission',
     * 'component' => 'Layout',
     * 'redirect' => '/permission/index',
     * 'name' => '权限测试',
     * 'icon' => 'quanxian',
     * 'meta' => ['role' => 'admin'],
     * 'noDropdown' => true,
     * 'children' => [
     * ['path' => 'index',
     * 'component' => 'permission/index',
     * 'name' => '权限测试页',
     * 'meta' => ['role' => 'admin']
     * ]
     * ]
     * ],
     */
    public function getMenuList()
    {
        $permissionList = $this->permissionModel->where('is_menu', 1)->get();
        $menuList = $this->_formatMenuCollect($permissionList->where('pid', 0), $permissionList);
        return $menuList;
    }


    public function getAllPermissionList()
    {
        $permissionList = $this->permissionModel->get();
        $menuList = $this->_formatPermissionList($permissionList->where('pid', 0), $permissionList);
        return $menuList;
    }

    public function permissionDetail($id)
    {
        return $id ? $this->permissionModel->where('id', $id)->first() : $this->permissionModel;
    }

    public function getTreeMenu()
    {
        $permissionList = $this->permissionModel->where('is_menu', 1)->get();
        $menuList = $this->_formatMenuTree($permissionList->where('pid', 0), $permissionList);
        return $menuList->prepend(['id' => 0, 'name' => '一级菜单']);
    }

    private function _formatMenuCollect($data, $permissionList)
    {
        $result = $data->map(function ($valParentMenu) use ($permissionList) {
            $parentMenu = [];
            $parentMenu['path'] = $valParentMenu->name;
            $parentMenu['component'] = $valParentMenu->component;
            $valParentMenu->redirect && $parentMenu['redirect'] = $valParentMenu->redirect;
            $parentMenu['name'] = $valParentMenu->display_name;
            $valParentMenu->icon && $parentMenu['icon'] = $valParentMenu->icon;
            $valParentMenu->meta && $parentMenu['meta'] = ['role' => $valParentMenu->meta];
            $parentMenu['noDropdown'] = $valParentMenu->noDropdown ? true : false;
            $childrenList = $permissionList->where('pid', $valParentMenu->id);
            if (!$childrenList->isEmpty()) {
                $parentMenu['children'] = $this->_formatMenuCollect($childrenList, $permissionList);
            }
            return $parentMenu;
        });
        return $result->values();
    }


    private function _formatPermissionList($data, $permissionList)
    {
        $result = $data->map(function ($valParentMenu) use ($permissionList) {
            $parentMenu = [];
            $parentMenu['id'] = $valParentMenu->id;
            $parentMenu['pid'] = $valParentMenu->pid;
            $parentMenu['path'] = $valParentMenu->name;
            $parentMenu['component'] = $valParentMenu->component;
            $parentMenu['redirect'] = $valParentMenu->redirect;
            $parentMenu['name'] = $valParentMenu->display_name;
            $parentMenu['icon'] = $valParentMenu->icon;

            $parentMenu['noDropdown'] = $valParentMenu->noDropdown ? true : false;
            $childrenList = $permissionList->where('pid', $valParentMenu->id);
            if (!$childrenList->isEmpty()) {
                $parentMenu['children'] = $this->_formatPermissionList($childrenList, $permissionList);
            }
            return $parentMenu;
        });
        return $result->values();
    }

    //一个神奇的递归。。。应该还可以优化
    private function _formatMenuTree($data, $permissionList, $node = '')
    {
        $result = $data->map(function ($valParentMenu) use ($permissionList, $node) {
            $parentMenu = [];
            $node .= $valParentMenu->pid > 0 ? '--' : '';//子组件的连接符
            $parentMenu[] = ['id' => $valParentMenu->id, 'name' => $node . $valParentMenu->display_name];
            $childrenList = $permissionList->where('pid', $valParentMenu->id);
            if (!$childrenList->isEmpty()) {
                $childrenData = $this->_formatMenuTree($childrenList, $permissionList, $node);
                $childrenData->filter(function ($item) use (&$parentMenu) {
                    array_push($parentMenu, $item);//合并每一个数组
                });
            }
            return $parentMenu;
        });
        //collapse 合并集合中的每一个数组项
        return $result->collapse()->values();
    }
}