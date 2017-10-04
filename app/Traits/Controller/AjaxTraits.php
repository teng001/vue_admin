<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/3/2
 * Time: 10:29
 */

namespace App\Traits\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

trait AjaxTraits
{
    /**
     * AJAX返回
     *
     * @param      $status
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxResponse($status, $info = null, $data = null)
    {
        return response()->json([
            'status' => $status,
            'info' => !is_null($info) ? $info : '',
            'data' => !is_null($data) ? $data : '',
        ]);
    }

    /**
     * ajax返回分页数据方法
     * @param $pageData
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxResponePageData($pageData)
    {
        return response()->json($pageData);
    }

    /**
     * AJAX成功返回
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse('success', $info, $data);
    }

    /**
     * AJAX失败返回
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxError($info = null, $data = null)
    {
        return $this->ajaxResponse('error', $info, $data);
    }

    /**
     * API成功返回
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function apiSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse(200, $info, $data);
    }

    /**
     * API失败返回
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function apiError($status_code = 400, $info = null, $data = null)
    {
        return $this->ajaxResponse($status_code, $info, $data);
    }

    /**
     * AJAX成功返回并提示
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxTipSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse('tip_success', $info, $data);
    }

    /**
     * AJAX成功返回并提示
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxAdminLoginOutSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse('admin_login_out', $info, $data);
    }

    /**
     * AJAX成功返回并提示
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxMemberLoginOutSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse('member_login_out', $info, $data);
    }

    /**
     * AJAX成功返回并提示
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxIntermediaryLoginOutSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse('intermediary_login_out', $info, $data);
    }

    /**
     * AJAX成功返回并提示
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxCompanyLoginOutSuccess($info = null, $data = null)
    {
        return $this->ajaxResponse('company_login_out', $info, $data);
    }

    /**
     * AJAX失败返回并提示
     *
     * @param null $info
     * @param null $data
     * @return \Symfony\Component\HttpFoundation\Response|JsonResponse
     */
    protected function ajaxTipError($info = null, $data = null)
    {
        return $this->ajaxResponse('tip_error', $info, $data);
    }

    /**
     * jsonp请求响应
     * @param $callback
     * @param $status
     * @param null $info
     * @param null $data
     * @return JsonResponse
     */
    protected function ajaxJsonpResponse($callback, $status, $info = null, $data = null)
    {
        return response()->json([
            'status' => $status,
            'info' => !is_null($info) ? $info : '',
            'data' => !is_null($data) ? $data : '',
        ])->setCallback($callback);
    }

    /**
     * 微信公众号接口数据返回接口
     * @param $status
     * @param null $info
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    protected function ajaxResponseWechat($code, $data = null)
    {
        if ($code == '200') {
            $status = "success";
        } else {
            $status = "fail";
        }
        $info = [
            'code' => $code,
            'msg' => config("wechatException.$code")
        ];
        return response()->json([
            'status' => $status,
            'info' => !is_null($info) ? $info : '',
            'data' => !is_null($data) ? $data : '',
        ]);
    }
}