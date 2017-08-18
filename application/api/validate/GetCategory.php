<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/10
 * Time: 16:16
 */

namespace app\api\validate;


class GetCategory extends BaseValidate
{
    protected $rule = [
        'indus_id'=>'require',
    ];
}