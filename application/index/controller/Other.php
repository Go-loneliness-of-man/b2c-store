<?php
namespace App\Index\Controller;

use \think\Db;
use app\index\model\Sp;
use app\index\model\Ddm;
use app\index\model\User;

class Other extends \think\Controller
{
  //生成多个商品类
  public function getSpClass()
  {
    $model = new sp();
    $idlb = explode(',', $_REQUEST['idlb']);
    $s = '';
    foreach($idlb as $id) {                           //遍历 id 列表，循环生成商品类
      $sp = $model->getSp($id);                       //获取生成当前商品类所需的数据
      $s = $s.'<div class="sp_class sp_class'.$sp['spClass']['id'].'"><div class="top"><h2>'.$sp['spClass']['name'].'</h2>';

      if(isset($sp['child'])) {                       //判断是否生成二级分类
        $s = $s.'<ul>';
        foreach($sp['child'] as $v)                   //生成二级分类
          $s = $s.'<li>'.$v['name'].'</li>';
        $s = $s.'</ul>';
      }

      $s = $s.'</div>';                               //闭合 div.top

      $s = $s.'<div class="aside">';
      foreach($sp['spClass']['ex'] as $v)             //生成侧栏推荐图
        $s = $s.'<img class="a_src" data-a_src="http://store.com/index/index/sp?id='.explode('_', $v)[2].'" src="'.$v.'">';
      $s = $s.'</div>';

      if(isset($sp['child']))                         //判断是否存在二级分类
        foreach($sp as $k => $v) {                    //遍历商品类
          if($k === 'spClass' || $k === 'child')
            continue;
          $s = $s.'<div class="main">';
          $c = 0;
          foreach($v as $v2) {                        //遍历一个二级商品类的商品，生成二级商品
            $v2->ex = json_decode($v2->ex);
            $s = $s.'<figure><img class="a_src" data-a_src="http://store.com/index/index/sp?id='.$v2->id.'" src="'.$v2->ex[1][array_flip($v2->ex[0])['photo[]']][0].'"><figcaption><div class="name">'.$v2->name.'</div><div class="price">￥'.$v2->ex[1][array_flip($v2->ex[0])['price']][0].'</div></figcaption></figure>';
            $c++;
            if($c >= 7) break;
          }
          $s = $s.'<div class="llgd a_src" data-a_src="http://store.com/index/index/spClass?id='.$v[0]->pid.'"><div class="name">浏览更多</div><div class="svg"><svg t="1561268366035" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2065" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M514 912c-219.9 0-398.8-178.9-398.8-398.9 0-219.9 178.9-398.8 398.8-398.8s398.8 178.9 398.8 398.8c0 220-178.9 398.9-398.8 398.9z m0-701.5c-166.9 0-302.7 135.8-302.7 302.7S347.1 815.9 514 815.9s302.7-135.8 302.7-302.7S680.9 210.5 514 210.5z" fill="#8a8a8a" p-id="2066"></path><path d="M746.1 471.6L582 307.5c-22.9-22.9-60.2-22.9-83.1 0-22.9 22.9-22.9 60.2 0 83.1l63.8 63.8H334c-32.5 0-58.8 26.3-58.8 58.8S301.5 572 334 572h228.7l-63.8 63.8c-11.5 11.5-17.2 26.5-17.2 41.5s5.7 30.1 17.2 41.5c22.9 22.9 60.2 22.9 83.1 0l164.1-164.1c22.9-22.9 22.9-60.1 0-83.1z" fill="#8a8a8a" p-id="2067"></path></svg></div></div></div>';
        }
      else{
        $s = $s.'<div class="main">';
        $c = 0;
        foreach($sp as $v){                           //生成子类商品
          $v['ex'] = json_decode($v['ex']);
          $s = $s.'<figure><img class="a_src" data-a_src="http://store.com/index/index/sp?id='.$v['id'].'" src="'.$v['ex'][1][array_flip($v['ex'][0])['photo[]']][0].'"><figcaption><div class="name">'.$v['name'].'</div><div class="price">￥'.$v['ex'][1][array_flip($v['ex'][0])['price']][0].'</div></figcaption></figure>';
          $c++;
          if($c >= 7) break;
        }
        $s = $s.'<div class="llgd a_src" data-a_src="http://store.com/index/index/spClass?id='.$sp['spClass']['id'].'"><div class="name">浏览更多</div><div class="svg"><svg t="1561268366035" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2065" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M514 912c-219.9 0-398.8-178.9-398.8-398.9 0-219.9 178.9-398.8 398.8-398.8s398.8 178.9 398.8 398.8c0 220-178.9 398.9-398.8 398.9z m0-701.5c-166.9 0-302.7 135.8-302.7 302.7S347.1 815.9 514 815.9s302.7-135.8 302.7-302.7S680.9 210.5 514 210.5z" fill="#8a8a8a" p-id="2066"></path><path d="M746.1 471.6L582 307.5c-22.9-22.9-60.2-22.9-83.1 0-22.9 22.9-22.9 60.2 0 83.1l63.8 63.8H334c-32.5 0-58.8 26.3-58.8 58.8S301.5 572 334 572h228.7l-63.8 63.8c-11.5 11.5-17.2 26.5-17.2 41.5s5.7 30.1 17.2 41.5c22.9 22.9 60.2 22.9 83.1 0l164.1-164.1c22.9-22.9 22.9-60.1 0-83.1z" fill="#8a8a8a" p-id="2067"></path></svg></div></div></div>';
      }

      $s = $s.'</div>';                               //闭合 div.sp_class
    }
    return $s;
  }

  //生成“为你推荐” html
  public function getWntj() {
    $model = new sp();
    $s = '';
    $idlb = explode(',', $_REQUEST['idlb']);
    foreach($idlb as $id) {                           //遍历 id 列表，循环生成推荐商品
      $sp = $model->getTjSp($id);                     //获取推荐商品数据
      foreach($sp as $v) {                            //生成 html
        $v->ex = json_decode($v->ex);
        $good = Ddm::execute('select * from ddtj.dd where sid like \'%'.$v->id.'%\' and star>3');  //好评订单数
        $s = $s.'<figure><div class="outer a_src" data-a_src="http://store.com/index/index/sp?id='.$v->id.'"><img src="'.$v->ex[1][array_flip($v->ex[0])['photo[]']][0].'"></div><figcaption><div class="name">'.$v->name.'</div><div class="price">￥'.$v->ex[1][array_flip($v->ex[0])['price']][0].'</div><div class="good">'.$good.' 人好评</div></figcaption></figure>';
      }
    }
    return $s;
  }

  //生成“热点产品” html
  public function getHot() {
    $model = new sp();
    $s = '';
    $sp = $model->hot();
    foreach($sp as $v){                               //获取热点商品随机一个五星评论进行展示
      $v->ex = json_decode($v->ex);
      $dd = Ddm::query('select * from ddtj.dd where sid like \'%'.$v->id.'%\' and star=5');
      shuffle($dd);
      $dd = $dd[0];
      $u = User::get($dd['uid']);
      $s = $s.'<figure><img src="'.$v->ex[1][array_flip($v->ex[0])['photo[]']][0].'" class="a_src" data-a_src="http://store.com/index/index/sp?id='.$v->id.'"><figcaption><div class="nr">'.$dd['pl'].'</div><div class="hot_user">来自于 '.$u->name.' 的评价</div><div class="hot_name"><div class="name">'.$v->name.'</div> | <div class="price">'.$v->ex[1][array_flip($v->ex[0])['price']][0].' 元</div></div></figcaption></figure>';
    }
    return $s;
  }

}


























