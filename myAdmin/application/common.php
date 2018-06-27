<?php
function deepspecialchars($data){
    if(empty($data)){
        return $data;
    }
    return is_array($data) ? array_map('deepspecialchars', $data) : htmlspecialchars($data);
}
function getCondition($data){
    $data=explode(',',trim($data,','));
    $str="";
    foreach ($data as $key=>$item){
        $name=\think\Db::name('condition')->where('id',$item)->find();
        $str.="<p class=\"pass-form-item\">
                    <label for=\"\">".$name['name']."：</label>
                    <input class=\"input\" type=\"text\"  name=\"condition\" rel='".$name['name']."' />
                </p>";
    }
    return $str;
}
function getProject($data){
    $name=\think\Db::name('project')->where('id',$data)->value('project_name');
    return $name;
}