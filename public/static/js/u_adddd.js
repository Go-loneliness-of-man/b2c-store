
let data = $('.ddxx').data('ddxx');

if (data.single) {
  $.get('http://store.com/index/Dd/single?data=' + JSON.stringify(data), function (data) {
    $('.dd .all').before(data);

    //计算总价格
    let $prices = $('.dd .single .xx .price');
    let prices = 0;
    $.each($prices, function (i, ele) {
      prices += Number($(ele).text().split(' ')[1]);
    });
    $('.dd .all .prices').text('共计：￥ ' + prices);
  });
}
else {
  $.get('http://store.com/index/Dd/car?data=' + JSON.stringify(data), function (data) {
    $('.dd .all').before(data);

    //计算总价格
    let $prices = $('.dd .single .xx .price');
    let prices = 0;
    $.each($prices, function (i, ele) {
      prices += Number($(ele).text().split(' ')[1]);
    });
    $('.dd .all .prices').text('共计：￥ ' + prices);
  });
}

//支付方式
$('.dd .all .zf .wx,.dd .all .zf .zfb').on('click', function () {
  $('.dd .all .zf .wx,.dd .all .zf .zfb').removeClass('active');
  $(this).addClass('active');
  $(this.parentNode).data('type', $(this).data('type'));
});

//准备订单数据
function getData () {
  let data2 = {};

  //获取商品 id 列表
  let $single = $('.single');
  data2.sid = '';
  $.each($single, function (i, ele) {
    if (i == 0)
      data2.sid = data2.sid + $(ele).data('id');
    else
      data2.sid = data2.sid + ',' + $(ele).data('id');
  });

  //获取商品个数
  let $count = $('.single .xx .count');
  data2.count = '';
  $.each($count, function (i, ele) {
    if (i == 0)
      data2.count = data2.count + $(ele).text().split('：')[1];
    else
      data2.count = data2.count + ',' + $(ele).text().split('：')[1];
  });

  //获取选项字符串
  let $ms = $('.single .xx .ms');
  data2.ms = '';
  $.each($ms, function (i, ele) {
    if (i == 0)
      data2.ms = data2.ms + $(ele).text();
    else
      data2.ms = data2.ms + ';;;;;' + $(ele).text();
  });

  //获取商品金额
  let $price = $('.single .xx .price');
  data2.price = '';
  $.each($price, function (i, ele) {
    if (i == 0)
      data2.price = data2.price + $(ele).text().split(' ')[1];
    else
      data2.price = data2.price + ',' + $(ele).text().split(' ')[1];
  });

  data2.prices = $('.all .prices').text().split(' ')[1];          //价格
  data2.zf = $('.all .zf').data('type');                          //支付方式
  if ($('.all .phone').prop('value') == '') data2.phone = 'null'; //手机号，表内是 phone 字段
  else data2.phone = $('.all .phone').prop('value');
  if ($('.all .addr').prop('value') == '') data2.addr = 'null';   //地址，表内是 mailto 字段
  else data2.addr = $('.all .addr').prop('value');
  data2.bz = $('.all .bz').prop('value');                         //备注
  return data2;
}

//支付并提交按钮
$('.dd .btns .zf_tj').on('click', function () {
  let data2 = getData();
  data2.zfstate = 1;

  $.post('http://store.com/index/Dd/add', {
    data: JSON.stringify(data2)
  }, function () {
    window.close();
  });
});

//仅提交按钮
$('.dd .btns .tj').on('click', function () {
  let data2 = getData();
  data2.zfstate = 0;

  $.post('http://store.com/index/Dd/add', {
    data: JSON.stringify(data2)
  }, function (data) {
    window.close();
  });
});

























































