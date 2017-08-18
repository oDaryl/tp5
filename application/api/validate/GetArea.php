<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/10
 * Time: 14:47
 */

namespace app\api\validate;


class GetArea extends BaseValidate
{
    protected $rule = [
        'area'=>'require',
    ];
}