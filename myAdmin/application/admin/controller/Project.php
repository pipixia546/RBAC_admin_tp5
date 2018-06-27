<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/6
 * Time: 17:17
 */

namespace app\admin\controller;


use think\Db;
use think\facade\Request;

class Project extends Admin
{
    public function index(){
        $list=Db::name('project')->order('id','asc')->select();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add(){
        if (Request::isPost()){
            $info=Request::param();
            $file= Request::file('project_logo');
            //
            if(empty($file)) return json(['code'=>1,'msg'=>'请选择上传图片']);
            //$file=$info['project_logo'];
            //var_dump($file);die();
            $data = $file->move('logo');
            if($data){
                $logo='logo/'. $data->getSaveName();;
                $info['project_logo']=$logo;
                if(Db::name('project')->insert($info)){
                    return json(['code'=>0,'msg'=>'项目添加成功！']);
                }else{
                    return json(['code'=>1,'msg'=>'项目添加失败！请稍后再试~~']);
                }
            }else{
                $msg=$file->getError();
                return json(['code'=>1,'msg'=>$msg]);
            }
        }
        return $this->fetch();
    }

    public function del(){
        $input=Request::param('str');
        $data=explode(',',trim($input,','));
        if (Db::name('project')->where('id','in',$data)->delete()){
            return json(['code'=>0,'msg'=>'删除成功']);
        }else{
            return json(['code'=>1,'msg'=>'删除失败']);
        }
    }
    public function edit(){
        if (Request::isPost()){
            $info=Request::param();
            $file= Request::file('project_logo');
            if(!empty($file)){
                $data = $file->move('logo');
                if($data) {
                    $logo = 'logo/' . $data->getSaveName();;
                    $info['project_logo'] = $logo;
                }else{
                    $msg=$file->getError();
                    return json(['code'=>1,'msg'=>$msg]);
                }
            }else{
                unset($info['project_logo']);
            }
            if (Db::name('project')->update($info)){
                return json(['code'=>0,'msg'=>'活动项目修改成功！']);

            }else{
                return json(['code'=>1,'msg'=>'活动项目修改失败！请稍后再试~~']);

            }
        }else{
            $id=Request::param();
            $list=Db::name('project')->where($id)->find();
            $data=explode(',',trim($list['project_condition'],','));
            $this->assign('data',$data);
            $this->assign('list',$list);
           // var_dump($list);die();
            return $this->fetch();
        }

    }
}