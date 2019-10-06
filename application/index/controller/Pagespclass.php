<?php
namespace App\Index\Controller;

use \think\Db;
use \app\index\model\Sp;

class Pagespclass extends \think\Controller
{
  //返回 html
  public function getSpClass()
  {
    $model = new Sp();
    $sp = $model->getSp($_REQUEST['id']);
    $s = '';
    
    //生成商品类 html
    if(isset($sp['child']))                                   //判断商品是否存在子类
      for($i = 0, $c = count($sp['child']); $i < $c; $i++) {  //遍历子类
        $s = $s.'<div class="spList"><h2>'.$sp['child'][$i]['name'].'</h2>';
        foreach($sp[$i] as $v) {                              //遍历商品
          $v->ex = json_decode($v->ex);
          $s = $s.'<figure><div class="outer a_src" data-a_src="http://store.com/index/index/sp?id='.$v->id.'"><img src="'.$v->ex[1][array_flip($v->ex[0])['photo[]']][0].'"></div><figcaption><div class="sp_name">'.$v->name.'</div><div class="ms">'.$v->ex[1][array_flip($v->ex[0])['spms']][0].'</div><div class="price">￥ '.$v->ex[1][array_flip($v->ex[0])['price']][0].'</div></figcaption></figure>';
        }
        $s = $s.'</div>';
      }
    else
    {
      $s = $s.'<div class="spList"><h2>'.$sp['spClass']['name'].'</h2>';
      foreach($sp as $k => $v) {                              //遍历商品
        if($k == 'spClass')   continue;
        $v['ex'] = json_decode($v['ex']);
        $s = $s.'<figure><div class="outer a_src" data-a_src="http://store.com/index/index/sp?id='.$v['id'].'"><img src="'.$v['ex'][1][array_flip($v['ex'][0])['photo[]']][0].'"></div><figcaption><div class="sp_name">'.$v['name'].'</div><div class="ms">'.$v['ex'][1][array_flip($v['ex'][0])['spms']][0].'</div><div class="price">￥ '.$v['ex'][1][array_flip($v['ex'][0])['price']][0].'</div></figcaption></figure>';
      }
      $s = $s.'</div>';
    }

    return $s;
  }
}