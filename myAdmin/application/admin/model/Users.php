<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/25
 * Time: 11:38
 */

namespace app\admin\model;
use think\Model;
use think\Db;

class Users extends Model
{
    public static function getUser(){
        $list=Db::table('tp_useradmin')->alias('a')->join('tp_role b','a.role_id = b.role_id')->select();
        return $list;
    }
    public static function getRole(){
        $list=Db::name('role')->select();
        return $list;
    }
    public static function getRule($id=[]){
        $list=Db::name('role')->where('role_id',$id)->value('rule');
        $arr=explode(',',trim($list,','));
        return $arr;
    }

}