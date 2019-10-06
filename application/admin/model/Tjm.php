<?php
namespace app\admin\model;     //命名空间

use think\Model;               //引用公共模型类

class Tjm extends Model{       //声明模型类
  
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
    \App\admin\Common\Cs::dt($this->connection['database'], $this->table, 'create table '.$this->table.'(time datetime primary key, money int, count int, csucs int, ucount int)');
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

  //获取本月数据
  public function getMonth()
  {
    $this->jc();

    $data = self::query('select * from ddtj.tj where time like \''.date('Y-m').'%\' order by time');
    $c = count($data);
    $days = [31,30,31,30,31,30,31,31,30,31,30,31];
    $exist = [];
    $data2 = [];

    //将存在记录的日期映射到数组的 key 上
    for($i = 0; $i < $c; $i++)
      $exist[$i] = explode('-',explode(' ', $data[$i]['time'])[0])[2];
    $exist = array_flip($exist);

    //补全数据
    for($i = $j = 0; $i < $days[date('m') - 1]; $i++)
      if(!isset($exist[$i + 1])) {
        $data2[$i]['time'] = date('Y-m-').($i + 1).' 00:00:00';
        $data2[$i]['money'] = 0;
        $data2[$i]['count'] = 0;
        $data2[$i]['csucs'] = 0;
        $data2[$i]['ucount'] = 0;
      }
      else
        $data2[$i] = $data[$j++];
    return $data2;
  }
}
?>

