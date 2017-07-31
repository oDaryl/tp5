<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/28
 * Time: 15:03
 */

namespace app\api\validate;


class SendCommentValidate extends BaseValidate
{
    protected $rule = [
        'item_id'=>'require|number',
        'content'=>'require|max:100',
        'uid'=>'require|number',
        'username'=>'require',
    ];
}