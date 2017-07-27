<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;

//参数传入的方式
//Route::rule(':version/','api/:version');
//Route::rule(':version/company/:userid','api/:version.company/read');

Route::rule(':version/company/:name','api/:version.company/:name');
Route::rule(':version/buy/:name','api/:version.buy/:name');




Route::rule('hello/[:name]$','index/hello');

return [

    //定义闭包
    'hello/[:name]' =>function  ($name){
        return 'hello,'.$name.'!';
    },

//全局变量定义
    '__pattern__' => [
        'userid'=>'\d+',
        'id'    =>'\d+',
        'name' => '\w+',
    ],


];
