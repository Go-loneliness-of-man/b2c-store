<?php
namespace App\Admin\controller;

use \think\Db;
use \app\admin\model\Tjm;

class Tj extends \think\Controller
{
  //“营业额”图表数据
  public function getMoney(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $res = [];
    $i = 0;
    foreach($data as $v){
      $res[$i] = $v['money'];
      $i++;
    }
    return json_encode($res);
  }

  //“营业额”列表 html
  public function getMoneyHtml(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $s = '';
    $i = 0;
    foreach($data as $v)
      $s = $s.'<ul><li>'.(explode(' ', $v['time']))[0].'</li><li>'.$v['money'].'</li></ul>';
    return $s;
  }

  //“订单量”图表数据
  public function getCount(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $res = [];
    $i = 0;
    foreach($data as $v){
      $res[$i] = $v['count'];
      $i++;
    }
    return json_encode($res);
  }

  //“订单量”列表 html
  public function getCountHtml(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $s = '';
    $i = 0;
    foreach($data as $v)
      $s = $s.'<ul><li>'.(explode(' ', $v['time']))[0].'</li><li>'.$v['count'].'</li></ul>';
    return $s;
  }

  //“成交量”图表数据
  public function getCsucs(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $res = [];
    $i = 0;
    foreach($data as $v){
      $res[$i] = $v['csucs'];
      $i++;
    }
    return json_encode($res);
  }

  //“成交量”列表 html
  public function getCsucsHtml(){
    \App\admin\Common\Cs::dt('ddtj', 'tj', 'create table ddtj.tj(time datetime primary key, money int, count int, csucs int, ucount int)');

    $model = new Tjm();
    $data = $model->getMonth();
    $s = '';
    $i = 0;
    foreach($data as $v)
      $s = $s.'<ul><li>'.(explode(' ', $v['time']))[0].'</li><li>'.$v['csucs'].'</li></ul>';
    return $s;
  }
}





