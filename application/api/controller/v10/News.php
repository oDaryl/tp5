<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/18
 * Time: 17:04
 */
namespace app\api\controller\v10;
use think\Db;

class News{
    public function readAll(){
        $list = Db::table('yw_news')
            ->alias('n')
            ->join('yw_news_data d','n.itemid=d.itemid')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['edittime'] = date('Y-m-d',$v['edittime']);
            $list[$k]['addtime'] = date('Y-m-d',$v['addtime']);
            $list[$k]['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['content'])));
        }
        return json($list);
    }
}