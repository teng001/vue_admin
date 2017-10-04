<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/3/20
 * Time: 11:47
 */

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use App\Services\Admin\UploadService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\RepositoryInterface\Admin\AdminUserRepositoryInterface','App\Repository\Admin\AdminUserRepository');
        $this->app->bind('App\RepositoryInterface\Admin\PermissionRepositoryInterface','App\Repository\Admin\PermissionRepository');
        $this->app->bind('App\RepositoryInterface\Admin\RoleRepositoryInterface','App\Repository\Admin\RoleRepository');
        $this->app->bind('App\RepositoryInterface\Admin\UserRepositoryInterface','App\Repository\Admin\UserRepository');

        $this->app->bind('App\Contracts\Admin\PermissionContractInterface','App\Services\Admin\PermissionService');
        $this->app->bind('App\Contracts\Admin\RoleContractInterface','App\Services\Admin\RoleService');
        $this->app->bind('App\Contracts\Admin\UserContractInterface','App\Services\Admin\UserService');
        $this->registerUploadService();
    }

    /**
     * 注册后台上传服务
     */
    protected function registerUploadService()
    {

        //注册后台文件上传服务
        $this->app->singleton(UploadService::class, function ($app) {
            return new UploadService(
                $app->request,
                env('RESOURCE_RELATIVE_PATH'),
                env('SAVED_UPLOAD_RELATIVE_PATH'),
                env('TEMP_UPLOAD_RELATIVE_PATH')
            );
        });
    }




}