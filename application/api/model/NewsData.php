<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 19:20
 */

namespace app\api\model;

use think\Model;

class NewsData extends Model
{

    public function imgUrl()
    {
        return $this->belongsTo('Image', 'itemid');
    }
}