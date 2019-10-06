
// 订单列表模块开始 ****************************************************************************
$.get('http://store.com/admin/ddlist/sech?num=1', function (data) {
  $('.ddlb7').html('<ul><li>订单号</li><li>订单状态</li><li>发货状态</li><li>订单总额</li><li>下单时间</li><li>用户名</li><li>收货人手机号</li><li>收货地址</li><li>支付状态</li><li>操作</li></ul>' + data);
});

//分页按钮
$('.fenye7 ul li:lt(15)').on('click', function () {
  $.get('http://store.com/admin/ddlist/sech?num=' + $(this).text(), function (data) {
    $('.ddlb7').html('<ul><li>订单号</li><li>订单状态</li><li>发货状态</li><li>订单总额</li><li>下单时间</li><li>用户名</li><li>收货人手机号</li><li>收货地址</li><li>支付状态</li><li>操作</li></ul>' + data);
  });
});

//分页按钮数字变动
$('.fenye7 ul li:eq(15)').on('click', function () {
  let $btn = $('.fenye7 ul li:lt(15)');

  //添加右移事件
  $.each($btn, function (i, ele) {
    if (i == 0) {
      if ($(ele).text() == 1) {
        $(ele).text('《');
        $(ele).off('click');                        //移除原事件

        //添加左移事件
        $(ele).on('click', function () {
          $.each($btn, function (i, ele) {
            if (i == 0 && $($btn[i + 1]).text() == 3) {
              $(ele).text(1);
              $(ele).off('click');                  //移除原事件
              $(ele).on('click', function () {
                $.get('http://store.com/admin/ddlist/sech?num=' + $(this).text(), function (data) {
                  $('.ddlb7').html('<ul><li>订单号</li><li>订单状态</li><li>发货状态</li><li>订单总额</li><li>下单时间</li><li>用户名</li><li>收货人手机号</li><li>收货地址</li><li>支付状态</li><li>操作</li></ul>' + data);
                });
              });
            }
            else if (i == 0) { }
            else
              $(ele).text(parseInt($(ele).text()) - 1);
          });
        });
      }
    }
    else
      $(ele).text(parseInt($(ele).text()) + 1);
  });
});

//查看商品详细信息
$('.ddlb7').delegate('ul li .ck', 'click', function () {
  $.get('http://store.com/admin/Ddlist/ckDd?id=' + $(this.parentNode.parentNode).data('id'), function (data) {
    data = JSON.parse(data);
    data = thKey(data, [
      '订单备注',
      '购买数量',
      '订单 id',
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
      '商品 id',
      '评论等级',
      '订单状态',
      '下单时间',
      '用户 id',
      '支付方式',
      '支付状态'
    ], ['bz',
        'count',
        'id',
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
        'sid',
        'star',
        'state',
        'time',
        'uid',
        'zf',
        'zfstate']);
    content = '<!DOCTYPE html><html lang="zh-CN"><head><title>订单详情</title><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"><style>body{background:#f2f2f2;}table{border-collapse:collapse;margin:50px auto;}table tr th,table tr td{padding:6px 30px;border:black 1px solid;max-width:360px;min-width:80px;}table tr th{background:rgb(95, 186, 214);color:white;}table tr td{text-align:center;}img{height:200px;}</style></head><body>' + tableAtr(data) + '</body></html>';
    let w = window.open();                          //新建窗口
    w.document.open('text/html');                   //在窗口内创建一个输出流
    w.document.write(content);                      //写入内容
    w.document.close();                             //输出并关闭输出流
  });
});

// 订单列表模块结束 ****************************************************************************

// 待发货单模块开始 ****************************************************************************
$.get('http://store.com/admin/ddfh/sech', function (data) {
  $('.dfhlb8').html('<ul><li>订单号</li><li>商品</li><li>订单总额</li><li>下单时间</li><li>用户名</li><li>收货人手机号</li><li>收货地址</li><li>支付状态</li></ul>' + data);

  //绑定事件，传递订单 id 到表单上
  $('.dfhlb8 ul').on('click', function () {
    $('.dfhlb8 ul').removeClass('active');
    $(this).addClass('active');
    $('.form8').data('id', $(this).data('id'));
  });
});

//提交订单快递等数据
$('.form8 label .btn').on('click', function () {
  let form = $('.form8')[0];

  if ($(form).data('id') == undefined) {
    mes('mes', '请先选择订单');
    return;
  }
  else if (form.kd.value == '' || form.kddh.value == '') {
    mes('mes', '公司、单号不能为空');
    return;
  }

  $.post('http://store.com/admin/ddfh/re', {
    kd: form.kd.value,
    kddh: form.kddh.value,
    id: $(form).data('id')
  }, function (data) {
    mes('mes', data);
    $('.form8 input').prop('value', '');

    let ul = $('.dfhlb8 ul');
    $.each(ul, function (i, ele) {
      if ($(form).data('id') == $(ele).data('id')) {
        $(ele).remove();
      }
    });
  });
});







// 待发货单模块结束 ****************************************************************************

// 退货单模块开始 ****************************************************************************











// 退货单模块结束 ****************************************************************************

// 售后单模块开始 ****************************************************************************











// 售后单模块结束 ****************************************************************************





















