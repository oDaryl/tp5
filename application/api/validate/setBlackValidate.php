<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/17
 * Time: 9:30
 */

namespace app\api\validate;


class setBlackValidate extends BaseValidate
{
    protected $rule = [
        'username' =>'require',
//        'username' =>'require|token',
        'black'    =>'require',
    ];

}