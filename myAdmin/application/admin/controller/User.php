<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/6
 * Time: 17:18
 */

namespace app\admin\controller;


use think\Db;
use think\facade\Request;
use app\admin\model\Users;

class User extends Admin
{
    public function index(){
        $list=Users::getUser();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function add(){
        if ($this->condition==403){
            return json(['code'=>2,'msg'=>'您没有此权限！请联系超级管理员']);
        }
        if (Request::isPost()){
            $input=Request::param();
            if (empty($input['username'])||empty($input['password'])||empty($input['browseLook'])){
                return json(['code'=>1,'msg'=>'必填项不能为空']);
            }
            $input['password']=md5($input['password']);
            $input['role_id']=$input['browseLook'];
            unset($input['browseLook']);
            if (Db::name('useradmin')->where('username',$input['username'])->find()){
                return json(['code'=>1,'msg'=>'此管理员已存在！']);
            }
            if (Db::name('useradmin')->insert($input)){
                return json(['code'=>0,'msg'=>'管理员添加成功！']);
            }else{
                return json(['code'=>1,'msg'=>'管理员添加失败！']);
            }

        }else{
            $list=Users::getRole();

            $this->assign('list',$list);
            return $this->fetch();
        }

    }
    public function add_role(){
        if ($this->condition==403){
            return json(['code'=>2,'msg'=>'您没有此权限！请联系超级管理员']);
        }
        if (Request::isPost()){
            $input=Request::param();
            if (Db::name('role')->insert($input)){
                return json(['code'=>0,'msg'=>'角色添加成功！']);
            }else{
                return json(['code'=>1,'msg'=>'角色添加失败！']);
            }
        }else{
            $menu=Db::name('rule')->where('level_id',0)->select();
            foreach ($menu as $key=>$item){
                $menu[$key]['menu']=Db::name('rule')->where('level_id',$item['id'])->select();
            }
            $this->assign('menu',$menu);
            return $this->fetch();
        }

    }
    public function rule(){
        $list=Users::getRole();
        $this->assign('list',$list);
        return $this->fetch();
    }
    public function edit_role(){
        if ($this->condition==403){
            return json(['code'=>2,'msg'=>'您没有此权限！请联系超级管理员']);
        }
        if (Request::isPost()){
            $input=Request::param();
            $input['rule']=$input['str'];
            unset($input['str']);
            if (Db::name('role')->update($input)){
                return json(['code'=>0,'msg'=>'权限编辑成功！']);
            }else{
                return json(['code'=>1,'msg'=>'权限编辑失败！']);
            }
        }else{
            $id=Request::param('id');
            $arr=Db::name('role')->where('role_id',$id)->value('rule');
            $arr_rule=explode(',',trim($arr,','));

            $menu=Db::name('rule')->where('level_id',0)->select();
            foreach ($menu as $key=>$item){
                $menu[$key]['menu']=Db::name('rule')->where('level_id',$item['id'])->select();
            }
            $this->assign('menu',$menu);
            $this->assign('id',$id);
            $this->assign('arr',$arr_rule);
            return $this->fetch();
        }

    }
    public function del_role(){
        if ($this->condition==403){
            return json(['code'=>0,'msg'=>'您没有此权限！请联系超级管理员']);
        }
        $input=Request::param('str');
        $data=explode(',',trim($input,','));
        if (Db::name('role')->where('role_id','in',$data)->delete()){
            return json(['code'=>2,'msg'=>'删除成功']);
        }else{
            return json(['code'=>1,'msg'=>'删除失败']);
        }
    }
    public function del_user(){
        if ($this->condition==403){
            return json(['code'=>0,'msg'=>'您没有此权限！请联系超级管理员']);
        }
        $input=Request::param('str');
        $data=explode(',',trim($input,','));
        if (Db::name('useradmin')->where('id','in',$data)->delete()){
            return json(['code'=>2,'msg'=>'删除成功']);
        }else{
            return json(['code'=>1,'msg'=>'删除失败']);
        }
    }
    public function tan(){
        if (Request::isPost()){
            $input=Request::param();
            $input['status']=$input['browseLook'];
            $input['edittime']=time();
            unset($input['browseLook']);
            if (Db::name('userapply')->update($input)){
                return json(['code'=>0,'msg'=>'编辑成功']);
            }else{
                return json(['code'=>1,'msg'=>'编辑失败！请稍后再试~~']);
            }
        }else{
            $id=Request::param('id');
            $info=Db::name('userapply')->where('id',$id)->find();
            $this->assign('info',$info);
            return $this->fetch('edit');
        }

    }
}