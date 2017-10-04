<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/21
 * Time: 17:38
 */

namespace App\RepositoryInterface\Admin;


interface AdminUserRepositoryInterface
{
    public function checkAdminUser($userName,$passWord);
}