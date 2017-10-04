<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/9/22
 * Time: 9:58
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\RepositoryInterface\Admin\PermissionRepositoryInterface;
use App\Traits\Controller\AjaxTraits;

class MenuController extends Controller
{
    use AjaxTraits;

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse|\Symfony\Component\HttpFoundation\Response
     * 权限列表
     * 权限列表格式
     * [[
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
     * ]]
     */
    public function menuList(PermissionRepositoryInterface $permissionRepository)
    {
//        $data = [
//            [
//                'path' => '/permission',
//                'component' => 'Layout',
//                'redirect' => '/permission/index',
//                'name' => '权限测试',
//                'icon' => 'quanxian',
//                'meta' => ['role' => 'admin'],
//                'noDropdown' => true,
//                'children' => [
//                    ['path' => 'index',
//                        'component' => 'permission/index',
//                        'name' => '权限测试页',
//                        'meta' => ['role' => 'admin']
//                    ]
//                ]
//            ],
//            [
//                'path' => '/icon',
//                'component' => 'Layout',
//                'icon' => 'icons',
//                'noDropdown' => true,
//                'children' => [
//                    [
//                        'path' => 'index',
//                        'component' => 'svg-icons/index',
//                        'name' => 'icons'
//                    ]
//                ]
//            ],
//            [
//                'path' => '/components',
//                'component' => 'Layout',
//                'redirect' => '/components/index',
//                'name' => '组件',
//                'icon' => 'zujian',
//                'children' => [
//                    [
//                        'path' => 'index',
//                        'component' => 'components/index',
//                        'name' => '介绍'
//                    ],
//                    [
//                        'path'=>'tinymce',
//                        'component' => 'components/tinymce',
//                        'name' => '富文本编辑器'
//                    ]
//                ]
//            ]
//
//        ];
        /**
         * {
        path: '/icon',
        component: Layout,
        icon: 'icons',
        noDropdown: true,
        children: [{ path: 'index', component: _import('svg-icons/index'), name: 'icons' }]
        },
        {
        path: '/components',
        component: Layout,
        redirect: '/components/index',
        name: '组件',
        icon: 'zujian',
        children: [
        { path: 'index', component: _import('components/index'), name: '介绍 ' },
        { path: 'tinymce', component: _import('components/tinymce'), name: '富文本编辑器' },
        { path: 'markdown', component: _import('components/markdown'), name: 'Markdown' },
        { path: 'jsoneditor', component: _import('components/jsonEditor'), name: 'JSON编辑器' },
        { path: 'dndlist', component: _import('components/dndList'), name: '列表拖拽' },
        { path: 'splitpane', component: _import('components/splitpane'), name: 'SplitPane' },
        { path: 'avatarupload', component: _import('components/avatarUpload'), name: '头像上传' },
        { path: 'dropzone', component: _import('components/dropzone'), name: 'Dropzone' },
        { path: 'sticky', component: _import('components/sticky'), name: 'Sticky' },
        { path: 'countto', component: _import('components/countTo'), name: 'CountTo' },
        { path: 'mixin', component: _import('components/mixin'), name: '小组件' },
        { path: 'backtotop', component: _import('components/backToTop'), name: '返回顶部' }
        ]
        },
         */
        $data = $permissionRepository->getMenuList();
        return $this->ajaxSuccess('success', $data);
    }
}