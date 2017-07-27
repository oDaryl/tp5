<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/27
 * Time: 13:56
 */

namespace app\api\validate;


class SendEmailValidate extends BaseValidate
{
    protected   $rule = [
        'fromuser'   => 'require',
        'touser'   => 'require',
        'title'   => 'require|min:1|max:60',
        'content'   => 'require|min:6|max:600',
    ];




    //不符合规则的错误信息
    protected $msg = [
        'title' => '标题最少五个字',
        'content' => '描述最少十个字',
    ];
}