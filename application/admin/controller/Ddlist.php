<?php
namespace App\Admin\controller;

use \think\Db;
use \app\admin\model\Dd;
use \app\admin\model\User;

class Ddlist extends \think\Controller
{
    //订单列表
    public function sech()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'dlook'))
            return '当前账户没有执行此操作的权限';

        $zfstate = ['未支付', '已支付'];
        $mailstate = ['未发货', '已发货'];
        $state = ['未完成', '已收货', '退货', '售后'];

        $model = new Dd();
        $data = $model->sech(($_REQUEST['num'] - 1) * 14, 14);
        $s = '';

        //拼接字符串
        if(!empty($data))
            foreach($data as $v){
                $u = User::get($v['uid']);
                $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li>'.$state[$v['state']].'</li><li>'.$mailstate[$v['mailstate']].'</li><li>'.$v['prices'].'</li><li>'.$v['time'].'</li><li>'.$u['name'].'</li><li>'.$v['phone'].'</li><li>'.$v['mailto'].'</li><li>'.$zfstate[$v['zfstate']].'</li><li><svg class="ck" t="1560241488485" class="icon" style="" viewBox="0 0 1024 1024" version="1.1"  xmlns="http://www.w3.org/2000/svg" p-id="2187" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32">  <defs>    <style type="text/css"></style>  </defs>  <path    d="M819.2 563.2c-113.1 0-204.8 91.7-204.8 204.8 0 113.1 91.7 204.8 204.8 204.8 24.2 0 47-4.9 68.6-12.6l48.8 48.8c20 20 52.4 20 72.4 0 20-20 20-52.4 0-72.4l-35.4-35.4c31-35.9 50.4-82.1 50.4-133.2 0-113.1-91.7-204.8-204.8-204.8z"    fill="#bfbfbf" p-id="2188"></path>  <path    d="M921.6 0H102.4C46.1 0 0 46.1 0 102.4v819.2C0 977.9 46.1 1024 102.4 1024h547.1C566.7 969 512 874.9 512 768c0-169.7 137.5-307.2 307.2-307.2 78.8 0 150.4 29.9 204.8 78.7V102.4C1024 46.1 977.9 0 921.6 0z m-512 716.8H204.8c-28.2 0-51.2-23-51.2-51.2 0-28.2 23-51.2 51.2-51.2h204.8c28.2 0 51.2 23 51.2 51.2 0 28.2-23 51.2-51.2 51.2zM512 512H204.8c-28.2 0-51.2-23-51.2-51.2 0-28.2 23-51.2 51.2-51.2H512c28.2 0 51.2 23 51.2 51.2 0 28.2-23 51.2-51.2 51.2z m307.2-204.8H204.8c-28.2 0-51.2-23-51.2-51.2s23-51.2 51.2-51.2h614.4c28.2 0 51.2 23 51.2 51.2s-23 51.2-51.2 51.2z"    fill="#bfbfbf" p-id="2189"></path></svg></li></ul>';
            }
        else    $s = '没有更多订单了';
        return $s;
    }

    //查看订单详细信息
    public function ckDd()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'dlook'))
            return '当前账户没有执行此操作的权限';

        header('Access-Control-Allow-Origin:http://store.com');           //允许域名访问
        return json_encode(Dd::get($_REQUEST['id']));
    }
}


































