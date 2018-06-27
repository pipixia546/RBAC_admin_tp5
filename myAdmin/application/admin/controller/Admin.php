<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/4/29
 * Time: 13:04
 */

namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\facade\Config;
use think\facade\Request;
use think\facade\Session;
use app\admin\model\Menu;
class Admin extends Controller{
    protected $user;
    protected $condition;
    protected function initialize(){
        $ip=Config::get('Ip');
        $request = Request::instance()->ip();
        if (!in_array($request,$ip[0])){
            echo '<html><head><title>Yout site</title></head><body><div class="container container-sm"><div id="icon-header"><span class="fa fa-question-circle"></span></div><div id="text-column"><header class="secondary-header"><h1>Error 404: <strong>Page not found.</strong></h1><p>This is not the page you\'re looking for.</p></header><nav class="secondary-nav"><ul><li><a href="#" class="btn btn-primary">Take me home<span class="fa fa-exclamation"></span></a></li></ul></nav></div></div></body></html>';
            exit;
        }else{
            $this->user=Session::get('username');
            //$this->condition=Db::name('condition')->select();
            if (!($this->user)){
                $this->error('尚未登录','admin/login/index');
            }
            if (!$this->getRule()){
                if (Request::isPost()){
                    $this->condition=403;
                }else{
                    $this->error('403 您没有权限');
                }

            }
            $menu=Menu::getMenu($this->user);
            $this->assign('menu',$menu);
        }
    }
    protected function getRule(){
        $this->user=Session::get('username');
        $rule_arr=Db::table('tp_useradmin')->alias('a')->join('tp_role b','a.role_id=b.role_id')->where('a.username',$this->user)->value('b.rule');
        $rule_array=explode(',',trim($rule_arr,','));
        $controller=Request::controller();
        $action=Request::action();
        $rule="/admin/".$controller.'/'.$action;
        $rel_rule=Db::name('rule')->where('url',$rule)->value('id');
        if (in_array($rel_rule,$rule_array)){
            return true;
        }else{
            return false;
        }
    }
}