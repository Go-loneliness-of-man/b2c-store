<?php
namespace App\Index\Controller;

use \think\Db;
use \app\index\model\Ddm;
use \app\index\model\Sp;

class Dd extends \think\Controller
{
    //接收单个商品数据，返回其 html
    public function single()
    {
        $model = new Sp();
        $data = json_decode($_REQUEST['data']);
        $sp = Sp::get($data->id);                                        //获取商品信息
        $sp->ex = json_decode($sp->ex);
        $src = $sp->ex[1][array_flip($sp->ex[0])['photo[]']][0];
        $s = '<div class="single" data-id="'.$data->id.'"><div class="outer"><img src="'.$src.'"></div><div class="xx"><div class="sp_name">'.$data->name.'</div><div class="ms">';
        $temp = '</div><div class="mail">包邮：'.$sp->ex[1][array_flip($sp->ex[0])['mailto']][0].'</div><div class="count">个数：'.$data->count.'</div><div class="price">￥ '.($data->price * $data->count).'</div></div></div>';

        //消除无关变量
        unset($data->stop);
        unset($data->name);
        unset($data->id);
        unset($data->count);
        unset($data->price);
        unset($data->single);

        //生成描述字符串
        foreach($data as $k => $v)
            $s = $s.$model->xuanx[$k].'：'.$v.'；';
            
        return $s.$temp;
    }

    //接收多个商品（来自购物车）数据，返回其订单 html
    public function car()
    {
        $model = new Sp();
        $data = json_decode($_REQUEST['data']);
        $s = '';
        foreach($data->sp as $v){
            $sp = Sp::get($v->id);
            $sp->ex = json_decode($sp->ex);
            $s = $s.'<div class="single" data-id="'.$v->id.'"><div class="outer"><img src="'.$sp->ex[1][array_flip($sp->ex[0])['photo[]']][0].'"></div><div class="xx"><div class="sp_name">'.$v->name.'</div><div class="ms">'.$v->style.'</div><div class="mail">包邮：'.$sp->ex[1][array_flip($sp->ex[0])['mailto']][0].'</div><div class="count">个数：'.$v->num.'</div><div class="price">￥ '.($v->num * $v->price).'</div></div></div>';
        }
        return $s;
    }

    //接收订单数据，插入数据库
    public function add()
    {
        $model = new Ddm();
        $data = json_decode($_REQUEST['data']);
        $model->add($data);
        return 'OK';
    }
}







