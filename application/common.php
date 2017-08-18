<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\Request;

function check_name($username) {
    if(strpos($username, '__') !== false || strpos($username, '--') !== false) return false;
    return preg_match("/^[a-z0-9]{1}[a-z0-9_\-]{0,}[a-z0-9]{1}$/", $username);
}


function dpassword($password, $salt) {
    return md5((is_md5($password) ? md5($password) : md5(md5($password))).$salt);
}


function is_md5($password) {
    return preg_match("/^[a-f0-9]{32}$/", $password);
}

function is_login(){
    //必须传递userid字段
    $request = Request::instance();
    $data = $request->param();
    $uid = \think\Db::name('token')
        ->where('uid','=',$data['userid'])
        ->field('token')
        ->select();
        if($data['token'] == $uid['0']['token']){
            return true;
        }else{
            return false;
        }
}


function roundChar( $length = 8 ) {
// 密码字符集，可任意添加你需要的字符
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
    $roundChar = '';
for ( $i = 0; $i < $length; $i++ )
{
// 这里提供两种字符获取方式
// 第一种是使用 substr 截取$chars中的任意一位字符；
// 第二种是取字符数组 $chars 的任意元素
// $roundChar .= substr($chars, mt_rand(0, strlen($chars) – 1), 1);
    $roundChar .= $chars[ mt_rand(0, strlen($chars) - 1) ];
}
return $roundChar;
}


