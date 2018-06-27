<?php
/**
 * Created by PhpStorm.
 * Users: Administrator
 * Date: 2018/6/22
 * Time: 14:55
 */
$arr=array(1,2,array('a','b','c'));
foreach ($arr as $vo){
    echo $vo.'<br/>';
    if (is_array($vo)){
        foreach ($vo as $do){
            echo $do.'<br/>';
        }
    }

}