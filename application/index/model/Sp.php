<?php
namespace app\index\model;     //命名空间

use think\Model;               //引用公共模型类
use \think\Db;

class Sp extends Model{        //声明模型类
  
  public $table = 's';
  
  public $connection = [
    'type' => 'mysql',
    'hostname' => 'store.com',
    'database' => 'sp',
    'username' => 'root',
    'password' => '123',
    'charset' => 'utf8',
    'prefix' => '',
    'debug' => true
  ];

  //顶部导航栏所展示商品类的 id
  public $navTop = [1,43,44,116,60,61];

  //轮播区侧边栏所展示商品类的 id
  public $navAside = [1,11,41,43,44,46,51,54,52];

  //热点商品 id
  public $hot = [63, 130, 144, 72];

  //商品选项中文名
  public $xuanx = array('spstyle' => '样式', 'yfsize' => '衣服尺码', 'yjkxz' => '眼镜框形状', 'pcpz' => 'pc 配置', 'sjneicunandcipan' => '手机内存和磁盘空间大小');

  //返回顶部导航栏对应商品类
  public function getNavTop()
  {
    return self::all($this->navTop);
  }

  //返回轮播区侧栏对应商品类
  public function getNavAside()
  {
    return self::all($this->navAside);
  }

  //返回一个商品类的推荐商品，若该类无推荐商品则返回其子类的推荐商品
  public function getTjSp($id){
    $re = Db::table('recom')->where(['id' => $id])->select();  //获取推荐数据
    if($re == []){                                             //若没有获取到，证明该类无直系的推荐商品，则获取其下子类的所有推荐商品
      $re = Db::table('s')->where(['pid' => $id, 'type' => 1])->select(); //获取子类
      $re2 = $re;                                              //保存子类
      $re = [['sid' => '']];                                   //准备构造结果集，以便运算
      foreach($re2 as $v)                                      //拼接出商品 id 字符串
        $re[0]['sid'] = $re[0]['sid'].(Db::table('recom')->where(['id' => $v['id']])->select())[0]['sid'];  //获取所有子类的推荐数据
    }
    $spid = explode(',', $re[0]['sid']);
    return self::all($spid);
  }

  //返回一个商品类的所有商品及其推荐图片路径，若该类无直系商品则以数组形式返回其子类的商品
  public function getSp($id){
    $re = Db::table('s')->where(['pid' => $id, 'type' => 0])->select();   //获取直系商品数据
    if($re == []){                                             //没有获取到，该类无直系商品，则获取其下子类的所有商品，并组成数组
      $re = Db::table('s')->where(['pid' => $id, 'type' => 1])->select(); //获取子类
      $re2 = $re;                                              //保存子类
      $re = [[]];                                              //构造二维数组存储结果集
      $count = 0;
      foreach($re2 as $v)                                      //获取子类下的所有商品，保存为数组形式
        $re[$count++] = self::all(['pid' => $v['id']]);
      $re['spClass'] = (Db::table('s')->where(['id' => $id])->select())[0];    //保存商品类信息
      $re['spClass']['ex'] = explode(';', $re['spClass']['ex']);
      $re['child'] = $re2;                                     //保存子类信息
      return $re;
    }
    $re['spClass'] = (Db::table('s')->where(['id' => $id])->select())[0];
    $re['spClass']['ex'] = explode(';', $re['spClass']['ex']);
    return $re;
  }

  //返回热点商品
  public function hot(){
    return self::all($this->hot);
  }
  
  //关键字搜索，接收参数关键字应为数组
  public function gjzSearch($gjz){
    $sql = 'select * from s where type=0 and name like "%'.$gjz[0].'%"';      //待拼接的 sql
    for($c = count($gjz), $i = 1; $i < $c; $i++)    //拼接其余关键字
        $sql = $sql.'and name like "%'.$gjz[$i].'%"';
    $re = Db::query($sql);                          //获取数据
    return $re;
  }
}








?>