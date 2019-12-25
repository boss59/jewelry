<?php
use Illuminate\Support\Facades\Storage;
/*
 * //对称加密
 */
function sym_encrpty($str,$key){
    $target="";
    for ($i=0;$i<strlen($str);$i++){
        $target.=$str[$i]^$key;
    }
    return base64_encode($target);;
}
/*
 * //对称解密
 */
function sym_decrpty($str,$key){
    $str=base64_decode($str);
    $target="";
    for($i=0;$i<strlen($str);$i++){
        $target.=$str[$i]^$key;
    }
    return $target;
}
/*
 * 注册邮件发送
 */
function endMail($email)
{
    $msg = "恭喜你，注册成功,现在无法进入后台，请联系超级管理员！！";
    \Mail::raw($msg ,function($message)use($email){
        //设置主题
        $message->subject("注册邮件发送");
        //设置接收方
        $message->to($email);
    });
}
/*
 * //curl的post方法     $url 接口路径   $data 接口参数
 */
function curl_post($url,$data)
{
    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
    curl_setopt($curl,CURLOPT_POST,true);
    curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}
/*
 * //curl的post方法     $url 接口路径
 */
function curl_get($url)
{
    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,false);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,false);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}



/*
 * 文件上传
 */
function create_img($file,$pathname)
{
    if (empty($file)){
        return false;
    }
    $time = date('Ymd',time());
    // 获取文件相关信息
    $originalName = $file->getClientOriginalName(); // 文件原名
    $ext = $file->getClientOriginalExtension();     // 扩展名
    $realPath = $file->getRealPath();   //临时文件的绝对路径
    $type = $file->getClientMimeType();     // image/jpeg
    // 上传文件
    $filename = uniqid() . '.' . $ext;
    $img_path=$data['pic_path'] = $pathname.$time.'/'.$filename;
    // 使用我们新建的uploads本地存储空间（目录）
    //这里的uploads是配置文件的名称
    $bool = Storage::disk('uploads')->put($img_path, file_get_contents($realPath));

    $path = '/imgs'.$img_path;
    return $path;
}
/*
 * 多文件上传
 */
function  uploadAll()
{

}
//=====================  无限极分类   ==================
/*
 * 无限极分类
 */
// 递归创建 分类 树形结构
function createTree($data,$parent_id=0,$level=1)
{
    //1 定义 一个容器（新数组);
    static  $new_arr = [];
    //2 遍历 数据一条条比对
    foreach ($data as $key => $value) {
        //3找 parent_id = 0 的id
        if ($value['parent_id'] == $parent_id) {
            //增加级别 字段
            $value['level'] = $level;
            //4 找到 之后放到新的数组里
            $new_arr[] = $value;
            //调用 程序自身递归找子集
            createTree($data,$value['cate_id'],$level+1);
        }
    }
    return $new_arr;
}
// 递归创建 分类 呈次结构
function createTreeBySon($data,$parent_id=0)
{
    //1 定义 一个容器（新数组);
    $new_arr = [];
    //2 遍历 数据一条条比对
    foreach ($data as $key => $value) {
        //3找 parent_id = 0 的id
        if ($value['parent_id'] == $parent_id) {
            $new_arr[$key] = $value;
            $new_arr[$key]['son'] = createTreeBySon($data,$value['cate_id']);
        }
    }
    return $new_arr;
}
// 获取分类ID
function getCId($data,$parent_id)
{
    static $arr=[];
    $arr[$parent_id]=$parent_id;
    foreach ($data as $k => $v) {
        if ($v['parent_id']==$parent_id) {
            $arr[$v['cid']]=$v['cid'];
           getCId($data,$v['cid']);
        }
    }
    return $arr;
}
// ================   文件 操作  =====================
/*
 * //循环删除目录和文件函数  
 * //清空文件夹函数和清空文件夹后删除空文件夹函数的处理
 */
function del_dir($path){
    //如果是目录则继续
    if(is_dir($path)){
        //扫描一个文件夹内的所有文件夹和文件并返回数组
        $p = scandir($path);
        foreach($p as $val){
            //排除目录中的.和..
            if($val !="." && $val !=".."){
                //如果是目录则递归子目录，继续操作
                if(is_dir($path.$val)){
                    //子目录中操作删除文件夹和文件
                    del_dir($path.$val.'/');
                    //目录清空后删除空文件夹
                    @rmdir($path.$val.'/');
                }else{
                    //如果是文件直接删除
                    unlink($path.$val);
                }
            }
        }
    }
}
//方法 2
function dir_del($dir)
{
    $data=array_map('unlink',glob($dir));
    dd($data);
}
/*
 * 日志
 */
function arr_dir($arr)
{
    $baseDir= Date("Y/m/d/",time());
    $path=storage_path("logs/api/".$baseDir."");
    if (!is_dir($path)) {
        mkdir($path,0,777);
    }
    file_put_contents($path.date('Y-m-d').'.txt',"<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n",FILE_APPEND);
    file_put_contents($path.date('Y-m-d').'.txt',"$arr\n",FILE_APPEND);
}

//======================== 接口调用  ==================
//接口 视频
function video_arr($name)
{
    $keys = "video";
//    \Cache::forget($keys);die;
    //判断缓存是否存在
    if(\Cache::has($keys)) {
        //取缓存
        $arr = \Cache::get($keys);
    }else{
        //取不到，调接口，缓存
        $key = "3fc119a0d8ac4740ad1ca075cab0631e";
        $url = "http://api.avatardata.cn/Movie/Query?key=".$key."&name=".$name;
        $res=curl_get($url);
        $result = json_decode($res,true,JSON_UNESCAPED_UNICODE);
        \Cache::put($keys,$result['result'],86400);
        $arr = $result['result'];
    }
    return  $arr;
}
// 段子接口
function  jokes()
{
    // 连接redis
    $redis = new \Redis();
    $redis->connect('127.0.0.1');
    $keys = "jokes";
    if (empty($redis->get($keys))){
        //取不到，调接口，缓存
        $key = "d7ec41cfe9054139811bf464562c3499";
        $res=file_get_contents("http://api.avatardata.cn/Joke/QueryJokeByTime?key=".$key."&page=2&rows=20&sort=asc&time=1418745237");
        $redis->set($keys,$res,86400);
        $arr = json_decode($res,true);
    }else{
        $arr = $redis->get($keys);
        $arr=json_decode($arr,true);
    }
    return  $arr;
}
//====================  应用  ==================================
/*
 *清除所有缓存
 */
function fulshall($keys)
{
    \Cache::forget($keys);
}







?>