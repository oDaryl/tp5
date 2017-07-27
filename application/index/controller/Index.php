<?php
namespace app\index\controller;
use think\Db;

class Index
{
    public function index()
    {
        // 后面的数据库查询代码都放在这个位置


//        $result = Db::query('SELECT * FROM yw_honor where status >1');

//        ThinkPHP 5.0查询构造器使用 PDO参数绑定，以保护应用程序免于 SQL注入，因此传入的参数不需额外转义特殊字符

//        查询数据
        $list = Db::name('honor')
            ->where('status','>' ,0)
            ->select();
        return json($list);
    }

}