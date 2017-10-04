<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2016/6/12
 * Time: 11:15
 */

namespace App\Support;


use Illuminate\Support\Facades\Facade;

class CurlFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'App\Services\Common\CurlService'; }
}
