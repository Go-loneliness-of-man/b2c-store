<?php
namespace App\Admin\controller;

use app\Admin\model\Admin;
use app\Admin\model\User;

class Hy extends \think\Controller {

    //增
    public function add()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
            return '当前账户没有执行此操作的权限';

        if($_REQUEST['type2'] == 'admin'){
            $model = new Admin();
            return $model->add();
        }
        else{
            $model = new User();
            return $model->add();
        }
    }

    //删
    public function del()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
            return '当前账户没有执行此操作的权限';

        if($_REQUEST['type2'] == 'admin'){
            $model = new Admin();
            return $model->del();
        }
        else{
            $model = new User();
            return $model->del();
        }
    }

    //改
    public function re()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
            return '当前账户没有执行此操作的权限';

        if($_REQUEST['type2'] == 'admin'){
            $model = new Admin();
            return $model->re();
        }
        else{
            $model = new User();
            return $model->re();
        }
    }

    //查
    public function sech()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'cduser'))
            return '当前账户没有执行此操作的权限';
            
        if($_REQUEST['type2'] == 'admin'){
            $model = new Admin();
            return $model->sech();
        }
        else{
            $model = new User();
            return $model->sech();
        }
    }
}





