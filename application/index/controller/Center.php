<?php
namespace App\Index\Controller;

use \think\Db;
use \app\index\model\User;
use \app\index\model\Ddm;
use \app\index\model\Sp;
use \app\index\model\Tj;

class Center extends \think\Controller
{
    //返回用户信息
    public function userXx()
    {
        $user = User::get(['mail' => $_SESSION['mail']]);
        $v = new \stdClass();
        $v->name = $user["name"];
        $v->pwd = $user["pwd"];
        $v->adrs = $user["adrs"];
        $v->phone = $user["phone"];
        $v->sex = $user["sex"];
        $v->head = $user["head"];
        return json_encode($v);
    }

    //修改用户信息
    public function re()
    {
        $model = new User();
        return $model->re();
    }

    //生成订单 html
    public function getDd()
    {
        $s = '';
        $uid = User::get(['mail' => $_SESSION['mail']])->id;
        $data = Ddm::query('select * from ddtj.dd where uid='.$uid.' order by time desc');
        foreach($data as $v){
            $s = $s.'<div class="dd_single" data-id="'.$v['id'].'"><div class="left">';
            $sid = explode(',', $v['sid']);
            $count = explode(',', $v['count']);
            $price = explode(',', $v['price']);
            $img = '';
            $ms = '';

            for($i = 0, $c = count($sid); $i < $c; $i++){
                $sp = Sp::get($sid[$i]);
                $sp->ex = json_decode($sp->ex);
                $img = $img.'<img src="'.$sp->ex[1][array_flip($sp->ex[0])['photo[]']][0].'" class="a_src" data-a_src="http://store.com/index/index/sp?id='.$sp->id.'">';
                $ms = $ms.'<div class="single"><div class="sp_name">'.$sp->name.'</div><div class="price">￥ '.($price[$i] / $count[$i]).'</div><div class="count">x'.$count[$i].'</div></div>';
            }
            $s = $s.$img.'</div><div class="right"><div class="ms">'.$ms.'</div><div class="btns">';

            //按钮组
            if(!$v['zfstate']) $s = $s.'<div class="btn zf"="">支付</div>';
            if($v['mailstate'] && !$v['state'])   $s = $s.'<div class="btn look">查看物流</div><div class="btn enter">确认收货</div>';
            $s = $s.'<div class="btn xq a_src" data-a_src="http://store.com/index/index/ddxq?id='.$v['id'].'">订单详情</div></div></div></div>';
        }
        return $s;
    }

    //支付
    public function zf()
    {
        Ddm::where(['id' => $_REQUEST['id']])->update(['zfstate' => 1]);
        return '支付成功';
    }

    //确认收货
    public function enter()
    {
        $model = new Tj();
        Ddm::where(['id' => $_REQUEST['id']])->update(['state' => 1]);
        $model->up('money', (Ddm::get(['id' => $_REQUEST['id']]))->prices);
        $model->up('csucs', 1);
        return '已确认，您可以对该订单进行评价了';
    }

    //订单详情
    public function xq()
    {
        $data = Ddm::get(['id' => $_REQUEST['id']]);
        $unset = ['id','sid', 'uid'];
        foreach($unset as $k)
            unset($data[$k]);
        return json_encode($data);
    }

    //生成评论 html
    public function getPl()
    {
        $s = '';
        $uid = User::get(['mail' => $_SESSION['mail']])->id;
        $data = Ddm::query('select * from ddtj.dd where uid='.$uid.' order by time desc');

        foreach($data as $v){
            $s = $s.'<div class="single_pl" data-id="'.$v['id'].'"><div class="outer">';
            $sid = explode(',', $v['sid']);
            $img = '';

            for($i = 0, $c = count($sid); $i < $c; $i++){
                $sp = Sp::get($sid[$i]);
                $sp->ex = json_decode($sp->ex);
                $img = $img.'<img src="'.$sp->ex[1][array_flip($sp->ex[0])['photo[]']][0].'" class="a_src" data-a_src="http://store.com/index/index/sp?id='.$sp->id.'">';
            }
            $s = $s.$img.'</div><div class="right"><div class="nr">'.$v['pl'].'</div><div class="btns">';

            //按钮组，当已确认收货且未评论时才显示评论按钮
            if($v['state'] && !$v['star']) $s = $s.'<div class="btn a_src" data-a_src="http://store.com/index/index/pl?id='.$v['id'].'"">评论</div>';
            $s = $s.'</div></div></div>';
        }
        return $s;
    }

    //添加评论
    public function pl()
    {
        $data = json_decode($_REQUEST['data']);
        Ddm::where(['id' => $data->id])->update(['pl' => $data->pl, 'star' => $data->star, 'pltime' => date('Y-m-d H:i:s')]);
        return 'OK';
    }
}







