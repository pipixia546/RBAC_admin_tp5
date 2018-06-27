<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/21
 * Time: 19:11
 */
namespace app\admin\model;
use think\Model;
use think\Db;
class Menu extends Model
{
   public static function getMenu($user=[]){
//        if (empty($user)){
//            $this->error('尚未登录','admin/login/index');
//        }
        $rule=Db::table('tp_useradmin')->alias('a')->join('tp_role b','a.role_id=b.role_id')->where('a.username',$user)->value('b.rule');
        $arr=explode(',',trim($rule,','));
        $menu=Db::name('rule')->where('id','in',$arr)->where('is_menu',1)->where('level_id',0)->select();
        foreach ($menu as $key=>$item){
            $menu[$key]['menu']= Db::name('rule')->where('id','in',$arr)->where('is_menu',1)->where('level_id',$item['id'])->select();
        }
        return $menu;
   }
}