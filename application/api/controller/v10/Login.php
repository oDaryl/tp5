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
        $data['password'] = trim($data['password']);
        if(!check_name($data['username'])){
            return json('用户名格式错误');
        }
        $user = Db::name('member')
            ->where('username','=',$data['username'])
//            ->field('username,password,passsalt,userid')
            ->select();
        if(!$user){
            return json('用户不存在');
        }

//        echo '前端传过来'.$data['password'];
//        echo '<br/>';
//        echo '加密后'.dpassword($data['password'], $user['0']['passsalt']);echo '<br/>';
//        var_dump($user['0']['password']);
//        echo '<hr/>';
//        return 'asd';

        if($user['0']['password'] != dpassword($data['password'], $user['0']['passsalt'])){
            return json('密码错误');
        }else{
            return json(['code'=>200,'msg'=>'登录成功']);
        }




    }
}