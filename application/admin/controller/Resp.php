<?php
namespace App\Admin\controller;

use \think\Db;

class Resp extends \think\Controller
{
    //修改商品
    public function re()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        $v = [];

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        if($_POST['type'] == 'name'){                       //判断修改 name 还是 ex
            $v['name'] = $_POST['v'];
            Db::table('s')->where(['id' => $_POST['id'], 'type' => 0])->update($v);
        }
        else{
            $re = Db::table('s')->where(['id' => $_POST['id'], 'type' => 0])->select(); //获取记录
            $ex = json_decode($re[0]['ex']);                //获取 ex
            $ex[0] = array_flip($ex[0]);                    //反转保存属性名数组的 key、val
            $ex[1][$ex[0][$_POST['k']]][(int)$_POST['eq']] = $_POST['v'];  //修改值
            $ex[0] = array_flip($ex[0]);                    //再次反转保存属性名数组的 key、val
            Db::table('s')->where(['id' => $_POST['id'], 'type' => 0])->update(['ex' => json_encode($ex)]);
        }

        return 'OK';
    }
}





