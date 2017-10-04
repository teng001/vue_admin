<?php

/*
|--------------------------------------------------------------------------
| 路由配置
|--------------------------------------------------------------------------
|
| 加载app/Routes文件夹下的所有路由配置
|
*/


require __DIR__ . '/Routes/admin.php';


//Route::any('/wx/checkWechat', [
//    'as' => '/wx/checkWechat',
//    'uses' => 'WechatController@checkWechat',
//]);
//
//
//Route::get('/wx/wechatJump/{type}', [
//    'as' => '/wx/wechatJump',
//    'uses' => 'WechatController@wechatJump',
//]);
//
//
//Route::get('/wx/wechatCallback/{type}', [
//    'as' => '/wx/wechatCallback',
//    'uses' => 'WechatController@wechatCallback',
//]);
//
//
//Route::get('/wx/makeJsSign', [
//    'as' => '/wx/makeJsSign',
//    'uses' => 'WechatController@makeJsSign',
//]);
//
//Route::group(['middleware' => 'wechat.gettoken'], function () {
//
//});

