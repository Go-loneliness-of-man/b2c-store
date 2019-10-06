<?php
namespace App\Admin\controller;

use \think\Db;
use \app\Admin\model\Admin;

class Index extends \think\Controller
{
    //首页
    public function index()
    {
        return $this->fetch();
    }

    //后台登录页
    public function login()
    {
        return $this->fetch('login');
    }

    //判断登录
    public function judge()
    {
        if(isset($_SESSION['status'])) {                //判断是否存在对应文件
            if($_SESSION['status'] == 1 && ($_SESSION['type'] == 'super' || $_SESSION['type'] == 'shoper')) //判断用户状态是否为登录
                return '1,当前用户已在登录状态';
        }

        if(isset($_REQUEST['name']) && isset($_REQUEST['pwd'])) {   //判断是否是登录页
            $u = Admin::get(['name' => $_REQUEST['name'], 'pwd' => $_REQUEST['pwd']]);
            if($u == NULL)  return '0,用户名或密码错误';
            else{
                \App\Admin\Common\Cs::dt('u','login','create table login(id int primary key auto_increment, name varchar(60), time datetime, ip char(30))');
                Db::execute('insert into u.login values(NULL, \''.$u['name'].'\', \''.date('Y-m-d H:i:s').'\', \''.$_SERVER['REMOTE_ADDR'].'\')');

                $_SESSION['name'] = $u['name'];
                $_SESSION['type'] = $u['type'];
                $_SESSION['status'] = 1;
                return '1,登录成功';
            }
        }

        return '2,未知原因，可能是数据库未启动';
    }

    //退出
    public function eExit()
    {
        $_SESSION['status'] = 0;                        //更改状态
        return '已退出';
    }
}





