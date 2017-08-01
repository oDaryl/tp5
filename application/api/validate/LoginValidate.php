<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 15:17
 */

namespace app\api\validate;


class LoginValidate extends BaseValidate
{
    protected $rule = [
        'username' =>'require|min:2',
        'password' =>'require|min:5',
    ];
}