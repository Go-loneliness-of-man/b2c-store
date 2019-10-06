<?php
namespace app\admin\model;     //命名空间

use think\Model;               //引用公共模型类
use \think\Db;

class Admin extends Model{     //声明模型类
  
  public $table = 'admin';
  
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
    \App\Admin\Common\Cs::dt($this->connection['database'],$this->table,'create table admin(id int primary key auto_increment, name varchar(100), pwd varchar(100), type varchar(50))');
    \App\Admin\Common\Cs::dt($this->connection['database'],'login','create table login(id int primary key, name varchar(100), time datetime, ip char(50))');
    \App\Admin\Common\Cs::dt($this->connection['database'],'cz','create table cz(id int primary key, name varchar(100), time datetime, cz varchar(50), ip char(50))');
  }

  //增
  public function add()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cdsuper'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $v['name'] = $_REQUEST['name'];
    $v['pwd'] = $_REQUEST['pwd'];
    $v['type'] = $_REQUEST['type'];
    self::create($v);
    return 'OK';
  }

  //删
  public function del()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cdsuper'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    self::destroy($_REQUEST['id']);
    return 'OK';
  }

  //改
  public function re()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cdsuper'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $hash = array('昵称' => 'name', '密码' => 'pwd', '角色' => 'type');
    self::where('id', $_REQUEST['id'])->update([$hash[$_REQUEST['k']] => $_REQUEST['v']]);
    return 'OK';
  }

  //查
  public function sech()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cdsuper'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $re = self::all();
    $s = '';
    foreach($re as $v)
      $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li>'.$v['name'].'</li><li>'.$v['pwd'].'</li><li>'.$v['type'].'</li><li><svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li></ul>';
    return $s;
  }
}
?>