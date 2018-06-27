<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/1
 * Time: 19:44
 */

namespace app\admin\controller;


use think\Db;
use think\facade\Request;
use think\facade\Session;

class Index extends Admin
{
    public function index(){
        $this->assign('user',$this->user);
        return $this->fetch();
    }

    public function logout(){
        Session::delete('username');
        if (!Session::has('username')){
            return json(['code'=>0,'msg'=>'退出成功']);
        }else{
            return json(['code'=>1,'msg'=>'退出失败']);
        }

    }
}