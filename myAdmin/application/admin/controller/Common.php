<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/6/27
 * Time: 14:43
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;
use think\facade\Session;
use think\facade\Request;
class Common extends Controller
{
    protected function initialize(){
        $user=Session::get('username');
        //$this->condition=Db::name('condition')->select();
        if (empty($user)){
            $this->error('尚未登录','admin/login/index');
        }
    }
    public function main(){
       $info['ip']=Session::get('ip');
       $info['addtime']=Session::get('addtime');
       $info['login_time']=Session::get('login_time');
       $info['username']=Session::get('username');
       $this->assign('info',$info);
       return $this->fetch('index/main');
    }
    public function update_pwd(){
        $user=Session::get('username');
        $this->assign('user',$user);
        if (Request::isPost()){
            $password['password']=md5(deepspecialchars(Request::post('password')));
            if (Db::name('useradmin')->where('username',$user)->update($password)){
                Session::delete('username');
                return json(['code'=>0,'msg'=>'修改成功']);
            }else{
                return json(['code'=>1,'msg'=>'修改失败！']);
            }
        }
        return $this->fetch('index/update_pwd');
    }
}