<?php
namespace App\Admin\controller;

use \think\Db;

class Extra extends \think\Controller
{
    //向额外字段表插入一条记录
    public function addExtra()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','extra','create table extra(id int primary key auto_increment,k varchar(100) unique key,name varchar(100),often char(4),html text,css text, bz varchar(1000),sid text)');
        $v = array('id' => NULL, 'sid' => '');          //准备记录数据
        foreach($_POST as $key => $val)                 //生成关联数组
            $v[$key] = $val;
        Db::table('extra')->insert($v);                 //插入记录
        $re = Db::table('extra')->where(['k' => $v['k']])->select(); //查询
        $s = '';                                        //准备拼接
        foreach($re[0] as $key => $val)                 //拼接字符串
            $s = $s.$key.'='.$val.' ';
        return 'OK，'.$s;
    }

    //更新记录的某个字段
    public function reExtra()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','extra','create table extra(id int primary key auto_increment,k varchar(100) unique key,name varchar(100),often char(4),html text,css text, bz varchar(1000),sid text)');
        Db::table('extra')->where(['id' => $_POST['id']])->update([$_POST['key'] => $_POST['val']]);    //修改记录
        $re = Db::table('extra')->where(['id' => $_POST['id']])->select(); //查询
        $s = '';                                        //准备拼接
        foreach($re[0] as $key => $val)                 //拼接字符串
            $s = $s.$key.'='.$val.' ';
        return 'OK，'.$s;
    }

    //展示额外字段列表
    public function showExtra()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','extra','create table extra(id int primary key auto_increment,k varchar(100) unique key,name varchar(100),often char(4),html text,css text, bz varchar(1000),sid text)');
        $re = Db::table('extra')->select();             //取出所有记录
        $s = '';                                        //准备拼接
        foreach($re as $v)                              //生成 html
            $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li class="edt">'.$v['k'].'</li><li class="edt">'.$v['name'].'</li><li class="edt">'.$v['often'].'</li><li class="edt">'.$v['html'].'</li><li class="edt">'.$v['css'].'</li><li class="edt">'.$v['bz'].'</li><li>'.$v['sid'].'</li><li class="del"><svg t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li></ul>';
        if($s=='')   $s = '没有记录';
        return $s;
    }

    //删除一个额外字段
    public function delExtra()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','extra','create table extra(id int primary key auto_increment,k varchar(100) unique key,name varchar(100),often char(4),html text,css text, bz varchar(1000),sid text)');
        Db::table('extra')->delete(['id' => $_GET['id']]);  //删除记录
        return 'OK，id 为 '.$_GET['id'].' 的额外字段已删除';
    }
}





