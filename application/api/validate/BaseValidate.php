<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 15:34
 */

namespace app\api\validate;


use think\Request;
use think\Validate;
use Think\Exception;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $request = Request::instance();
        $params = $request->param();
        $result = $this->check($params);
        if (!$result) {
            $error = $this->error;
            throw new Exception($error);
        } else {
            return true;
        }
    }

//    public function goChec1k(Request $request)
//    {
//        $params = $request->param();
//        $validate = new ConfirmPayValidate();
//        if (!$validate->check($params)) {
//            return json($validate->getError());
//        }
//
//    }
}