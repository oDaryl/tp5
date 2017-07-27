<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 13:59
 */
namespace app\api\validate;
use think\Validate;


class BuyValidate extends Validate{
    protected   $rule = [
        'model_id'   => 'require|max:1|number',
        'uid'        => 'require|number',
        'task_cash'  => 'require|number|>:0',
        'contact'    => 'require|number',
        'indus_fid'  => 'require|number',
        'indus_pid'  => 'require|number',
        'indus_id'   => 'require|number',
        'indus_sid'  => 'require|number',
        'task_title' => 'require|min:5',
        'task_desc'  => 'require|min:10',
        'end_time'   => 'require|date',
        'username'   => 'require',
        'area'       => 'require',

    ];




    //不符合规则的错误信息
    protected $msg = [
        'model_id.require' => '任务类型id必须',
        'model_id.max' => '名称必须小于1位',
        'task_title' => '标题最少五个字',
        'task_desc' => '描述最少十个字',
        'indus_fid.number' => 'indus_fid必须',
        'indus_pid.number' => 'indus_pid必须',
        'indus_id.number' => 'indus_id必须',
        'indus_sid.number' => 'indus_sid必须',
        'username.number' => 'username必须',
        'uid.number' => 'uid必须',
        'task_cash.number' => '金额必须为数字',
        'contact.number' => '联系方式必须为数字',
        'area.require' => '地区必须',
    ];
}