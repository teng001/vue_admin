<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/24
 * Time: 18:18
 */

namespace App\RepositoryInterface\Admin;


interface RoleRepositoryInterface
{
    //获取角色分页列表
    public function getRolePageList($where, $perPage, $order);
    //角色详情
    public function roleDetail($id);
    //获取角色列表
    public function getUserRoleList();
}