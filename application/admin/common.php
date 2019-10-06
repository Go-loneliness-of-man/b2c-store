<?php
namespace App\Admin\Common;

use \think\Db;

//测试类
class Cs{

  private static $u = 'root';
  private static $p = '123';

  //测试对应的数据库、表是否存在，若不存在，创建，参数是数据库名、表名、表的创建语句
  public static function dt($db, $table, $sql){
    $link = new \PDO('mysql:host=store.com;port=3306;charset=utf8', self::$u, self::$p);
    $re = $link->prepare('use '.$db);
    if(!$re->execute()){                              //检测数据库
      $re = $link->prepare('create database '.$db);   //创建数据库
      $re->execute();
    }
    $re = $link->prepare('use '.$db);                 //选择数据库
    $re->execute();
    $re = $link->prepare('show tables');              //获取数据库下所有表名
    $re->execute();
    $tables = $re->fetchAll();
    foreach($tables as $name)                         //检测表名
      if($name == $table)  return;                    //存在，结束
    $re = $link->prepare($sql);                       //不存在，创建表
    $re->execute();
  }
}

//权限类，jur 用于定义角色权限，其 key 为角色名，val 是字符串数组，每个字符串（即权限名）对应一种权限。p 接收角色、权限名，判断该角色是否具有该权限，返回 bool 值。
class Qx{
  
  private static $jur = [
    'super' => [
      'slook',      //商品查看
      'scud',       //商品增、删、改
      'dlook',      //订单查看
      'dcud',       //订单增、删、改
      'cduser',     //增、删、改、查会员账户
      'cdshop',     //增、删、改、查商城管理员账户
      'cdsuper',    //增、删、改、查超级管理员账户
    ],
    'shoper' => [
      'slook',      //商品查看
      'scud',       //商品增、删、改
      'dlook',      //订单查看
      'cduser',     //增、删、改、查会员账户
    ]
  ];

  //接收角色、权限名，返回 布尔值
  public static function p($name, $qx){
    \App\Admin\Common\Cs::dt('u','cz','create table cz(id int primary key auto_increment, name varchar(60), time datetime, cz char(30), ip char(30))');
    Db::execute('insert into u.cz values(NULL, \''.$_SESSION['name'].'\', \''.date('Y-m-d H:i:s').'\', \''.$qx.'\', \''.$_SERVER['REMOTE_ADDR'].'\')');

    foreach(self::$jur[$name] as $v)
      if($v == $qx) return true;
    return false;
  }
}

//判断该商品是否在推荐列表内
function pdtj($pid, $id){
  $re = Db::table('recom')->where(['id' => $pid])->select();  //获取数据
  $re = explode(',', $re[0]['sid']);
  foreach($re as $v)
    if($v == $id)
      return '是';
  return '否';
}















