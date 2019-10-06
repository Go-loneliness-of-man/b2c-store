<?php
namespace app\admin\model;     //命名空间

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

  //增
  public function add()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $v = [];
    $v['name'] = $_REQUEST['name'];
    $v['mail'] = $_REQUEST['mail'];
    $v['pwd'] = $_REQUEST['pwd'];
    $v['adrs'] = $_REQUEST['adrs'];
    if(isset($_REQUEST['phone']))  $v['phone'] = $_REQUEST['phone'];
    else  $v['phone'] = 'null';
    $v['sex'] = $_REQUEST['sex'];
    $v['time'] = date("Y-m-d H:i:s");
    self::create($v);                                                       //插入数据
    $result = self::all($v);                                                //获取记录
    move_uploaded_file($_FILES['head']['tmp_name'], ROOT_PATH.'public\static\iva\\user_'.$result[0]['id'].'_head_'.$_FILES['head']['name']);  //保存图片
    $v['head'] = '\static\iva\\user_'.$result[0]['id'].'_head_'.$_FILES['head']['name'];  //读取时的相对路径
    self::where('id', $result[0]['id'])->update(['head' => $v['head']]);    //更新路径到记录中
    return 'OK';
  }

  //删
  public function del()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $result = self::get($_REQUEST['id']);                                   //获取记录
    if(!($result['head'] == '\static\iva\head.jpg'))                        //默认头像，不删除
      unlink(ROOT_PATH.'public'.$result['head']);                           //删除头像
    self::destroy($_REQUEST['id']);                                         //删除记录
    return 'OK';
  }

  //改
  public function re()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $hash = array('昵称' => 'name', '密码' => 'pwd','邮箱' => 'mail', '地址' => 'adrs', '手机号' => 'phone', '性别' => 'sex', '头像' => 'head');
    if($_REQUEST['k'] == '头像') {
      $result = self::get($_REQUEST['id']);
      unlink(ROOT_PATH.'public'.$result['head']);                           //删除原头像
      move_uploaded_file($_FILES['head']['tmp_name'], ROOT_PATH.'public\static\iva\\user_'.$result['id'].'_head_'.$_FILES['head']['name']);  //保存图片
      $src = '\static\iva\\user_'.$result['id'].'_head_'.$_FILES['head']['name'];  //读取时的相对路径
      self::where('id', $_REQUEST['id'])->update(['head' => $src]);
    }
    else
      self::where('id', $_REQUEST['id'])->update([$hash[$_REQUEST['k']] => $_REQUEST['v']]);
    return 'OK';
  }

  //查
  public function sech()
  {
    if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
      return '当前账户没有执行此操作的权限';
    $this->jc();
    $re = self::all();
    $s = '';
    foreach($re as $v)
      $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li><img src="'.$v['head'].'"></li><li>'.$v['name'].'</li><li>'.$v['pwd'].'</li><li>'.$v['mail'].'</li><li>'.$v['adrs'].'</li><li>'.$v['phone'].'</li><li>'.$v['sex'].'</li><li>'.$v['time'].'</li><li><svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li></ul>';
    return $s;
  }
}
?>

