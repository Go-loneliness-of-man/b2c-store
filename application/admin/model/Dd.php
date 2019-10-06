<?php
namespace app\admin\model;     //命名空间

use think\Model;               //引用公共模型类
use \think\Db;

class Dd extends Model{       //声明模型类
  
  public $table = 'dd';
  
  public $connection = [
    'type' => 'mysql',
    'hostname' => 'store.com',
    'database' => 'DDTJ',
    'username' => 'root',
    'password' => '123',
    'charset' => 'utf8',
    'prefix' => '',
    'debug' => true
  ];

  //检测库、表是否存在，不存在则创建
  private function jc(){
    \App\Admin\Common\Cs::dt($this->connection['database'],$this->table,'create table dd(id int primary key auto_increment,uid int,sid varchar(100),count varchar(100),ms varchar(1000),kd char(40),kddh char(50),phone char(60),price char(50),prices int,zf char(10),zfstate int,mailstate int,state int,mailto varchar(300),time datetime,bz varchar(300),pl varchar(900),pltime datetime,star int)');
  }
  /*
  'create table dd(
      id int primary key auto_increment,
      uid int,
      sid varchar(100),
      count varchar(100),
      ms varchar(1000),
      kd char(40),
      kddh char(50),
      phone char(60),
      price char(50),
      prices int,
      zf char(10),
      zfstate int,
      mailstate int,
      state int,
      mailto varchar(300),
      time datetime,
      bz varchar(300),
      pl varchar(900),
      pltime datetime,
      star int)'
  */
  
  public function sech($begin, $count){
    $this->jc();
    return self::query('select * from ddtj.dd order by time desc limit '.$begin.','.$count);
  }

  public function dfhSech(){
    $this->jc();
    return self::query('select * from ddtj.dd where zfstate=1 and mailstate=0 order by time desc');
  }
}
?>
































