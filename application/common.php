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


