<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 13:59
 */
namespace app\api\validate;
use think\Validate;


class IDMustBePositiveInt extends Validate{
    protected   $rule = [
        'model_id'   => 'require|isPositiveInteger',
    ];

    protected function isPositiveInteger($value,$rule = '',$data = '',$field =''){
        if(is_numeric($value) && is_int($value+0) && ($value+0)>=0){
            return true;
        }else{
           return false;
        }
    }



    //不符合规则的错误信息
    protected $msg = [

    ];



}