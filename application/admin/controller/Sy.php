<?php
namespace App\Admin\controller;

use \think\Db;
use \app\admin\model\Tjm;

class Sy extends \think\Controller
{
  //“操作日志”数据
  public function getRz(){
    \App\Admin\Common\Cs::dt('u','cz','create table cz(id int primary key auto_increment, name varchar(60), time datetime, cz char(30), ip char(30))');

    $s = '';
    $qx = ['slook' => '查看商品', 'scud'  => '增删改商品','dlook' => '查看订单','dcud'  => '增删改订单','cduser' => '增删改查会员账户','cdshop' => '增删改查商城管理员账户','cdsuper' => '增删改查超级管理员账户'];
    $max = 200;                               //储存上限
    $data = Db::query('select * from u.cz order by id desc limit '.$max);
    if(!empty($data))
      foreach($data as $v)
        $s = $s.'<ul><li>'.$v['name'].'</li><li>'.$v['time'].'</li><li>'.$qx[$v['cz']].'</li><li>'.$v['ip'].'</li></ul>';
    if(Db::execute('select * from u.cz') > $max)
      Db::execute('drop table u.cz');
    return $s;
  }

  //“最近登录”数据
  public function getLogin(){
    \App\Admin\Common\Cs::dt('u','login','create table login(id int primary key auto_increment, name varchar(60), time datetime, ip char(30))');

    $s = '';
    $max = 100;                            //储存上限
    $data = Db::query('select * from u.login order by id desc limit '.$max);
    if(!empty($data))
      foreach($data as $v)
        $s = $s.'<ul><li>'.$v['name'].'</li><li>'.$v['time'].'</li><li>'.$v['ip'].'</li></ul>';
    if(Db::execute('select * from u.login') > $max)
      Db::execute('drop table u.login');
    return $s;
  }

  //“紧急待办”数据
  public function getJjdb(){
    return Db::execute('select * from ddtj.dd where zfstate=0').','.Db::execute('select * from ddtj.dd where zfstate=1 and mailstate=0');
  }

  //“订单统计”数据
  public function getDdTj(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $res = [];
    $res[0] = [];
    $res[1] = [];
    $i = 0;
    foreach($data as $v){
      $res[0][$i] = $v['count'];
      $res[1][$i] = $v['csucs'];
      $i++;
    }
    return json_encode($res);
  }

  //“用户统计”数据
  public function getUhTj(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $res = [];
    $i = 0;
    foreach($data as $v){
      $res[$i] = $v['ucount'];
      $i++;
    }
    return json_encode($res);
  }
}





