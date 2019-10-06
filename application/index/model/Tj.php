<?php
namespace app\index\model;     //命名空间

use think\Model;               //引用公共模型类

class Tj extends Model{        //声明模型类
  
  public $table = 'tj';
  
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
    \App\Index\Common\Cs::dt($this->connection['database'], $this->table, 'create table '.$this->table.'(time datetime primary key, money int, count int, csucs int, ucount int)');
  }

  //更新统计表
  public function up($k, $v)
  {
    $this->jc();

    //检测记录是否存在
    if(self::execute('select * from '.$this->connection['database'].'.'.$this->table.' where time=\''.date('Y-m-d').'\'')) {
      $data = (self::get(['time' => date('Y-m-d')]))[$k];
      $data += $v;
      self::where(['time' => date('Y-m-d')])->update([$k => $data]);
    }
    else{
      $key = ['money', 'count', 'csucs', 'ucount'];
      $value = ['time' => date('Y-m-d')];
      foreach($key as $temp)
        if($temp == $k)
          $value[$k] = $v;
        else
          $value[$temp] = 0;
      self::create($value);
    }
  }
}
?>

