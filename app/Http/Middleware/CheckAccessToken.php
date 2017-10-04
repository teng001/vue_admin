<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/7/14
 * Time: 14:27
 */

namespace App\Http\Middleware;

use Closure;


use Common\Exceptions\Auth\AdminException;
use Illuminate\Http\Request;
use App\Contracts\WechatContractInterface;

class CheckAccessToken
{

    public function __construct(WechatContractInterface $wechatService)
    {
        $this->wechatService = $wechatService;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request
     * @param callable $next
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws AdminException
     */
    public function handle(Request $request, Closure $next)
    {

        if (!$this->wechatService->getAccessToken()) {
            throw new \Exception('无法获取token');
        }
        return $next($request);
    }
}