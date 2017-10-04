<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/7/14
 * Time: 11:37
 */

namespace App\Http\Controllers;

use App\Contracts\WechatContractInterface;
use App\Traits\Controller\AjaxTraits;
use Config;
use Illuminate\Http\Request;
use Curl;
use ComLog;
use Crypt;
use Cache;

class WechatController extends Controller
{
    use AjaxTraits;

    public function checkWechat(Request $request)
    {
        $echoStr = $request->input('echostr');
        $signature = $request->input('signature');
        $timestamp = $request->input('timestamp');
        $nonce = $request->input('nonce');
        $token = Config::get('services.wechat_token');
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $signature) {
            echo $echoStr;
            exit;
        }
    }

    public function wechatJump($type)
    {
        $REDIRECT_URI = 'http://' . env('APP_DOMAIN_HOME') . '/wx/wechatCallback/' . $type;
        $APPID = Config::get('services.wechat_appid');
        $scope = 'snsapi_base';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $APPID . '&redirect_uri=' . urlencode($REDIRECT_URI) . '&response_type=code&scope=' . $scope . '&state=STATE#wechat_redirect';
        ComLog::write('wechatJump', $url);
        header("Location:" . $url);
    }

    public function wechatCallback($type, Request $request)
    {
        $appid = Config::get('services.wechat_appid');
        $secret = Config::get('services.wechat_app_secret');
        $code = $request->input("code");
        $get_token_url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appid . '&secret=' . $secret . '&code=' . $code . '&grant_type=authorization_code';
        $res = Curl::fetch($get_token_url);
        $json_obj = json_decode($res, true);
        ComLog::write('wechatCallback', $json_obj);
        $signOpenId = json_encode(['openid' => $json_obj['openid'], 'timestamp' => time()]);  //openid内容
        switch ($type) {
            case 'intermediary':
                $request->session()->clear();
                if ($request->session()->get(env('INTERMEDIARY_SESSION_KEY'))) {
                    $user=$request->session()->get(env('INTERMEDIARY_SESSION_KEY'));
                    if(isset($user->intermediary_id)&&$user->intermediary_id>0){
                        $jumpUrl = 'http://' . env('APP_DOMAIN_HOME') . '/#/intermediary/recruit_list';
                    }else{
                        $jumpUrl = 'http://' . env('APP_DOMAIN_HOME') . '/#/intermediary_login/' . Crypt::encrypt($signOpenId);   //openid加密
                    }
                } else {
                    $jumpUrl = 'http://' . env('APP_DOMAIN_HOME') . '/#/intermediary_login/' . Crypt::encrypt($signOpenId);   //openid加密
                }
                break;
            case 'member':
                if ($request->session()->get(env('MEMBER_SESSION_KEY'))) {
                    $user=$request->session()->get(env('MEMBER_SESSION_KEY'));
                    if(isset($user->admin_user_id)&&$user->admin_user_id>0){
                        $jumpUrl = 'http://' . env('APP_DOMAIN_HOME') . '/#/member';
                    }else{
                        $request->session()->clear();
                        $jumpUrl = 'http://' . env('APP_DOMAIN_HOME') . '/#/member_login/' . Crypt::encrypt($signOpenId);   //openid加密
                    }
                } else {
                    $jumpUrl = 'http://' . env('APP_DOMAIN_HOME') . '/#/member_login/' . Crypt::encrypt($signOpenId);
                }
                break;
        }

        return redirect($jumpUrl);
    }

    public function makeJsSign(WechatContractInterface $wechatService)
    {
        $appid = Config::get('services.wechat_appid');
        $access_token = $wechatService->getAccessToken();
        ComLog::write('makeJsSign', $access_token);
        $jsapiTicket = $this->getJsapi_ticket($access_token);
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "http://" . env('APP_DOMAIN_HOME') . "/";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);
        $signPackage = array(
            "appId" => $appid,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string,
            'cover'=>'/images/indexLogo.png'
        );
        return $this->ajaxSuccess("success", $signPackage);
        //return $signPackage;
    }


    private function createNonceStr($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    private function getJsapi_ticket($access_token)
    {
        $cacheKey = 'wx_jsapi_ticket';
        //判断是否为空,为空第一次添加jsapi_ticket
        if (!Cache::get($cacheKey)) {
            //微信获取jsapi_ticket接口
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=" . $access_token . "&type=jsapi";
            //get请求接口
            $res = Curl::fetch($url);
            $arr = json_decode($res, true);
            $jsapi_ticket = $arr['ticket'];
            Cache::put($cacheKey, $jsapi_ticket, 60);
            ComLog::write('getJsapi_ticket1', $jsapi_ticket);
        } else {
            //没有过期则用缓存起来的access_token
            $jsapi_ticket = Cache::get($cacheKey);
            ComLog::write('getJsapi_ticket2', $jsapi_ticket);
        }
        ComLog::write('getJsapi_ticket3', $jsapi_ticket);
        return $jsapi_ticket;
    }
}