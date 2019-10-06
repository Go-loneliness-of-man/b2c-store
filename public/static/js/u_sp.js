
//商品展示区开始 *********************************************************************************

//需要被生成为“选项控件”的属性
let xuanx = [
  ['spstyle', 'yfsize', 'yjkxz', 'pcpz', 'sjneicunandcipan'],
  {
    spstyle: '样式',
    yfsize: '衣服尺码',
    yjkxz: '眼镜框形状',
    pcpz: 'pc 配置',
    sjneicunandcipan: '手机内存和磁盘空间大小'
  }
];

//生成商品页动态信息
$.get('http://store.com/index/Pagesp/getSpxx?id=' + $('.spxinxi').data('id'), function (data) {
  data = JSON.parse(data);
  let i;
  let s;                          //“.other”字符串
  let lb = '';                    //轮播字符串
  let temp;                       //临时变量
  let ex = {};                    //额外属性

  //出现在“额外描述”内的属性
  let ewms = [
    ['zk', 'mailto'],
    {
      zk: '折扣',
      mailto: '包邮',
    }
  ];

  //与商品价格相关的属性
  let xgprice = ['yjkxz', 'pcpz', 'sjneicunandcipan'];

  //生成商品信息区 html

  //将 ex 的两个数组转为一个关联数组
  for (i = 0; i < data.ex[0].length; i++)
    ex[data.ex[0][i]] = data.ex[1][i];

  //生成固定字段
  s = `<div class="sp_name">${data.name}</div><div class="ms">${ex.spms}</div><div class="price">￥ ${ex.price[0]}</div>`;
  $('title').html(data.name);

  //生成“选项控件”
  for (let k in ex)
    if (exArr(k, xuanx[0])) {
      s = `${s}<h3>${xuanx[1][k]}</h3><div class="xuanx ${k}" data-v="">`;
      for (let i = 0; i < ex[k].length; i++)
        s = `${s}<div data-eq="${i}">${ex[k][i]}</div>`;
      s = `${s}</div>`;
    }

  //插入商品信息
  $('.show .spxx_aside .gmxx').html(s);

  //生成“额外属性” html
  s = '';
  if (ex.mailto == '否') delete ex.mailto;                //删除包邮标签
  for (let k in ex)
    if (exArr(k, ewms[0]))
      s = `${s}<div>${ewms[1][k]}</div>`;

  //插入“额外属性” html
  $('.show .spxx_aside .ewms').html(s);

  //将与商品价格相关的控件与价格相关
  for (let k in ex)
    if (exArr(k, xgprice))
      $(`.${k} div`).on('click', function () {
        $('.show .spxx_aside .gmxx .price').html('￥ ' + ex.price[$(this).data('eq')]);
      });

  //生成商品信息区结束

  //生成非商品信息区 html
  for (i = 0; i < data.ex[0].length; i++)
    switch (data.ex[0][i]) {
      case 'photo[]':
        {
          for (let j = 0; j < data.ex[1][i].length; j++)
            lb = `${lb}<img src="${data.ex[1][i][j]}">`;
          break;
        }

      case 'sphoto[]':
        {
          for (let j = 0; j < data.ex[1][i].length; j++)
            lb = `${lb}<img src="${data.ex[1][i][j]}">`;
          break;
        }

      //详情区
      case 'msphoto[]':
        {
          temp = '';
          for (let j = 0; j < data.ex[1][i].length; j++)
            temp = `${temp}<img src="${data.ex[1][i][j]}">`;

          //插入图片
          $('.other .o_bottom .spxxxx').html(temp);
          break;
        }
    }

  //插入轮播图片
  $('.show .lbt .aside').html(lb);

  //为选项控件添加事件
  $('.show .spxx_aside .xuanx').delegate('div', 'click', function () {
    $(this.parentNode).data('v', $(this).text());
    $(this.parentNode.children).removeClass('active');
    $(this).addClass('active');
  });

  //商品轮播图
  lbFodeContro($('.show .lbt .main'), $('.show .lbt .aside img'), $('.show .lbt .main').height(), 3000, 0);
});

//绑定计数事件
count($('.show .gm_count .add'), $('.show .gm_count .jian'), $('.show .gm_count .num'));

//添加到购物车
$('.show .spxx_aside .btns .car').on('click', function () {
  let eles = $('.show .spxx_aside .gmxx .xuanx');               //获取所有需要选择的元素
  let data = { stop: 0 };                                       //准备数据

  data.name = $('.show .spxx_aside .sp_name').text();

  //遍历选项，获取数据
  $.each(eles, function (i, ele) {
    $(ele).removeClass('xuanx');

    //若存在未选择项，终止操作
    if ($(ele).data('v') == '') {
      mes('mes', '请选择' + xuanx[1][$(ele).prop('class')]);
      data.stop = 1;
      $(ele).addClass('xuanx');
      return false;
    }
    data[$(ele).prop('class')] = $(ele).data('v');
    $(ele).addClass('xuanx');
  });

  if (data.stop) return;

  data.id = $('.spxinxi').data('id');
  data.count = $('.show .gm_count .num').text();
  data.price = ($('.show .gmxx .price').text()).split(' ')[1];

  console.log(JSON.stringify(data));
  $.post('http://store.com/index/Car/add', {
    data: JSON.stringify(data)
  }, function (data) {
    mes('mes', data);
  });
});

//立即购买
$('.show .spxx_aside .btns .get').on('click', function () {
  let eles = $('.show .spxx_aside .gmxx .xuanx');               //获取所有需要选择的元素
  let data = { stop: 0 };                                       //准备数据

  data.name = $('.show .spxx_aside .sp_name').text();

  //遍历选项，获取数据
  $.each(eles, function (i, ele) {
    $(ele).removeClass('xuanx');

    //若存在未选择项，终止操作
    if ($(ele).data('v') == '') {
      mes('mes', '请选择' + xuanx[1][$(ele).prop('class')]);
      data.stop = 1;
      $(ele).addClass('xuanx');
      return false;
    }
    data[$(ele).prop('class')] = $(ele).data('v');
    $(ele).addClass('xuanx');
  });

  if (data.stop)  return;

  data.id = $('.spxinxi').data('id');
  data.count = $('.show .gm_count .num').text();
  data.price = ($('.show .gmxx .price').text()).split(' ')[1];
  data.single = 1;                                              //声明是单个商品

  //跳转至提交订单页
  $.get('http://store.com/index/Login/judge', function(data2){
    data2 = data2.split(',');
    if (data2[0] == '1') {                                      //已登录
      let w = window.open();
      w.location = 'http://store.com/index/index/adddd?data=' + JSON.stringify(data);
    }
    else mes('mes', '请先登录');
  });
});

//商品展示区结束 *********************************************************************************

//其它内容区开始 *********************************************************************************

//“其它内容”选项卡
xxk($('.other .o_top ul li'), $('.other .o_bottom > div'), 1);

//获取评论
$.get('http://store.com/index/pageSp/getPl?id=' + $('.spxinxi').data('id'), function(data){
  $('.other .o_bottom .plq').html(data);
});

//顶部导航特效
$('.other .o_top ul li').on('mouseenter', function(){
  $('.other .o_top ul li').removeClass('active');
  $(this).addClass('active');
});
//其它内容区结束 *********************************************************************************














