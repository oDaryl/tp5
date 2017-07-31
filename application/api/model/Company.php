<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/18
 * Time: 11:57
 */

namespace app\api\model;
use think\Model;

class Company extends Model
{
    // 头像读取器
    protected function getAvatarpicAttr($avatarpic)
    {
        return DT_PATH.$avatarpic;
    }
}