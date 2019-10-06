<?php
namespace App\Index\Controller;

use \think\Db;
use \app\index\model\User;
use \app\index\model\Tj;

class Login extends \think\Controller
{
    //验证登录或注册
    public function judge()
    {
        if(isset($_SESSION['status'])) {                    //判断是否已登录
            if($_SESSION['status'] == 1 && $_SESSION['type'] == 'user')   //判断用户状态是否为登录
                return '1,当前用户已在登录状态,'.$_SESSION['name'];
            else if($_SESSION['status'] == 1){
                $_SESSION = [];
                return '0,当前客户端已有账户登录，已自动退出，请重新登录';
            }
        }

        if(isset($_REQUEST['mail']) && isset($_REQUEST['pwd'])) {   //判断是否是登录页
            $u = User::get(['mail' => $_REQUEST['mail']]);

            //若该用户不存在，自动为其注册
            if($u == NULL) {
                User::create([
                    'name' => '未命名',
                    'pwd' => $_REQUEST['pwd'],
                    'mail' => $_REQUEST['mail'],
                    'adrs' => '待设置',
                    'phone' => '待设置',
                    'sex'   =>  '待设置',
                    'head'  =>  '\static\iva\head.jpg',     //默认头像
                    'time' => date("Y-m-d H:i:s")
                ]);
                $_SESSION['name'] = '未命名';
                $_SESSION['type'] = 'user';
                $_SESSION['mail'] = $_REQUEST['mail'];
                $_SESSION['status'] = 1;
                $model = new Tj();
                $model->up('ucount', 1);
                return '3,用户不存在，但已自动为您注册，请设置相关信息';
            }
            else{
                if($_REQUEST['pwd'] != $u['pwd'])
                    return '0,密码错误';
                $_SESSION['name'] = $u['name'];
                $_SESSION['mail'] = $u['mail'];
                $_SESSION['type'] = 'user';
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







