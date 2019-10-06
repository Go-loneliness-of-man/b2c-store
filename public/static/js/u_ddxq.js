
$.get('http://store.com/index/center/xq?id=' + $('.ddxxid').data('id'), function (data) {
  data = JSON.parse(data);

  //顶部进度条
  let $radius = $('.radius');
  let $bar = $('.bar');
  let $text = $('.text div');

  $.each($radius, function (i, ele) {
    $(ele).text(i + 1);
  });

  $($radius[0]).text('✔');
  $($radius[0]).addClass('active');

  if (data.zfstate) {
    $($radius[1]).addClass('active');
    $($radius[1]).text('✔');
    $($bar[0]).addClass('active');
  }

  if (data.mailstate) {
    $($radius[2]).addClass('active');
    $($radius[2]).text('✔');
    $($bar[1]).addClass('active');
  }

  if (data.state) {
    $($radius[3]).addClass('active');
    $($radius[3]).text('✔');
    $($bar[2]).addClass('active');
  }

  if (data.star) {
    $($radius[4]).addClass('active');
    $($radius[4]).text('✔');
    $($bar[3]).addClass('active');
  }

  for (let i = 0; i < $radius.length; i++) {
    if ($($radius[i]).text() != '✔') {
      console.log($text[i - 1]);
      $($text[i - 1]).css({ color: '#009349' });
      break;
    }
  }

  //表格
  data = thKey(data, [
    '订单备注',
    '购买数量',
    '快递公司',
    '快递单号',
    '发货状态',
    '收货地址',
    '商品特定属性描述',
    '收货人手机号',
    '订单评论',
    '评论时间',
    '商品价格',
    '订单总价',
    '评论等级',
    '订单状态',
    '下单时间',
    '支付方式',
    '支付状态'
  ], ['bz',
      'count',
      'kd',
      'kddh',
      'mailstate',
      'mailto',
      'ms',
      'phone',
      'pl',
      'pltime',
      'price',
      'prices',
      'star',
      'state',
      'time',
      'zf',
      'zfstate']);
  content = tableAtr(data);
  $('.state').after(content);
});







































































