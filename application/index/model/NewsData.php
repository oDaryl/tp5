<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/17
 * Time: 17:15
 */
namespace app\index\model;
use think\Model;

class NewsData extends Model{
    protected $type       = [
        'addtime' => 'timestamp:Y-m-d',
    ];
}