<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/17
 * Time: 14:30
 */

namespace app\api\controller\v10;
use app\api\model\Honor as HonorModel;

class Honor
{
//    public function add()
//    {
//        $honor = new honorModel;
//        $honor['content'] = 'liunian';
//        $honor['linkurl'] = 'liunian';
//
//        if($honor->save()){
//            return '荣誉资质'.$honor->content.'--ok';
//        }else{
//            return $honor->geterror();
//        }
//    }


//    public function read($itemid=''){
//        $honor = honorModel::get($itemid);
//        echo $honor['content'];
//
//    }

    public function readAll(){
        $list = honorModel::all();
        foreach ($list as $item) {
            $item['fromtime'] = date('Y-m-d',$item['fromtime']);
            $item['addtime'] = date('Y-m-d',$item['addtime']);
            $item['edittime'] = date('Y-m-d',$item['edittime']);
            $item['totime'] = date('Y-m-d',$item['totime']);
            $item['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($item['content'])));
            if($item['thumb']){
                $item['thumb'] =DT_PATH.'/'.$item['thumb'];
            }
        }
        return json($list);
    }
}