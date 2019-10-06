<?php
namespace App\Admin\controller;

use \think\Db;

class Splist extends \think\Controller
{
    //拉取所有一级商品类
    public function getOneClass()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $re = Db::table('s')->where(['level' => 0, 'type' => 1])->select();  //查询所有一级商品类
        $s = '';                                        //准备拼接
        foreach($re as $v)                              //拼接字符串
            $s = $s.'<li data-id="'.$v['id'].'">'.$v['name'].'<svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li>';
        return $s;
    }

    //拉取某个商品类下的所有商品类
    public function getSpClass()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $re = Db::table('s')->where(['pid' => $_GET['id'], 'type' => 1])->select();  //查询
        $s = '';                                        //准备拼接
        foreach($re as $v)                              //拼接字符串
            $s = $s.'<li data-id="'.$v['id'].'">'.$v['name'].'<svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li>';
        return $s;
    }

    //拉取某个商品类下的所有商品
    public function getSp()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $re = Db::table('s')->where(['pid' => $_GET['id'], 'type' => 0])->select();  //查询商品
        $father = Db::table('s')->where(['id' => $_GET['id']])->select();            //查询父类
        $father = $father[0];
        $s = '';                                        //准备拼接
        foreach($re as $v) {                            //拼接字符串
            $ex = json_decode($v['ex']);                //还原 json
            $ex[0] = array_flip($ex[0]);                //反转保存属性名数组的 key、val
            $src = $ex[1][$ex[0]['photo[]']][0];        //封面图片路径，取 photo[] 的第一张
            $price = $ex[1][$ex[0]['price']][0];        //商品价格
            $tuijian = \App\Admin\Common\pdtj($v['pid'], $v['id']); //判断是否存在于从 recom 表，返回“是”、“否”
            $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li>'.$v['name'].'</li><li>'.$v['level'].'</li><li>'.$father['name'].'</li><li><img src="'.$src.'"></li><li>'.$price.'</li><li>'.$tuijian.'</li><li>'.$v['ex'].'</li><li><svg class="ck" t="1560241488485" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2187" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M819.2 563.2c-113.1 0-204.8 91.7-204.8 204.8 0 113.1 91.7 204.8 204.8 204.8 24.2 0 47-4.9 68.6-12.6l48.8 48.8c20 20 52.4 20 72.4 0 20-20 20-52.4 0-72.4l-35.4-35.4c31-35.9 50.4-82.1 50.4-133.2 0-113.1-91.7-204.8-204.8-204.8z" fill="#bfbfbf" p-id="2188"></path><path d="M921.6 0H102.4C46.1 0 0 46.1 0 102.4v819.2C0 977.9 46.1 1024 102.4 1024h547.1C566.7 969 512 874.9 512 768c0-169.7 137.5-307.2 307.2-307.2 78.8 0 150.4 29.9 204.8 78.7V102.4C1024 46.1 977.9 0 921.6 0z m-512 716.8H204.8c-28.2 0-51.2-23-51.2-51.2 0-28.2 23-51.2 51.2-51.2h204.8c28.2 0 51.2 23 51.2 51.2 0 28.2-23 51.2-51.2 51.2zM512 512H204.8c-28.2 0-51.2-23-51.2-51.2 0-28.2 23-51.2 51.2-51.2H512c28.2 0 51.2 23 51.2 51.2 0 28.2-23 51.2-51.2 51.2z m307.2-204.8H204.8c-28.2 0-51.2-23-51.2-51.2s23-51.2 51.2-51.2h614.4c28.2 0 51.2 23 51.2 51.2s-23 51.2-51.2 51.2z" fill="#bfbfbf" p-id="2189"></path></svg><svg class="ckpl" t="1560241517247" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3192" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M554.46 839.42a50.33 50.33 0 0 1-20-4.17 49.62 49.62 0 0 1-30-44.14L503 744H275.53a114.4 114.4 0 0 1-114.28-114.26V298.86a114.4 114.4 0 0 1 114.28-114.28h472.94a114.4 114.4 0 0 1 114.28 114.28v330.88A114.4 114.4 0 0 1 748.47 744h-36.13a81.34 81.34 0 0 0-53.86 20.32L587.24 827a49.66 49.66 0 0 1-32.78 12.42zM275.53 254.66a44.28 44.28 0 0 0-44.21 44.21v330.87a44.28 44.28 0 0 0 44.21 44.21H514a58.49 58.49 0 0 1 58.72 56.8l0.48 15.26 39-34.35a151.92 151.92 0 0 1 100.12-37.71h36.13a44.28 44.28 0 0 0 44.21-44.21V298.86a44.28 44.28 0 0 0-44.21-44.21z" fill="#8a8a8a" p-id="3193"></path><path d="M331.99 458.59m-42.28 0a42.28 42.28 0 1 0 84.56 0 42.28 42.28 0 1 0-84.56 0Z" fill="#8a8a8a" p-id="3194"></path><path d="M512 458.59m-42.28 0a42.28 42.28 0 1 0 84.56 0 42.28 42.28 0 1 0-84.56 0Z" fill="#8a8a8a" p-id="3195"></path><path d="M692.01 458.59m-42.28 0a42.28 42.28 0 1 0 84.56 0 42.28 42.28 0 1 0-84.56 0Z" fill="#8a8a8a" p-id="3196"></path></svg><svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li></ul>';
        }
        return $s;
    }

    //根据商品名关键字搜索商品
    public function sechSp()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        //检测库、表是否存在，若不存在则创建
        \App\Admin\Common\Cs::dt('sp','s','create table s(id int primary key auto_increment,level tinyint,pid int,path varchar(100),name varchar(100),type tinyint,ex text)');
        $gjz = explode(' ',$_REQUEST['gjz']);           //取出关键字
        $sql = 'select * from s where type=0 and name like "%'.$gjz[0].'%"';      //待拼接的 sql
        for($c = count($gjz), $i = 1; $i < $c; $i++)    //拼接其余关键字
            $sql = $sql.'and name like "%'.$gjz[$i].'%"';
        $re = Db::query($sql);                          //获取数据
        $s = '';                                        //准备拼接
        foreach($re as $v) {                            //拼接字符串
            $ex = json_decode($v['ex']);                //还原 json
            $ex[0] = array_flip($ex[0]);                //反转保存属性名数组的 key、val
            $src = $ex[1][$ex[0]['photo[]']][0];        //封面图片路径，取 photo[] 的第一张
            $price = $ex[1][$ex[0]['price']][0];        //商品价格
            $father = Db::table('s')->where(['id' => $v['pid']])->select(); //查询父类
            $father = $father[0];
            $tuijian = \App\Admin\Common\pdtj($v['pid'], $v['id']); //判断是否存在于从 recom 表，返回“是”、“否”
            $s = $s.'<ul data-id="'.$v['id'].'"><li>'.$v['id'].'</li><li>'.$v['name'].'</li><li>'.$v['level'].'</li><li>'.$father['name'].'</li><li><img src="'.$src.'"></li><li>'.$price.'</li><li>'.$tuijian.'</li><li>'.$v['ex'].'</li><li><svg class="ck" t="1560241488485" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2187" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M819.2 563.2c-113.1 0-204.8 91.7-204.8 204.8 0 113.1 91.7 204.8 204.8 204.8 24.2 0 47-4.9 68.6-12.6l48.8 48.8c20 20 52.4 20 72.4 0 20-20 20-52.4 0-72.4l-35.4-35.4c31-35.9 50.4-82.1 50.4-133.2 0-113.1-91.7-204.8-204.8-204.8z" fill="#bfbfbf" p-id="2188"></path><path d="M921.6 0H102.4C46.1 0 0 46.1 0 102.4v819.2C0 977.9 46.1 1024 102.4 1024h547.1C566.7 969 512 874.9 512 768c0-169.7 137.5-307.2 307.2-307.2 78.8 0 150.4 29.9 204.8 78.7V102.4C1024 46.1 977.9 0 921.6 0z m-512 716.8H204.8c-28.2 0-51.2-23-51.2-51.2 0-28.2 23-51.2 51.2-51.2h204.8c28.2 0 51.2 23 51.2 51.2 0 28.2-23 51.2-51.2 51.2zM512 512H204.8c-28.2 0-51.2-23-51.2-51.2 0-28.2 23-51.2 51.2-51.2H512c28.2 0 51.2 23 51.2 51.2 0 28.2-23 51.2-51.2 51.2z m307.2-204.8H204.8c-28.2 0-51.2-23-51.2-51.2s23-51.2 51.2-51.2h614.4c28.2 0 51.2 23 51.2 51.2s-23 51.2-51.2 51.2z" fill="#bfbfbf" p-id="2189"></path></svg><svg class="ckpl" t="1560241517247" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3192" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M554.46 839.42a50.33 50.33 0 0 1-20-4.17 49.62 49.62 0 0 1-30-44.14L503 744H275.53a114.4 114.4 0 0 1-114.28-114.26V298.86a114.4 114.4 0 0 1 114.28-114.28h472.94a114.4 114.4 0 0 1 114.28 114.28v330.88A114.4 114.4 0 0 1 748.47 744h-36.13a81.34 81.34 0 0 0-53.86 20.32L587.24 827a49.66 49.66 0 0 1-32.78 12.42zM275.53 254.66a44.28 44.28 0 0 0-44.21 44.21v330.87a44.28 44.28 0 0 0 44.21 44.21H514a58.49 58.49 0 0 1 58.72 56.8l0.48 15.26 39-34.35a151.92 151.92 0 0 1 100.12-37.71h36.13a44.28 44.28 0 0 0 44.21-44.21V298.86a44.28 44.28 0 0 0-44.21-44.21z" fill="#8a8a8a" p-id="3193"></path><path d="M331.99 458.59m-42.28 0a42.28 42.28 0 1 0 84.56 0 42.28 42.28 0 1 0-84.56 0Z" fill="#8a8a8a" p-id="3194"></path><path d="M512 458.59m-42.28 0a42.28 42.28 0 1 0 84.56 0 42.28 42.28 0 1 0-84.56 0Z" fill="#8a8a8a" p-id="3195"></path><path d="M692.01 458.59m-42.28 0a42.28 42.28 0 1 0 84.56 0 42.28 42.28 0 1 0-84.56 0Z" fill="#8a8a8a" p-id="3196"></path></svg><svg class="del" t="1559570066932" class="icon" style="" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="2261" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32"><defs><style type="text/css"></style></defs><path d="M959.36 218.208A95.68 95.68 0 0 0 864 128.096h-96V96.032a96 96 0 0 0-96-96H352a96 96 0 0 0-96 96v32.032H160a95.68 95.68 0 0 0-95.392 90.112H64v69.856a64 64 0 0 0 64 64v544a128 128 0 0 0 128 128h512a128 128 0 0 0 128-128v-544a64 64 0 0 0 64-64V218.208h-0.64zM320 96.064a32 32 0 0 1 32-32h320a32 32 0 0 1 32 32v32H320v-32z m512 800c0 35.264-28.736 64-64 64H256c-35.296 0-64-28.736-64-64v-544h640v544z m64-640.032v32H128V224.064a32 32 0 0 1 32-32h704a32 32 0 0 1 32 32v31.968z" fill="#8a8a8a" p-id="2262"></path><path d="M288 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32H288a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416H288v-416zM480 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416zM672 896.192h64a32 32 0 0 0 32-32v-416a32 32 0 0 0-32-32h-64a32 32 0 0 0-32 32v416a32 32 0 0 0 32 32z m0-448.032h64v416h-64v-416z" fill="#8a8a8a" p-id="2263"></path></svg></li></ul>';
        }
        return $s;
    }

    //删除商品，包括 s 表内的记录，extra 表内涉及到该商品的 sid，商品的文件共三项
    public function dropSp()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';
            
        $sp = Db::table('s')->where(['id' => $_REQUEST['id']])->select(); //查询商品记录
        $sp = $sp[0];
        $sp['ex'] = json_decode($sp['ex']);             //还原 JSON

        foreach($sp['ex'][0] as $k => $v){              //去掉该商品的 sid
            $v = explode('[]',$v)[0];                   //去掉文件 key 的 []
            $extra = Db::table('extra')->where(['k' => $v])->select(); //查询记录
            $extra = $extra[0];
            $sid = explode(',', $extra['sid']);         //转换 sid 为数组
            foreach($sid as $key => $val)               //移除该商品的 id
                if($val == $sp['id'])
                    unset($sid[$key]);
            $extra['sid'] = '';
            foreach($sid as $val)                       //将 sid 拼回字符串
                if($extra['sid'] == '')
                    $extra['sid'] = $val;
                else
                    $extra['sid'] = $extra['sid'].','.$val;
            Db::table('extra')->where(['k' => $v])->update(['sid' => $extra['sid']]); //更新记录
        }

        foreach($sp['ex'][0] as $k => $v){              //删除该商品对应的文件
            if(isset(explode('[]',$v)[1])) {            //判断是否是文件
                $srcs = $sp['ex'][1][$k];               //获取路径
                if(is_array($srcs))                     //判断是否是数组
                    foreach($srcs as $src)              //删除其下所有文件
                        unlink(ROOT_PATH.'public'.$src);
            }
        }

        Db::table('s')->where(['id' => $sp['id']])->delete();   //删除商品记录

        return 'OK';
    }

    //删除类，会连带删除其下所有商品
    public function dropSpClass()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'scud'))
            return '当前账户没有执行此操作的权限';

        //取出该商品类下的所有商品 id，循环调用 dropSp() 即可，循环时要不断重置 $_REQUEST['id']
        $sp = Db::table('s')->where(['pid' => $_REQUEST['id']])->select();  //取出该类下的商品
        Db::table('s')->where(['id' => $_REQUEST['id']])->delete();         //删除该类
        $s = 'OK，该类以及其下的商品 ';                 //拼接消息
        foreach ($sp as $id) {
            $_REQUEST['id'] = $id['id'];
            $this->dropSp();
            $s = $s.$id['name'].'、';
        }
        return $s.' 都已被删除';
    }

    //查看商品详细信息
    public function ckSp()
    {
        if(!\App\Admin\Common\Qx::p($_SESSION['type'],'slook'))
            return '当前账户没有执行此操作的权限';

        header('Access-Control-Allow-Origin:http://store.com');           //允许域名访问
        $sp = Db::table('s')->where(['id' => $_REQUEST['id']])->select(); //查询商品记录
        $sp = $sp[0];
        $sp['ex'] = json_decode($sp['ex']);                               //还原 JSON
        return json_encode($sp);
    }
}





