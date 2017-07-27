<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/18
 * Time: 12:00
 */

namespace app\api\controller\v10;
use app\api\model\Company as CompanyModel;
use think\Db;
use app\extend\tool;
class Company
{
//    public function read($userid=''){
//        $user = CompanyModel::get($userid);
//        if($user){
//            return json($user);
//        }else{
//            return json(['error'=>'数据不存在'],404);
//            // 抛出HTTP异常 并发送404状态码
////            abort(404);
//        }
//    }




    public function readAll(){
//        $list= CompanyModel::all();
        $list = Db::name('company')
            ->alias('c')
            ->join('yw_member m','c.userid = m.userid')
            ->order('c.total_sales desc')
            ->field('m.userid,m.username,m.company,m.qq,c.areaid,c.telephone,c.seller_total_num,c.total_sales,c.accepted_num,c.buyer_total_num,c.buyer_level')
            ->select();
        $ranking = 0;
        foreach($list as $k => $v){
            if (unserialize($v['buyer_level'])) {
                $v['buyer_level'] = unserialize($v['buyer_level']);
                $list[$k]['buyer_level'] = DT_PATH .'/'.substr(strstr($v['buyer_level']['pic'], '<'), 10, 35);
            }else{
                $list[$k]['buyer_level'] = DT_PATH."/file/upload/201702/15/170351491.gif";
            }
            $list[$k]['areaid'] = $this->area_pos($v['areaid'],'/');
            $ranking++;
            $list[$k]['ranking'] = $ranking;
        }
        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }

    function area_pos($areaid, $str = ' &raquo; ', $deep = 0) {
        if($areaid) {
            global $AREA;
        }
        $AREA = include(ROOT_PATH.'public/static/area.php');
        $arrparentid = $AREA[$areaid]['arrparentid'] ? explode(',', $AREA[$areaid]['arrparentid']) : array();
        $arrparentid[] = $areaid;
        $pos = '';
        if($deep) $i = 1;
        foreach($arrparentid as $areaid) {
            if(!$areaid || !isset($AREA[$areaid])) continue;
            if($deep) {
                if($i > $deep) continue;
                $i++;
            }
            $pos .= $AREA[$areaid]['areaname'].$str;
        }
        $_len = strlen($str);
        if($str && substr($pos, -$_len, $_len) === $str) $pos = substr($pos, 0, strlen($pos)-$_len);
        return $pos;
    }
    public function master()
    {
        $list = Db::name('company')
            ->field('catid,catids,areaid,userid,username,total_sales,business,buyer_level,seller_good_num,seller_total_num,avatarpic')
            ->order('total_sales desc')
            ->select();

        foreach ($list as $k=>$v) {

            if (!$v['avatarpic']) {
                $v['avatarpic'] = 'file/upload/default.jpg';
            }
            $list[$k]['avatarpic'] = DT_PATH . $v['avatarpic'];
            if ($v['buyer_level']) {
                $list[$k]['buyer_level'] = DT_PATH . substr(strstr($v['buyer_level'], '<'), 10, 35);
            }
            if ($v['seller_good_num'] && $v['seller_total_num']) {

                $list[$k]['pre'] = round(($v['seller_good_num'] / $v['seller_total_num']) * 100) . '%';

            } else {
                $list[$k]['pre'] = '0%';
            }
            $list[$k]['areaid'] = $this->area_pos($v['areaid'], '/');
            unset($v['seller_good_num']);
            unset($v['seller_total_num']);
        }
        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }

    public function mastertotal(){//总金额排序
        $list = Db::name('company')
            ->field('catid,catids,areaid,userid,username,total_sales,business,buyer_level,seller_good_num,seller_total_num,avatarpic')
            ->order('total_sales desc')
            ->select();

        foreach ($list as $k=>$v) {
            $list[$k]['catid'] = explode(',',substr($v['catid'],1,strlen($v['catid'])-2));
            $list[$k]['catids'] = explode(',',substr($v['catids'],1,strlen($v['catids'])-2));

            if (!$v['avatarpic']) {
                $v['avatarpic'] = 'file/upload/default.jpg';
            }
            $list[$k]['avatarpic'] = DT_PATH . $v['avatarpic'];
            if ($v['buyer_level']) {
                $list[$k]['buyer_level'] = DT_PATH . substr(strstr($v['buyer_level'], '<'), 10, 35);
            }
            if ($v['seller_good_num'] && $v['seller_total_num']) {

                $list[$k]['pre'] = round(($v['seller_good_num'] / $v['seller_total_num']) * 100) . '%';

            } else {
                $list[$k]['pre'] = '0%';
            }
            $list[$k]['areaid'] = $this->area_pos($v['areaid'], '/');
            unset($v['seller_good_num']);
            unset($v['seller_total_num']);
        }
        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }

    }

    public function mastergood(){
        $list = Db::name('company')
            ->field('areaid,userid,username,total_sales,business,buyer_level,seller_good_num,seller_total_num,seller_good_num/seller_total_num as  seller_good_rate,avatarpic')
            ->order('seller_good_rate desc,seller_good_num desc')
            ->select();

        foreach ($list as $k=>$v) {
            if (!$v['avatarpic']) {
                $v['avatarpic'] = 'file/upload/default.jpg';
            }
            $list[$k]['avatarpic'] = DT_PATH . $v['avatarpic'];
            if ($v['buyer_level']) {
                $list[$k]['buyer_level'] = DT_PATH . substr(strstr($v['buyer_level'], '<'), 10, 35);
            }
            if ($v['seller_good_num'] && $v['seller_total_num']) {

                $list[$k]['pre'] = round(($v['seller_good_num'] / $v['seller_total_num']) * 100) . '%';

            } else {
                $list[$k]['pre'] = '0%';
            }
            $list[$k]['areaid'] = $this->area_pos($v['areaid'], '/');
            unset($v['seller_good_num']);
            unset($v['seller_total_num']);
        }
        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }

    }

    public function score(){
        $list = Db::name('witkey_mark')
            ->where('aid','=','1,2,3')
            ->select();


        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }

    }

    public function pictureitem(){
        $list = Db::name('photo_12')
            ->select();


        foreach($list as $k=>$v){
            $list[$k]['edittime'] = date('Y-m-d',$v['edittime']);
            if($v['thumb']){
                $list[$k]['thumb'] = DT_PATH.'/'.$v['thumb'];
            }
        }

        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }

    public function picture(){
        $list = Db::name('photo_12')
            ->alias('p')
            ->join('yw_comment c','p.itemid = c.item_id')
            ->join('yw_company pic','pic.username = c.username')
            ->field('p.items,p.introduce,p.username,p.edittime,p.hits,p.thumb,c.item_id,c.item_title,c.item_username,c.star,c.content,c.username as comUsername,c.addtime,pic.username as companyUsername,pic.avatarpic')
            ->select();

        foreach($list as $k=>$v) {
            $list[$k]['addtime'] = date('Y-m-d H:i', $v['addtime']);
            if ($v['thumb']) {
                $list[$k]['thumb'] = DT_PATH . '/' . $v['thumb'];
            }
            if (!$v['avatarpic']) {
                $v['avatarpic'] = 'file/upload/default.jpg';
            }
            if ($v['avatarpic']) {
                $list[$k]['avatarpic'] = DT_PATH . '/' . $v['avatarpic'];
            }

        }

        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }

    public function contact(){
        $list = Db::name('company')
            ->alias('c')
            ->join('yw_member m','c.username = m.username')
            ->select();


        foreach($list as $k=>$v) {
            $u = $v['username'];
            $r =Db::name("online")
            ->where('username','=',$u)
            ->select();
            $list[$k]['online'] = 0;
            foreach($r as $key=>$val) {
                if($val['online']=='1'){
                    $list[$k]['online'] = 1;
                }
//                if(intval($val['ip']) == 0){
//                    $list[$k]['online'] = '0';
//                } else{
//                    $list[$k]['online'] = '1';
//                }
            }

            $list[$k]['areaid'] = $this->area_pos($v['areaid'],'/');
        }

        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }


    public function skill(){
        $list = Db::name('company')
            ->alias('c')
            ->field('c.username,s.*')
            ->join('yw_company_setting s','s.userid = c.userid')
            ->where('s.item_key','=','unique_skill')
            ->select();


        foreach($list as $k=>$v) {
            $list[$k]['item_value'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['item_value'])));
        }

        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }

    public function mall(){
        $list = Db::name('mall')
            ->where('status','>',1)
            ->select();

        foreach($list as $k=>$v) {
            if ($v['thumb']) {
                $list[$k]['thumb'] = DT_PATH . $v['thumb'];
            }
            if ($v['thumb1']) {
                $list[$k]['thumb1'] = DT_PATH . $v['thumb1'];
            }
            if ($v['thumb2']) {
                $list[$k]['thumb2'] = DT_PATH . $v['thumb2'];
            }
        }

        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }

    public function xiangqing(){
        $list = Db::name('mall')
            ->alias('m')
            ->join('yw_mall_data d','m.itemid = d.itemid')
            ->field('m.itemid,d.*')
            ->select();

        foreach($list as $k=>$v) {
            $list[$k]['content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['content'])));
        }

        if($list){
            return json($list);
        }else{
            return json(['error'=>'数据不存在'],404);
        }
    }



    //评价
//buyer_comment  卖家给买家的评论
//seller_comment 买家给卖家的评论
//d.content是详情
//username卖家seller
//buyer买家
    public function malldetail()
    {
        $list = Db::name('mall')
            ->alias('m')
            ->field('m.itemid,m.username,c.*,d.content')

            ->join('yw_mall_data d', 'm.itemid = d.itemid')
            ->join('yw_mall_comment c', 'm.itemid = c.itemid')
            ->select();

        foreach ($list as $k => $v) {
            $list[$k]['content'] = str_replace("&nbsp;", "", strip_tags(htmlspecialchars_decode($v['content'])));
            if ($v['seller_ctime']) {
                $list[$k]['seller_ctime'] = date('Y-m-d H:i:s', $v['seller_ctime']);

            }

            if ($list) {
                return json($list);
            } else {
                return json(['error' => '数据不存在']);
            }


        }

    }



    //交易记录
//buyer 买家
//price 出价
//number 购买数量
//updatetime 成交时间
//status  状态  成交
    public  function substr_cut($user_name){
        $strlen     = mb_strlen($user_name, 'utf-8');
        $firstStr     = mb_substr($user_name, 0, 1, 'utf-8');
        $lastStr     = mb_substr($user_name, -1, 1, 'utf-8');
        return $strlen == 2 ? $firstStr . str_repeat('*', mb_strlen($user_name, 'utf-8') - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
    }

    public function mallorder(){
        $list = Db::name('mall')
            ->alias('m')
            ->join('yw_mall_order o','m.itemid = o.mallid')
            ->field('m.itemid,o.*')
            ->where('o.status','=','4')
            ->select();

        foreach($list as $k=>$v){
            $list[$k]['buyer'] = $this->substr_cut($v['buyer']);
            $list[$k]['updatetime']= date('Y-m-d H:i:s',$v['updatetime']);
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }
    }


// 显示评价列表，
//信誉等级 评论更加复杂 为中标者对雇主的评价
//(中标者)正在评价-----guzu2 (雇主)
//mark_type = 1  高手评价雇主

    public function typeOne(){
        $list = Db::name('witkey_mark')
            ->alias('m')
            ->join('yw_company c','m.by_username=c.username')
            ->join('yw_witkey_task w','m.origin_id = w.task_id')
            ->field('m.*,c.avatarpic,w.task_title')
            ->where('m.mark_status','>','0')
            ->where('m.mark_type','=','1')
            ->select();

        foreach($list as $k=>$v){
            if(!$v['avatarpic']){
                $v['avatarpic'] ='file/upload/default.jpg';
            }
            $list[$k]['avatarpic'] = DT_PATH.$v['avatarpic'];
            $list[$k]['mark_time'] =date('Y-m-d',$v['mark_time']);
            $list[$k]['mark_content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['mark_content'])));
        }
        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }

}


    //mark_type = 2 雇主评价高手

    public function typetwo(){
        $list =Db::name('witkey_mark')
            ->alias('m')
            ->join('yw_company c','m.by_username=c.username')
            ->join('yw_witkey_task w','m.origin_id=w.task_id')
            ->where('m.mark_status','>','0')
            ->where('mark_type','=','2')
            ->field('m.*,c.avatarpic,w.task_title')
            ->select();
        foreach($list as $k=>$v){
            if(!$v['avatarpic']){
                $v['avatarpic'] ='file/upload/default.jpg';
            }
            $list[$k]['avatarpic'] = DT_PATH.$v['avatarpic'];
            $list[$k]['mark_time'] =date('Y-m-d',$v['mark_time']);
            $list[$k]['mark_content'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['mark_content'])));
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }

    }

//
//
    public function taketask(){
            $list =Db::name('witkey_task')
                ->alias('a')
                ->join('yw_witkey_task_work b','b.task_id = a.task_id')
                ->order('a.task_id DESC')
                ->group('a.task_id')
                ->select();
            foreach($list as $k=>$v){

                $arr = array("\r","\n","&nbsp;","&nbsp;");

                $list[$k]['task_desc'] = str_replace($arr,"",strip_tags(htmlspecialchars_decode($v['task_desc'])));
//                $r['gone'] = $DT_TIME - $v['start_time'];
//                if ($r['status'] == 3) {
//                    if ($r['gone'] > ($MOD['trade_day'] * 86400 + $v['add_time'] * 3600)) {
//                        $r['lefttime'] = 0;
//                    } else {
//                        $r['lefttime'] = secondstodate($MOD['trade_day'] * 86400 + $v['add_time'] * 3600 - $r['gone']);
//                    }
//                }
//                $list[$k]['work_time'] =date('Y-m-d',$v['work_time']);
                $list[$k]['start_time'] =date('Y-m-d',$v['start_time']);
//                $list[$k]['updatetime'] =date('Y-m-d',$v['updatetime']);

            }

            if ($list) {
                return json($list);
            } else {
                return json(['error' => '数据不存在']);
            }

        }

    public function tasklistDescTime(){
        $list =Db::name('witkey_task')
            ->alias('a')
            ->join('witkey_task_cash_cove d','a.task_cash_coverage=d.cash_rule_id','left')
//            ->where('a.task_status','<','8')
            ->where('model_id','IN','1,2,3,4,5,6')
//            ->where('a.task_status','NOT IN','0,1,10')
//            ->order('a.sub_time desc')
            ->order('a.sub_time desc')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['task_desc'])));
            $list[$k]['start_time'] =date('Y-m-d',$v['start_time']);
            $list[$k]['sub_time'] =date('Y-m-d',$v['sub_time']);
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }
    }

    public function tasklistDescMoney(){
        $list =Db::name('witkey_task')
            ->alias('a')
            ->join('witkey_task_cash_cove d','a.task_cash_coverage=d.cash_rule_id','left')
//            ->where('a.task_status','<','8')
            ->where('model_id','IN','1,2,3,4,5,6')
//            ->where('a.task_status','NOT IN','0,1,10')
            ->order('a.task_cash desc')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['task_desc'])));
            $list[$k]['start_time'] =date('Y-m-d',$v['start_time']);
            $list[$k]['sub_time'] =date('Y-m-d',$v['sub_time']);
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }

    }

//稿件数
    public function tasklistDescManuscript(){
        $list =Db::name('witkey_task')
            ->alias('a')
            ->join('witkey_task_cash_cove d','a.task_cash_coverage=d.cash_rule_id','left')
//            ->where('a.task_status','<','8')
            ->where('model_id','IN','1,2,3,4,5,6')
//            ->where('a.task_status','NOT IN','0,1,10')
            ->order('a.work_num  desc')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['task_desc'])));
            $list[$k]['start_time'] =date('Y-m-d',$v['start_time']);
            $list[$k]['sub_time'] =date('Y-m-d',$v['sub_time']);
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }

    }


    public function tasklistState(){
        $list =Db::name('witkey_task')
            ->alias('a')
            ->join('witkey_task_cash_cove d','a.task_cash_coverage=d.cash_rule_id','left')
            ->where('a.task_status','<','8')
            ->where('model_id','IN','1,2,3,4,5,6')
            ->where('a.task_status','NOT IN','0,1,10')
            ->order('a.task_status  desc')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['task_desc'])));
            $list[$k]['start_time'] =date('Y-m-d',$v['start_time']);
            $list[$k]['sub_time'] =date('Y-m-d',$v['sub_time']);
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }
    }



    public function tasklist(){
        $list =Db::name('witkey_task')
            ->alias('a')
            ->join('witkey_task_cash_cove d','a.task_cash_coverage=d.cash_rule_id','left')
            ->where('model_id','IN','1,2,3,4,5,6')
            ->where('a.task_status','NOT IN','0,1,10')
            ->order('a.tasktop desc')
            ->select();
        foreach($list as $k=>$v){
            $list[$k]['task_desc'] = str_replace("&nbsp;","",strip_tags(htmlspecialchars_decode($v['task_desc'])));
            $list[$k]['start_time'] =date('Y-m-d',$v['start_time']);
            $list[$k]['sub_time'] =date('Y-m-d',$v['sub_time']);
        }

        if ($list) {
            return json($list);
        } else {
            return json(['error' => '数据不存在']);
        }
    }


    public function news(){
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



    public function honor(){
        $list = Db::table('yw_honor')
            ->select();
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

//
//        public function usernameSellerMark(){
//                $list =Db::name('company')
//                    ->alias('c')
//                    ->join('yw_member m','m.userid=c.userid and m.username=c.username')
//                    ->select();
//
//
//
//
//
//                if ($list) {
//                    return json($list);
//                } else {
//                    return json(['error' => '数据不存在']);
//                }
//
//            }


    public function cat(){
            $list =Db::name('')

                ->select();
            foreach($list as $k=>$v){

            }

            if ($list) {
                return json($list);
            } else {
                return json(['error' => '数据不存在']);
            }

        }

}