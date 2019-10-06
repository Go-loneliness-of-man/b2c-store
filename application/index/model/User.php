<?php
namespace app\index\model;     //命名空间

use think\Model;               //引用公共模型类
use \think\Db;

class User extends Model{     //声明模型类
  
  public $table = 'user';
  
  public $connection = [
    'type' => 'mysql',
    'hostname' => 'store.com',
    'database' => 'U',
    'username' => 'root',
    'password' => '123',
    'charset' => 'utf8',
    'prefix' => '',
    'debug' => true
  ];

  //检测库、表是否存在，不存在则创建
  private function jc(){
    \App\Admin\Common\Cs::dt($this->connection['database'],$this->table,'create table user(id int primary key auto_increment, name varchar(100), pwd varchar(100), mail char(30), adrs text, phone char(20), sex char(8), head text, time datetime)');
  }

  //改
  public function re()
  {
    if(isset($_FILES['head'])) {
      $result = self::get(['mail' => $_SESSION['mail']]);
      if($result['head'] != '\static\iva\head.jpg')                           //默认头像不删
        unlink(ROOT_PATH.'public'.$result['head']);                           //删除原头像
      move_uploaded_file($_FILES['head']['tmp_name'], ROOT_PATH.'public\static\iva\\user_'.$result['id'].'_head_'.$_FILES['head']['name']);  //保存图片
      $src = '\static\iva\\user_'.$result['id'].'_head_'.$_FILES['head']['name'];//读取时的相对路径
      self::where(['mail' => $_SESSION['mail']])->update(['head' => $src]);
      return $src;
    }
    else{
      $v = [];
      $v['name'] = $_REQUEST['name'];
      $v['pwd'] = $_REQUEST['pwd'];
      $v['adrs'] = $_REQUEST['adrs'];
      $v['phone'] = $_REQUEST['phone'];
      $v['sex'] = $_REQUEST['sex'];
      self::where(['mail' => $_SESSION['mail']])->update($v);

      //更新 session 信息
      $_SESSION['name'] = $v['name'];
      return 'OK';
    }
  }
}
?>

