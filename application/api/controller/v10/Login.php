<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/31
 * Time: 15:12
 */

namespace app\api\controller\v10;


use app\api\validate\LoginValidate;
use think\Db;
use think\Request;

class Login extends LoginValidate
{
    public function login(Request $request)
    {
        (new LoginValidate())->goCheck();

        $data = $request->param();
        $data['username'] = strip_tags(trim($data['username']));
        $data['password'] = strip_tags(trim($data['password']));
        if(!check_name($data['username'])){
            return json(['code'=>500,'msg'=>'用户名格式错误']);
        }
        $user = Db::name('member')
            ->where('username','=',$data['username'])
            ->field('payword,paysalt',true)
            ->select();
        if(!$user){
            return json(['code'=>500,'msg'=>'用户不存在','useinfo'=>$user]);
        }

        $user = $user['0'];


        if($user['password'] != dpassword($data['password'], $user['passsalt'])){
            return json(['code'=>500,'msg'=>'密码错误']);
        }else{
            unset($user['password']);
            unset($user['passsalt']);

//            return json(['userInfo' => $user,'code'=>200,'msg'=>'登录成功']);
            $roundChar = roundChar();
            $token = md5(md5($user['username'].$roundChar));
            $data = [
                'uid'=>$user['userid'],
                'token'=>$token,
//                'username'=>$user['username']
            ];



            $uid = Db::name('token')
                ->where('uid','=',$user['userid'])
                ->field('uid')
                ->select();

            if(!$uid){
                $result = Db::name('token')
                    ->insert($data);
            }else{
                Db::name('token')
                    ->where('uid','=',$user['userid'])
                    ->update(['token'=>$token]);
            }
            return json(['code'=>200,'msg'=>'登录成功','useinfo'=>$user,'token'=>$token]);
        }
    }
}