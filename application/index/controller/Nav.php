<?php
namespace App\Index\Controller;

use \think\Db;
use app\index\model\Sp;

class Nav extends \think\Controller
{
    //返回顶部导航栏 html
    public function getNavTop()
    {
        $model = new sp();
        $sp = $model->getNavTop();
        $s = '';
        foreach($sp as $v)
            $s = $s.'<li data-id="'.$v->id.'">'.$v->name.'</li>';
        return $s;
    }

    //顶部推荐商品 html
    public function topSp(){
        $model = new Sp();
        $sp = $model->getTjSp($_REQUEST['id']);                     //获取用于展示的推荐商品
        shuffle($sp);                                               //打乱顺序
        $s = '';
        $count = 0;
        foreach($sp as $v){
            $v->ex = json_decode($v->ex);
            $price = $v->ex[1][array_flip($v->ex[0])['price']][0];
            $src = $v->ex[1][array_flip($v->ex[0])['photo[]']][0];
            $s = $s.'<figure class="a_src" data-a_src="http://store.com/index/index/sp?id='.$v->id.'"><img src="'.$src.'"><figcaption><div class="name">'.$v->name.'</div><div class="price">￥'.$price.'</div></figcaption></figure>';
            $count++;
            if($count >= 7)  break;
        }
        return $s;
    }
}