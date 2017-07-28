<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/4
 * Time: 16:44
 */

namespace app\api\validate;


class ConfirmPay extends BaseValidate
{
    protected $rule = [
        'userid'    =>'require|number',
        'task_id'   =>'require|number',
        'task_cash' =>'require|number',
        'pay_code' =>'require',
    ];
}