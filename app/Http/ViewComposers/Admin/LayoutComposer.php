<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/3/20
 * Time: 14:48
 */

namespace App\Http\ViewComposers\Admin;
use App\Contracts\Admin\UserAdminContractInterface;
use Illuminate\Contracts\View\View;
use Auth;
use Illuminate\Http\Request;

class LayoutComposer
{
    /**
     * U
     *
     * @var 用户菜单
     */
    protected $userMenu;


    public function __construct(UserAdminContractInterface $adminContract,Request $request)
    {
        $this->adminService = $adminContract;
        $this->request = $request;
    }

    /**
     * 绑定数据给view
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $user = Auth::user();


        //获得当前菜单ID
        $currentMenuId = $this->request->route()->getName();
        //从UAMS获得菜单信息
       // $menus       = $this->userMenu->getMenus();
        $this->menus = $this->adminService->userMenu($user,$currentMenuId);

        $companyId = $user->getUserCompanyId();

        $companyName = $this->adminService->companyName($companyId)??'裘马草堂';

        $view->with('companyName', $companyName);
        $view->with('currentMenuId', (is_null($currentMenuId) ? 0 : $currentMenuId));
        //绑定数据 ------------------------------------------------------

        //当前菜单ID，如果获取到的为空则设置为0
        $view->with('currentMenuId', (is_null($currentMenuId) ? 0 : $currentMenuId));

        //附加管理员信息
        $view->with('user', $user);

        //附加菜单信息
        $view->with('menu', $this->menus);
    }
}