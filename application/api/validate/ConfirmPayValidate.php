<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 16:44
 */

namespace app\api\validate;


class ConfirmPayValidate extends BaseValidate
{
    protected $rule = [
        'userid'    =>'require|number',
        'task_id'   =>'require|number',
        'task_cash' =>'require|number',
        'payword' =>'require',
//        'payword' =>'require|length:6',
    ];
}