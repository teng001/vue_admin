<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/22
 * Time: 15:50
 */

namespace App\RepositoryInterface\Admin;


interface PermissionRepositoryInterface
{
    //获取菜单栏列表
    public function getMenuList();
    //获取所有权限列表
    public function getAllPermissionList();
    //获取权限详情
    public function permissionDetail($id);
    //权限详情 树形下拉框列表
    public function getTreeMenu();
}