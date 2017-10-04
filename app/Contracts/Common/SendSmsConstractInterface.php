<?php
/**
 * Created by PhpStorm.
 * User: sunjin
 * Date: 2017/5/11
 * Time: 15:55
 */

namespace App\Contracts\Common;


interface SendSmsConstractInterface
{
    public function sendTemplateSMS($to,$datas,$tempType);
}