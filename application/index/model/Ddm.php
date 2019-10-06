<?php
namespace app\index\model;     //命名空间

use think\Model;               //引用公共模型类
use \think\Db;
use \app\index\model\User;
use \app\index\model\Tj;

class Ddm extends Model{       //声明模型类
  
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
    \App\Index\Common\Cs::dt($this->connection['database'],$this->table,'create table dd(id int primary key auto_increment,uid int,sid varchar(100),count varchar(100),ms varchar(1000),kd char(40),kddh char(50),phone char(60),price char(50),prices int,zf char(10),zfstate int,mailstate int,state int,mailto varchar(300),time datetime,bz varchar(300),pl varchar(900),pltime datetime,star int)');
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
  
  //新增订单
  public function add($data){
    $this->jc();
    $u = User::get(['mail' => $_SESSION['mail']]);

    $v = ['id' => NULL];
    $v['uid'] = $u->id;
    $v['sid'] = $data->sid;
    $v['count'] = $data->count;
    $v['ms'] = $data->ms;
    $v['kd'] = '未填写';
    $v['kddh'] = '未填写';
    $v['price'] = $data->price;
    $v['prices'] = $data->prices;
    $v['zf'] = $data->zf;

    //支付状态
    $v['zfstate'] = $data->zfstate;

    //发货状态
    $v['mailstate'] = 0;
    $v['state'] = 0;

    //收货地址
    if($data->addr == 'null')   $v['mailto'] = $u->adrs;
    else  $v['mailto'] = $data->addr;

    //收货人手机号
    if($data->phone == 'null')   $v['phone'] = $u->phone;
    else  $v['phone'] = $data->phone;

    $v['time'] = date('Y-m-d H:i:s');
    $v['bz'] = $data->bz;
    $v['pl'] = '未评论';
    $v['pltime'] = NULL;
    $v['star'] = '0';

    $model = new Tj();
    $model->up('count', 1);
    self::create($v);
  }
}
?>
































