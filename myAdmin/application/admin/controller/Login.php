<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/3
 * Time: 12:25
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\facade\Session;
use think\Request;

class Login extends Controller
{
    public function index(){
        if ($this->request->isPost()){
            $input=$this->request->param();
            $input=deepspecialchars($input);
            if(!captcha_check($input['code'])){
               return json(['code'=>1,'msg'=>'验证码错误']);
            };
            $data=[];
            $data['username']=$input['user'];
            $data['password']=md5($input['password']);
            if (!Db::name('useradmin')->where($data)->find()){
                return json(['code'=>1,'msg'=>'账户名或密码错误！']);
            }else{
                Session::set('username',$data['username']);
                $info['login_ip']=$this->request->ip();
                $news=Db::name('useradmin')->where('username',$data['username'])->find();
                Session::set('ip',$news['login_ip']);
                Session::set('addtime',$news['addtime']);
                $info['login_time']=$news['login_time']+1;
                Session::set('login_time',$info['login_time']);
                $info['addtime']=time();
                if (Db::name('useradmin')->where('username',$data['username'])->update($info)){
                    return json(['code'=>0,'msg'=>'登陆成功！']);
                }else{
                    return json(['code'=>1,'msg'=>'登陆失败！请稍后再试']);
                }

            }

        }
        return $this->fetch('login');
    }
}