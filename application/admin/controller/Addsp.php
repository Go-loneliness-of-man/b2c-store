<?php
namespace App\Admin\controller;

use \think\Db;

class AddSp extends \think\Controller
{
    //拉取所有一级商品类
    public function getOneClass()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';
        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $re = Db::table('s')->where(['level' => 0, 'type' => 1])->select();  //查询所有一级商品类
        $s = '';                                        //准备拼接
        foreach($re as $v)                              //拼接字符串
            $s = $s.'<li data-id="'.$v['id'].'">'.$v['name'].'</li>';
        return $s;
    }

    //拉取某个商品类下的所有商品类
    public function getSpClass()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';
        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $re = Db::table('s')->where(['pid' => $_GET['id'], 'type' => 1])->select();  //查询
        $s = '';                                        //准备拼接
        foreach($re as $v)                              //拼接字符串
            $s = $s.'<li data-id="'.$v['id'].'">'.$v['name'].'</li>';
        return $s;
    }

    //添加一个商品类
    public function AddSpClass()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';
        $v = array('id'=>null);
        foreach($_POST as $key => $val)
            $v[$key] = $val;
            
        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        Db::table('s')->insert($v);                     //添加一个商品类
        $re = Db::table('s')->where(['name' => $v['name']])->select(); //查询
        $s = '';                                        //准备拼接
        foreach($re[0] as $key => $val)                 //拼接字符串
            $s = $s.$key.'='.$val.' ';
        return 'OK'.$s;
    }

    //添加一个商品
    public function AddSps()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';
        $v = array('id'=>null);
        $kv = [];   $kv[0] = [];   $kv[1] = [];         //准备生成 ex 字段
        $i = 0;
        $_POST['p'] = json_decode($_POST['p']);         //还原 json
        $_POST['ex'] = json_decode($_POST['ex']);
        $x = 'text';
        foreach($_POST['p'] as $key => $val)            //赋值 level、name、path、pid、type 五个基础字段
            $v[$key] = $val;
        /*
        ex 格式，两个数组 keys、vals，keys 存储额外属性名，vals 每个元素依次对应 keys，二者均是 JSON 格式。
        在将商品插入到表中后，获取商品 id 处理文件，将文件移动到 public/static/iva 目录下，以“id_属性的 key_序号（序号要由用户在上传时手动命名，格式为 '1_xxx'）”命名，并将文件名存储到 ex 中。
        还有商品涉及的额外属性（根据 id），要将商品 id 添加到其涉及的额外属性的 sid 字段中。
        */
        foreach($_POST['ex'] as $key => $val) {         //生成 ex 字段
            if($val[1] == 'file'){                      //是文件，移动文件到指定目录下，再将文件路径存储到对应位置
                $kv[0][$i] = $key;                      //创建 key
                $kv[1][$i++] = 'file';                  //标记 file
            }
            else{                                       //不是文件
                $kv[0][$i] = $key;                      //创建 key
                $_POST[$key] = explode(';;;;;', $_POST[$key]);  //切割属性值
                $kv[1][$i++] = $_POST[$key];            //存储 val
            }
        }
        $v['ex'] = json_encode($kv);

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        Db::table('s')->insert($v);                     //将商品记录插入表内
        $re = Db::table('s')->where(['name' => $v['name'], 'path' => $v['path'],'ex' => $v['ex']])->select(); //根据 name、path、ex 将商品 id 取出
        $id = $re[0]['id'];                             //获取商品 id

        //处理文件和 sid，保存文件并更新 ex 字段，将该商品的 id 添加到其涉及的属性的 sid 列表内
        for($i = 0, $c = count($kv[0]); $i < $c; $i++){
            if(is_string($kv[1][$i])) {                 //判断文件
                $key = explode('[]',$kv[0][$i])[0];
                $kv[1][$i] = [];                        //准备拼接路径字符串
                for($j = 0, $c2 = count($_FILES[$key]['name']); $j < $c2; $j++){
                    $kv[1][$i][$j] = ROOT_PATH.'public\static\iva\\'.$id.'_'.$key.'_'.$_FILES[$key]['name'][$j];    //保存时的服务器路径
                    $src = '/static/iva/'.$id.'_'.$key.'_'.$_FILES[$key]['name'][$j];                               //读取时的相对路径
                    move_uploaded_file($_FILES[$key]['tmp_name'][$j], $kv[1][$i][$j]);
                    $kv[1][$i][$j] = $src;
                }
            }
            $extra_id = (get_object_vars($_POST['ex'])[$kv[0][$i]])[0];        //获取属性 id
            $extra = Db::table('extra')->where(['id' => $extra_id])->select(); //根据属性 id 取出记录
            $extra_sid = $extra[0]['sid'];              //获取属性 id 列表
            if(!$extra_sid) $extra_sid = $id;           //拼接 id 列表
            else  $extra_sid = $extra_sid.','.$id;
            Db::table('extra')->where(['id' => $extra_id])->update(['sid' => $extra_sid]);//更新属性 sid
        }
        Db::table('s')->where(['id' => $id])->update(['ex' => json_encode($kv)]);    //更新 ex 字段
        return 'OK';
    }

    //获取所有额外属性的 id、k、中文名、是否常用
    public function getExtra()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','extra','create table extra(id int primary key auto_increment,k varchar(100) unique key,name varchar(100),often char(4),html text,css text, bz varchar(1000),sid text)');
        $re = Db::table('extra')->select();             //查询
        $s = array();                                   //准备数据
        $i = 0;
        foreach($re as $v){                             //生成关联数组，每个元素代表一个字段
            $s[$i]['id'] = $v['id'];
            $s[$i]['k'] = $v['k'];
            $s[$i]['often'] = $v['often'];
            $s[$i]['bz'] = $v['bz'];
            $s[$i++]['name'] = $v['name'];
        }
        return json_encode($s);                         //转为 json 格式传输
    }
}





