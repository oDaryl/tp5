<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/17
 * Time: 17:20
 */

namespace app\index\controller;
use app\index\model\News as NewsModel;

class News {
    public function read($itemid){
        $list = NewsModel::get($itemid);
        $list .= $list->NewsData->content;
        return json($list);

    }

    public function readAll(){
        $list = NewsModel::all();
        foreach($list as $item){
             $item->NewsData->content;
            $item['edittime'] = date('Y-m-d',$item['edittime']);
            $item['addtime'] = date('Y-m-d',$item['addtime']);
            $item['NewsData']['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($item['NewsData']['content'])));
            $item['content'] =$item['NewsData']['content'];
        }
        return json($list);
    }
}
