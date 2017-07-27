<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 13:26
 */

namespace app\api\validate;


use think\Validate;

class ModifyDesc extends BaseValidate
{
    protected $rule = [
        'task_id'    =>'require|number',
        'task_desc'    =>'require|min:30|max:600',
    ];
}