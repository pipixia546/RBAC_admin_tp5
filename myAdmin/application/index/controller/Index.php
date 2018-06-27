<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\facade\Request;

class Index extends Controller
{
    protected function initialize(){
        $prize=Db::name('userapply')->where('status',2)->limit(50)->order('applytime','desc')->select();
        $this->assign('prize',$prize);

    }
    public function index()
    {
        $list=Db::name('project')->select();
        $this->assign('list',$list);
        return $this->view->fetch();
    }
    public function detail(){
        $id=Request::param('id');
        $info=Db::name('project')->where('id',$id)->find();
        $this->assign('list',$info);
        return $this->view->fetch();
    }
    public function apply(){
        if (Request::isPost()){
            $input=deepspecialchars(Request::param());
            if(!captcha_check($input['code'])){
                return json(['code'=>1,'msg'=>'验证码错误']);
            };
            $where['projectid']=trim($input['projectid']);
            $number=Db::name('project')->where('id',$where['projectid'])->value('project_number');
            $time=strtotime(date("Y-m-d"),time());
            $where['user']=trim($input['user']);
            $count=Db::name('userapply')->where($where)->where('applytime','>=',$time)->count();
            if($number<=$count){
                return json(['code'=>1,'msg'=>'今日次数已用完！']);
            }else{
                unset($input['code']);
                $input['applytime']=time();
                if (Db::name('userapply')->insert($input)){
                    return json(['code'=>0,'msg'=>'提交成功！']);
                }else{
                    return json(['code'=>1,'msg'=>'提交失败！，请稍后再试']);
                }
            }
        }
        $id=Request::param('id');
        $info=Db::name('project')->where('id',$id)->find();
        $this->assign('list',$info);
        return $this->view->fetch();
    }
    public function search(){
        if (Request::isPost()){
            $input=Request::param();
            $user=Db::name('userapply')->where('user',$input['user'])->select();
            if (empty($user)){
                return json(['code'=>1,'msg'=>'没有此会员']);
            }else{
                $info=Db::name('userapply')->where($input)->order('applytime','desc')->find();
                if(empty($info)){
                    return json(['code'=>1,'msg'=>'没有申请过该服务!']);
                }else{
                    return json(['code'=>$info['status'],'msg'=>$info['explain']]);
                }
            }

        }
        $list=Db::name('project')->field('id,project_name')->select();
        $this->assign('list',$list);
        return $this->view->fetch();
    }


}
