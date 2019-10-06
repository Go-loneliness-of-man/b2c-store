<?php
namespace App\Index\Controller;

use \think\Db;
use app\index\model\Sp;

class Lb extends \think\Controller
{
    //返回轮播区侧栏 html
    public function getNavAside()
    {
        $model = new Sp();
        $sp = $model->getNavAside();
        $s = '';
        foreach($sp as $v)
            $s = $s.'<li data-id="'.$v->id.'">'.$v->name.'<svg t="1562080961283" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="1595" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M512 0C230.4 0 0 230.4 0 512s230.4 512 512 512 512-230.4 512-512S793.6 0 512 0z m0 964.266667C264.533333 964.266667 59.733333 759.466667 59.733333 512S264.533333 59.733333 512 59.733333 964.266667 264.533333 964.266667 512 759.466667 964.266667 512 964.266667z" fill="#bfbfbf" p-id="1596"></path><path d="M499.2 268.8c-17.066667-17.066667-42.666667-17.066667-59.733333 0s-17.066667 42.666667 0 59.733333l183.466666 183.466667-183.466666 183.466667c-17.066667 17.066667-17.066667 42.666667 0 59.733333 8.533333 8.533333 21.333333 12.8 29.866666 12.8s21.333333-4.266667 29.866667-12.8l213.333333-213.333333c17.066667-17.066667 17.066667-42.666667 0-59.733334l-213.333333-213.333333z" fill="#bfbfbf" p-id="1597"></path></svg></li>';
        return $s;
    }

    //轮播区主栏推荐商品 html
    public function asideSp(){
        $model = new Sp();
        $s = '';

        //遍历 model 的 navAside 属性生成所有 .main，每次遍历进行一次拼接
        foreach($model->navAside as $id){
            $sp = $model->getTjSp($id);                                 //获取用于展示的推荐商品
            shuffle($sp);                                               //打乱顺序
            $s = $s.'<div class="main">';
            $count = 0;
            foreach($sp as $v){
                $v->ex = json_decode($v->ex);
                $src = $v->ex[1][array_flip($v->ex[0])['photo[]']][0];
                $s = $s.'<figure class="a_src" data-a_src="http://store.com/index/index/sp?id='.$v->id.'"><img src="'.$src.'" alt=""><figcaption>'.$v->name.'</figcaption></figure>';
                $count++;
                if($count >= 24)  break;
            }
            $s = $s.'</div>';
        }
        return $s;
    }
}