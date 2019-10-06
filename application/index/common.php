<?php
namespace App\Index\Common;

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






















