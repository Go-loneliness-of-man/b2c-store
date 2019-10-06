<?php
namespace App\Index\Controller;

use \think\Db;
use app\index\model\Sp;

class Search extends \think\Controller{

  //生成结果 html
  public function res(){
    $gjz = explode(' ',$_REQUEST['gjz']);           //取出关键字
    $model = new Sp();
    $sp = $model->gjzSearch($gjz);                  //获取商品数据
    $s = '<div class="result">';                    //准备拼接

    foreach($sp as $v) {                            //拼接字符串
      $ex = json_decode($v['ex']);                  //还原 json
      $ex[0] = array_flip($ex[0]);                  //反转保存属性名数组的 key、val
      $src = $ex[1][$ex[0]['photo[]']][0];          //封面图片路径，取 photo[] 的第一张
      $price = $ex[1][$ex[0]['price']][0];          //商品价格
      $s = $s.'<figure><div class="outer a_src" data-a_src="http://store.com/index/index/sp?id='.$v['id'].'"><img src="'.$src.'"></div><figcaption><div class="sp_name">'.$v['name'].'</div><div class="price">￥ '.$price.'</div><div class="style">';
      if(isset($ex[0]['sphoto[]'])) {               //若存在样式图片，取出并生成对应样式
        $ssrc = $ex[1][$ex[0]['sphoto[]']];
        foreach($ssrc as $v2)
          $s = $s.'<img src="'.$v2.'">';
      }
      $s = $s.'</div></figcaption></figure>';
    }
    $s = $s.'</div>';                                  //闭合 .result
    return $s;
  }
}

















?>