<?php
namespace App\Index\Controller;

use \think\Db;
use app\index\model\Sp;
use app\index\model\User;

class Pagesp extends \think\Controller
{
  //返回商品信息
  public function getSpxx()
  {
    $sp = Sp::get($_REQUEST['id']);
    $sp->ex = json_decode($sp->ex);
    return json_encode($sp);
  }

  //返回商品评论
  public function getPl()
  {
    $dd = Db::query('select * from ddtj.dd where sid like \'%'.$_REQUEST['id'].'%\'');
    $s = '';
    $star = ['非常不满意', '还行', '挺好', '满意', '非常满意'];

    foreach($dd as $v){
      $u = User::get($v['uid']);
      $s = $s.'<figure><div class="top"><img src="'.$u->head.'"><div class="user">'.$u->name.'</div><div class="time">'.$v['pltime'].'</div><div class="star">'.$star[$v['star'] - 1].'</div></div><figcaption>'.$v['pl'].'</figcaption></figure>';
    }
    return $s;
  }
}