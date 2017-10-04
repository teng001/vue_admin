<?php

/**
 * 管理后台路由配置
 */


/**
 * 监听二级域名：admin.xxx.com
 * 管理后台的Controller位于Controllers/Admin下
 */
Route::group(['namespace' => 'Admin'], function () {
    Route::get('/', [
        'as' => '/index/index',
        'uses' => 'IndexController@index',
    ]);

    Route::post('/admin/login', [
        'as' => '/admin/login',
        'uses' => 'AccountController@login',
    ]);

    Route::get('/admin/userInfo', [
        'as' => '/admin/userInfo',
        'uses' => 'UserController@userInfo',
    ]);

    Route::get('/admin/menuList', [
        'as' => '/admin/menuList',
        'uses' => 'MenuController@menuList',
    ]);

    Route::get('/admin/permissionList', [
        'as' => '/admin/permissionList',
        'uses' => 'PermissionController@permissionList',
    ]);

    Route::get('/admin/permissionDetail/{id}', [
        'as' => '/admin/permissionDetail',
        'uses' => 'PermissionController@permissionDetail',
    ]);

    Route::post('/admin/savePermission', [
        'as' => '/admin/savePermission',
        'uses' => 'PermissionController@savePermission'
    ]);

    Route::post('/admin/savePermission', [
        'as' => '/admin/savePermission',
        'uses' => 'PermissionController@savePermission'
    ]);

    Route::get('/admin/getTreeMenu', [
        'as' => '/admin/getTreeMenu',
        'uses' => 'PermissionController@getTreeMenu'
    ]);

    Route::post('/admin/delPermission/{id}', [
        'as' => '/admin/delPermission',
        'uses' => 'PermissionController@delPermission'
    ]);

    Route::get('/admin/roleList', [
        'as' => '/admin/roleList',
        'uses' => 'RoleController@roleList'
    ]);

    Route::get('/admin/roleDetail/{id}', [
        'as' => '/admin/roleDetail',
        'uses' => 'RoleController@roleDetail'
    ]);

    Route::post('/admin/saveRole', [
        'as' => '/admin/saveRole',
        'uses' => 'RoleController@saveRole'
    ]);

    Route::get('/admin/getUserRoleList', [
        'as' => '/admin/getUserRoleList',
        'uses' => 'RoleController@getUserRoleList'
    ]);

    Route::post('/admin/saveRolePermission', [
        'as' => '/admin/saveRolePermission',
        'uses' => 'RoleController@saveRolePermission'
    ]);

    Route::get('/admin/userList', [
        'as' => '/admin/userList',
        'uses' => 'UserController@userList'
    ]);

    Route::get('/admin/userDetail/{id}', [
        'as' => '/admin/userDetail',
        'uses' => 'UserController@userDetail'
    ]);

    Route::post('/admin/saveUser', [
        'as' => '/admin/saveUser',
        'uses' => 'UserController@saveUser'
    ]);
});





