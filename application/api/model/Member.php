<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/10
 * Time: 18:39
 */

namespace app\api\model;


use think\Db;
use think\Model;
use think\Request;

class Member extends Model
{
    public static function getUserInfo(){
        $request = Request::instance();
        $data = $request->param();

        //查询支付密码，盐
        $userinfo = Db::name('member')
            ->where('userid','=',$data['userid'])
            ->field(['payword','paysalt'])
            ->find();
        return $userinfo;


    }

    public static function getPassword($payWord,$paySalt){
        $str = md5(md5($payWord)).$paySalt;
        $strMD5 =md5($str);
        return $strMD5;

    }
}