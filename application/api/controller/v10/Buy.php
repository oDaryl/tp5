<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/22
 * Time: 18:32
 */
namespace app\api\controller\v10;
use app\api\controller\v1\Category;
use app\api\model\Member as MemberModel;
use app\api\validate\BuyValidate;
use app\api\validate\ConfirmPayValidate;
use app\api\validate\EndTask;
use app\api\validate\ModifyDesc;
use app\api\validate\ModifyTitle;
use app\api\validate\SendEmailValidate;
use app\api\validate\TuoGuan;
use think\Db;
use Think\Exception;
use think\Request;
use think\Validate;

class Buy   extends BuyValidate
{
//D:\xampp\htdocs\ywb2b_v02\buy\sreward\control\pub.php
//return $this->_task_id = $this->_db->inserttable($this->_tablename,$data,1,$this->_replace);
//D:\xampp\htdocs\ywb2b_v02\lib\table\Keke_witkey_task_class.php
//http://ip.taobao.com/service/getIpInfo.php?ip=120.76.78.213

    public function pubtask(Request $request)
    {
            $data = $request->param();
            //验证规则
//根据验证规则验证数据
            $validate = new BuyValidate();
            if (!$validate->check($data)) {
                $error = $validate->batch()->getError();
                return json(['msg' => $error,'code' => 500]);
            }
//增加没有的字段
            unset($data['version']);
            unset($data['name']);
            $data['start_time'] = time();
            $data['end_time'] = strtotime($data['end_time']);
            $data['sub_time'] = $data['end_time'];
            if ($data['end_time'] < $data['start_time']) {
                return json(['error' => '结束时间不能小于当前时间']);
            }
            $data['task_status'] = 2;//发布时0，付款为1，审核为2
            $data['model_id'] = $data['model_id'] + 1;
            $data['cash_cost'] = sprintf("%.2f", $data['task_cash']);
            //单人悬赏
            if ($data['model_id'] == 1) {
                $data['profit_rate'] = 10;
                $data['task_fail_rate'] = 10;
            }

//            $data['model_id']=$data['model_id']+1;
//            $data['task_title']='任务标题';
//            $data['task_desc']='任务描述';
//            $data['indus_fid']='0';
//            $data['indus_pid']='1';//父行业编号
//            $data['indus_id']='2';
//            $data['indus_sid']='0';
//            $data['username']='用户名';
//            $data['uid']='用户编号';
//            $data['task_cash']='任务赏金';
//            $data['contact']='联系方式';

            $result = Db::name('witkey_task')
                ->insertGetId($data);
            if ($result) {
                return json(['task_id' => $result,'code' => 200]);
            } else {
                return json(['msg' => '发布任务失败','code' => 500]);
            }
    }


    //修改标题，传task_id,task_title
    //应加验证身份，发布人才能修改
    public function modifyTitle(Request $request)
    {

        if ($_REQUEST) {
            $data = $request->param();

//            $validate = new Validate([
//                'task_id'    =>'require|number',
//                'task_title'    =>'require|min:5|max:30',
//
//            ]);

            $validate = new ModifyTitle();
            if (!$validate->check($data)) {
                dump($validate->getError());
            } else {
                $result = Db::name('witkey_task')
                    ->update(['task_title' => $data['task_title'], 'task_id' => $data['task_id']]);
                if ($result) {
                    return json(['msg' => 'update success', 'status' => 200]);
                } else {
                    return json(['msg' => 'update fail', 'status' => 500]);

                }
            }
        } else {
            return json('nodata');
        }
//         return json('ok');
    }

    public function modifyDesc(Request $request)
    {

        if ($_REQUEST) {
            $data = $request->param();


            $validate = new ModifyDesc();
            if (!$validate->check($data)) {
                dump($validate->getError());
            } else {
                $result = Db::name('witkey_task')
                    ->update(['task_desc' => $data['task_desc'], 'task_id' => $data['task_id']]);
                if ($result) {
                    return json(['msg' => 'update success', 'status' => 200]);
                } else {
                    return json(['msg' => 'update fail', 'status' => 500]);

                }
            }
        } else {
            return json(['msg' => 'nodata', 'status' => 500]);
        }
//         return json('ok');
    }


    public function endTask(Request $request)
    {

        if ($_REQUEST) {
            $data = $request->param();
            $validate = new EndTask();
            if (!$validate->check($data)) {
                dump($validate->getError());
            } else {
                $result = Db::name('witkey_task')
                    ->delete(['task_id' => $data['task_id']]);
                if ($result) {
                    return json(['msg' => 'delete success', 'status' => 200]);
                } else {
                    return json(['msg' => 'delete fail', 'status' => 500]);
                }
            }
        } else {
            return json(['msg' => 'nodata', 'status' => 500]);
        }
//         return json('ok');
    }

    //传入task_id，task_cash，用户id（用户名）
    public function tuoguan(Request $request)
    {
        $data = $request->param();
        $validate = new TuoGuan();
        if (!$validate->check($data)) {
            return json($validate->getError());

        } else {
            //查询是否存在该用户，不存在则。。。
            $result = Db::name('member')
                ->where('userid', '=', $data['userid'])
                ->value('money');
            $result = sprintf("%.2f", $result);
            $data['task_cash'] = sprintf("%.2f", $data['task_cash']);
            $remain = $result - $data['task_cash'];
            $remain = sprintf("%.2f", $remain);
            $data['remain'] = $remain;
            $data['result'] = $result;

            if ($remain < 0) {
//                return json(['msg'=>'余额不足','任务金额'=>$data['task_cash'],'账户余额'=>$result,'支付后余额'=>$remain]);
                return json(['code' => '500', 'msg' => '余额不足', 'task_cash' => $data['task_cash'], 'result' => $result, 'remain' => $remain]);
//                return json($data);
            }

//            return json(['msg'=>'余额足，进行余额支付托管金','任务金额'=>$data['task_cash'],'账户余额'=>$result,'支付后余额'=>$remain]);
            return json(['code' => '200', 'msg' => '余额足,进行余额支付托管金', 'task_cash' => $data['task_cash'], 'result' => $result, 'remain' => $remain]);
        }
    }


    //确认付款,
    //目前完成校验支付密码，更改cash_cost字段
    //对应账户扣款以及其他业务，未实现
    //其他业务有用户余额扣款，用户资金流水,网站利润
    public function confirmPay(Request $request)
    {
        $data = $request->param();
        (new ConfirmPayValidate())->goCheck();
        $userinfo =MemberModel::getUserInfo();


//加密用户传入支付密码
        $data['payword'] = MemberModel::getPassword($data['payword'],$userinfo['paysalt']);

        if($data['payword']==$userinfo['payword']){

            unset($data['version']);
            unset($data['userid']);
            unset($data['name']);
            unset($data['payword']);
            $data['cash_cost'] = -1;


            //是否已经付款
            $payed = Db::name('witkey_task')
                ->where('task_id', '=', $data['task_id'])
                ->field(['cash_cost'])
                ->find();


            if($payed['cash_cost']==-1){
                return json(['code'=>500,'msg'=>'已经支付过了']);
//                throw new Exception;
            }


            $result = Db::name('witkey_task')
                ->where('task_id', '=', $data['task_id'])
                ->update($data);

            if($result){
                return  json(['code'=>200,'msg'=>'支付成功']);
            }else{
                return  json(['code'=>200,'msg'=>'支付失败']);
            }
        }else{
            return  json(['code'=>500,'msg'=>'支付密码错误']);
        }

    }

//任务发送站内信给投稿人
    public function sendEmail(Request $request){
        $data = $request->param();
        (new SendEmailValidate())->goCheck();
        $data['status'] = '3';
        unset($data['version']);
        unset($data['name']);
//return json($data);
        //message




        //会员表message+1
        $result2 = Db::name('member')
            ->where('username','=',$data['touser'])
            ->setInc('message');

        if( !$result2){
            return  json(['code'=>500,'msg'=>'失败']);
        }


        $result = Db::name('message')
            ->insert($data);

        $userId = Db::name('message')->getLastInsID();




        if( $result){
            return  json(['code'=>200,'msg'=>'成功,此次插入id为'.$userId]);
        }else{
            return  json(['code'=>500,'msg'=>'失败']);
        }



    }

//任务对应投稿者以及其相关信息接口
//接口地址 120.76.78.213/tp5/public/index.php/v10/buy/SubmissionDetail
//get请求
//投稿人 username
//投稿人id uid
//等级图片 seller_lvvel
//投稿时间 work_time
//是否浏览 is_view
//留言 work_desc
//图（附件） work_pic
//task_id 与上面任务相关
//select m.truename,a.*,b.avatarpic,b.seller_credit,b.seller_good_num,b.address,b.seller_total_num,b.seller_level from yw_witkey_task_work a left join yw_company b   on a.uid=b.userid INNER JOIN  yw_member m on b.userid = m.userid

    public function SubmissionDetail(){
        $data = Db::name('witkey_task_work')
                ->field('m.truename,a.*,b.avatarpic,b.seller_credit,b.seller_good_num,b.address,b.seller_total_num,b.seller_level')
                ->alias('a')
                ->join('company b','a.uid=b.userid','LEFT')
                ->join('member m','b.userid = m.userid')
                ->select();
        foreach($data as $k => $v){
            $arr = array("\r","\n","\t","&nbsp;","&nbsp;");

            $data[$k]['work_desc'] = str_replace($arr,"",strip_tags(htmlspecialchars_decode($v['work_desc'])));
            if (unserialize($v['seller_level'])) {
                $v['seller_level'] = unserialize($v['seller_level']);
                $data[$k]['seller_level'] = DT_PATH .'/'.substr(strstr($v['seller_level']['pic'], '<'), 10, 35);
            }else{
                $data[$k]['seller_level'] = DT_PATH."/file/upload/201702/15/170351491.gif";
            }
        }

        if($data){
//            return  json([$data,'code'=>200,'msg'=>'成功']);
            return  json($data);
        }else{
            return  json(['code'=>500,'msg'=>'失败']);
        }
    }

}


