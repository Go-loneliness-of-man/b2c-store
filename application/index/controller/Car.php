<?php
namespace App\Index\Controller;

use \think\Db;
use \app\index\model\User;
use \app\index\model\Sp;

class Car extends \think\Controller
{
    //添加商品
    public function add()
    {
        $data = json_decode($_REQUEST['data']);

        //判断是否已登录
        if(isset($_SESSION['mail']))
            $u = User::get(['mail' => $_SESSION['mail']]);
        else
            return '请先登录';

        //检测库、表是否存在，若不存在则创建
        $table = 'g'.$u->id;
        \App\index\Common\Cs::dt('U', $table,'create table '.$table.'(id int primary key auto_increment,sid int,name varchar(300),ms varchar(600),count int)');

        //准备数据
        $sid = $data->id;
        unset($data->id);
        $name = $data->name;
        unset($data->name);
        $count = $data->count;
        unset($data->count);
        if(isset($data->stop)) unset($data->stop);            //销毁无关变量

        $ms = json_encode($data);

        //插入数据
        Db::execute('insert into U.g'.$u->id.' values(NULL,'.$sid.',\''.$name.'\',\''.$ms.'\','.$count.')');
        return '已成功添加到购物车';
    }

    //返回购物车 html
    public function sech()
    {
        $u = User::get(['mail' => $_SESSION['mail']]);
        $data = Db::query('select * from U.g'.$u->id);
        $xuanx = array('spstyle' => '样式', 'yfsize' => '衣服尺码', 'yjkxz' => '眼镜框形状', 'pcpz' => 'pc 配置', 'sjneicunandcipan' => '手机内存和磁盘空间大小');
        $s = '';

        foreach($data as $v){

            //获取商品信息
            $sp = Sp::get($v['sid']);
            $sp['ex'] = json_decode($sp['ex']);
            $src = $sp['ex'][1][array_flip($sp['ex'][0])['photo[]']][0];
            $v['ms'] = json_decode($v['ms']);

            //选项属性
            $ms = '';
            foreach($v['ms'] as $k2 => $v2)
                if($k2 == 'price')  continue;
                else    $ms = $ms.$xuanx[$k2].'：'.$v2.'；';

            //拼接 html
            $s = $s.'<div class="single" data-id='.$v['id'].' data-sid="'.$v['sid'].'"><div class="enter"><div class="radius"></div></div><div class="outer"><img src="'.$src.'"></div><div class="right"><div class="sp_name">'.$v['name'].'</div><div class="ms">'.$ms.'</div><div class="price">￥ '.$v['ms']->price.'</div><div class="count"><div class="jian">-</div><div class="num">'.$v['count'].'</div><div class="add">+</div></div></div><div class="del_outer"><svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></div></div>';
        }
        return $s;
    }

    //删除购物车商品
    public function del()
    {
        $u = User::get(['mail' => $_SESSION['mail']]);
        Db::execute('delete from U.g'.$u->id.' where id='.$_REQUEST['id']);
        return 'OK';
    }

    //修改购物车商品的数量
    public function re()
    {
        $u = User::get(['mail' => $_SESSION['mail']]);
        Db::execute('update U.g'.$u->id.' set count='.$_REQUEST['count'].' where id='.$_REQUEST['id']);
        return 'OK';
    }
}










