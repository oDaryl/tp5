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
            ->field('password,payword,passsalt,paysalt',true)
            ->select();
        if(!$user){
            return json(['code'=>500,'msg'=>'用户不存在']);
        }

        if($user['0']['password'] != dpassword($data['password'], $user['0']['passsalt'])){
            return json(['code'=>500,'msg'=>'密码错误']);
        }else{
            return json(['code'=>200,'msg'=>'登录成功']);
        }
    }
}