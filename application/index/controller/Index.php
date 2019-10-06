<?php
namespace App\Index\Controller;

use \think\Db;
use \app\index\model\User;

class Index extends \think\Controller
{
    //首页
    public function index()
    {
        return $this->fetch();
    }

    //商品购买页
    public function sp()
    {
        return $this->fetch('sp');
    }

    //商品类页
    public function spClass()
    {
        return $this->fetch('spClass');
    }

    //用户登录或注册页
    public function login()
    {
        return $this->fetch('login');
    }

    //用户中心页
    public function center()
    {
        return $this->fetch('center');
    }

    //提交订单页
    public function adddd()
    {
        return $this->fetch('adddd');
    }

    //订单详情页
    public function ddxq()
    {
        return $this->fetch('ddxq');
    }

    //评论页
    public function pl()
    {
        return $this->fetch('pl');
    }
}







