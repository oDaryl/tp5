<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 13:26
 */

namespace app\api\validate;


use think\Validate;

class EndTask extends BaseValidate
{
    protected $rule = [
        'task_id'    =>'require|number',
    ];
}