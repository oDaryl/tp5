<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/1
 * Time: 13:56
 */

namespace app\api\validate;


class PicCommentValidate extends BaseValidate
{
    protected $rule = [
        'item_username'=>'require',
        'username'=>'require',
        'item_id'=>'require',
        'userid'=>'require',
//        'item_mid'=>'require',//现在不知道是啥
        'content'=>'require|min:5|max:500',
    ];
}