<?php
namespace App\Admin\controller;

use \think\Db;

class Fenclass extends \think\Controller
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

    //拉取某个商品类下的所有商品
    public function getSp()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $re = Db::table('s')->where(['pid' => $_GET['id'], 'type' => 0])->select();  //查询商品
        $s = '';                                        //准备拼接
        foreach($re as $v) {                            //拼接字符串
            $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li>'.$v['name'].'</li></ul>';
        }
        return $s;
    }

    //给一个类添加一个商品到其推荐中
    public function addRecom()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','recom','create table recom(id int primary key,sid varchar(1000))');
        $sp = Db::table('s')->where(['id' => $_REQUEST['sid']])->select();     //查询商品
        $re = Db::table('recom')->where(['id' => $sp[0]['pid']])->select();    //查询商品类
        if(isset($re[0])){                              //该记录已存在
            if($re[0]['sid'] != '')
                $re[0]['sid'] = $re[0]['sid'].','.$_REQUEST['sid'];
            else
                $re[0]['sid'] = $re[0]['sid'].$_REQUEST['sid'];
            Db::table('recom')->where(['id' => $sp[0]['pid']])->update(['sid' => $re[0]['sid']]); //更新
        }
        else {
            Db::table('recom')->insert(['id' => $sp[0]['pid'], 'sid' => $_REQUEST['sid']]); //插入记录
        }
        return '<ul data-id="'.$sp[0]['id'].'"><li>'.$sp[0]['id'].'</li><li>'.$sp[0]['name'].'</li></ul>';
    }

    //查找某个类下的所有推荐，拼接为 html 返回
    public function getRecom()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        $html = '';
        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','recom','create table recom(id int primary key,sid varchar(1000))');
        $re = Db::table('recom')->where(['id' => $_REQUEST['id']])->select();  //查询商品类
        if(isset($re[0])){                              //判断是否存在
            $re = $re[0];
            $re['sid'] = explode(',',$re['sid']);       //分割为字符串
            foreach($re['sid'] as $v){                  //拼接 html
                $sp = Db::table('s')->where(['id' => $v])->select();  //查询商品
                $sp = $sp[0];
                $html = $html.'<ul data-id="'.$v.'"><li>'.$sp['id'].'</li><li>'.$sp['name'].'</li></ul>';
            }
        }
        return $html;
    }

    //删除某个类下的某个推荐商品
    public function delRecom()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        $sid = '';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','recom','create table recom(id int primary key,sid varchar(1000))');
        $sp = Db::table('s')->where(['id' => $_REQUEST['sid']])->select();   //查询商品
        $re = Db::table('recom')->where(['id' => $sp[0]['pid']])->select();  //查询商品类
        $re = $re[0];
        $re['sid'] = explode(',', $re['sid']);          //分割为数组
        foreach($re['sid'] as $k => $v)                 //遍历 sid
            if($v == $_REQUEST['sid']) {                //若相等，删除
                unset($re['sid'][$k]);
                break;
            }
        foreach($re['sid'] as $v)                       //遍历 sid，拼接为字符串
            if($sid == '')  $sid = $sid.$v;
            else $sid = $sid.','.$v;
        Db::table('recom')->where(['id' => $sp[0]['pid']])->update(['sid' => $sid]);  //更新
        return 'OK';
    }
}





