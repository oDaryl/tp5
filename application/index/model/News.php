<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/17
 * Time: 16:33
 */
namespace app\index\model;
use think\Model;
class News extends Model
{
    // 开启自动写入时间戳
    protected $autoWriteTimestamp = true;


//    // 定义自动完成的属性
    protected $insert = ['status' => 1];

    //定义关联方法
    public function newsData() {
        //用户HAS ONE档案关联
        return $this->hasOne('app\index\model\NewsData','itemid','itemid');
    }
}
