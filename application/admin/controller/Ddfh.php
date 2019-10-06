<?php
namespace App\Admin\controller;

use \think\Db;
use \app\admin\model\Dd;
use \app\admin\model\User;

class Ddfh extends \think\Controller
{
    //获取所有待发货
    public function sech()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'dlook'))
            return '当前账户没有执行此操作的权限';

        $zfstate = ['未支付', '已支付'];
        $model = new Dd();
        $data = $model->dfhSech();
        $s = '';

        //拼接字符串
        if(!empty($data))
            foreach($data as $v){
                $u = User::get($v['uid']);

                //获取商品图片路径
                $sid = explode(',', $v['sid']);
                $src = '';
                foreach($sid as $id){
                    $sp = Db::query('select * from sp.s where id='.$id)[0];
                    $sp['ex'] = json_decode($sp['ex']);
                    $src = $src.'<img src="'.$sp['ex'][1][array_flip($sp['ex'][0])['photo[]']][0].'">';
                }
                $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li>'.$src.'</li><li>￥ '.$v['prices'].'</li><li>'.$v['time'].'</li><li>'.$u->name.'</li><li>'.$v['phone'].'</li><li>'.$v['mailto'].'</li><li>'.$zfstate[$v['zfstate']].'</li></ul>';
            }
        else    $s = '没有更多订单了';
        return $s;
    }

    //修改订单状态为已发货
    public function re()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'dcud'))
            return '当前账户没有执行此操作的权限';

        Dd::where(['id' => $_REQUEST['id']])->update(['kd' => $_REQUEST['kd'], 'kddh' => $_REQUEST['kddh'], 'mailstate' => 1]);
        return 'OK';
    }
}





