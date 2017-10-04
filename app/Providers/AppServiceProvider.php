<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Common\Packages\Linker\Linker;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Linker $linker)
    {
        //配置Linker
        $this->setupLinker($linker);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * 配置Linker
     *
     * @param Linker $linker
     */
    protected function setupLinker(Linker $linker)
    {
        $resourceUrlPrefix = env('RESOURCE_URL_PREFIX');
        if ($resourceUrlPrefix == '') throw new \RuntimeException('请配置RESOURCE_URL_PREFIX');

        $linker->set('resource', $resourceUrlPrefix);
    }
}
