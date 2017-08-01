<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/18
 * Time: 17:04
 */
namespace app\api\controller\v20;
use app\api\model\News as NewsModel;
use app\api\model\NewsData;


class News{
    public function readAll(){

        $newdata =NewsModel::all() ;
// 输出Profile关联模型的email属性
       return json($newdata);

    }
}