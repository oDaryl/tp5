<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 19:01
 */

namespace app\api\model;


use think\Model;

class News extends Model
{
    public function newsData()
    {
        return $this->hasone('news_data','itemid','itemid');
    }

    public function getAddTimeAttr($addtime){
        return date("Y-m-d H:i:s",$addtime);
    }

    public function getEditTimeAttr($edittime){
        return date("Y-m-d H:i:s",$edittime);
    }
}