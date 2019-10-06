
// 整体初始化 ****************************************************************************

//验证是否已登录
$.get('http://store.com/index/Login/judge', function (data) {

  data = data.split(',');
  if (data[0] != '1')                                   //未登录
    location.replace('http://store.com/index/index/login');
});

//侧栏选项卡
xxk($('.aside ul li'), $('.main > div'), 1);

// 订单列表开始 ****************************************************************************

//获取订单
$.get('http://store.com/index/Center/getDd', function (data) {
  $('.dd').html(data);

  //支付按钮
  $('.dd_single .btns .zf').on('click', function () {
    let $this = $(this);
    $.get('http://store.com/index/Center/zf?id=' + $(this.parentNode.parentNode.parentNode).data('id'), function (data) {
      mes('mes', data);
      $this.remove();
    });
  });

  //确认收货按钮
  $('.dd_single .btns .enter').on('click', function () {
    let $this = $(this);
    let $before = $(this.previousElementSibling);
    $.get('http://store.com/index/Center/enter?id=' + $(this.parentNode.parentNode.parentNode).data('id'), function (data) {
      mes('mes', data);
      $before.remove();
      $this.remove();
    });
  });
});

// 个人信息开始 ****************************************************************************

//获取用户信息并赋值到表单
$.get('http://store.com/index/Center/userXx', function (data) {
  data = JSON.parse(data);
  form = $('.user_xx .other')[0];
  form.name.value = data.name;
  form.pwd.value = data.pwd;
  form.adrs.value = data.adrs;
  form.phone.value = data.phone;
  form.sex.value = data.sex;
  $('.user_xx .img img').prop('src', data.head);
});

//默认禁用输入框
$('.user_xx .other label input').prop('disabled', 'disabled');

//点击“编辑”按钮，解除禁用，允许编辑
$('.user_xx .other label .edt').on('click', function () {
  $('.user_xx .other label input').prop('disabled', '');
});

//提交用户信息
$('.user_xx .other label .enter').on('click', function () {
  let form = $('.user_xx .other')[0];

  $.post('http://store.com/index/Center/re', {
    name: form.name.value,
    pwd: form.pwd.value,
    adrs: form.adrs.value,
    phone: form.phone.value,
    sex: form.sex.value
  }, function (data) {
    mes('mes', data);
    $('.user_xx .other label input').prop('disabled', 'disabled');
  });
});

//提交新头像
$('.user_xx .img .btns label .enter').on('click', function () {
  let link = new XMLHttpRequest();
  let src = $('.user_xx .img .btns form input')[0].value.split('\\');
  src = src[src.length - 1];

  link.open('POST', 'http://store.com/index/Center/re', true);

  //检测数据合法性
  let zz = /^[a-z,A-Z,0-9,_]+\.[jpgn]{3}$/i;      //匹配字母、数字、下划线
  if (!zz.test(src)) {                            //不符合规则，终止
    mes('mes', '图片名只能由字母、数字、下划线组成，并且只能上传 .jpg、.png 后缀的图片');
    return;
  }

  link.onreadystatechange = function () {
    if (link.readyState == 4)
      $('.user_xx .img img').prop('src', link.responseText);
  }

  let form = $('.user_xx .img .btns form')[0];
  form = new FormData(form);                      //准备表单数据
  link.send(form);
});

// 优惠券开始 ****************************************************************************


// 购物车开始 ****************************************************************************

$.get('http://store.com/index/car/sech', function (data) {
  $('.car .sp').html(data);

  //将后端传来的部分 unicode 码转换为汉字
  let zz = /u[a-z,0-9]+；/i;                      //准备匹配 unicode 编码
  let $ms = $('.sp .single .right .ms');          //取出 .ms 元素
  $.each($ms, function (i, ele) {
    if (zz.exec($(ele).text()) != null) {
      let uni = zz.exec($(ele).text())[0];        //取出编码部分
      let hz = uni.split('u');                    //将每段编码分割开
      let hz2 = '';                               //转换结果字符串
      let result = '';                            //插入字符串
      for (let j = 1; j < hz.length; j++)         //转换并拼接
        hz2 = hz2 + unizchina('\\u' + hz[j]);     //进行一次转换、拼接
      result = $(ele).text().replace(uni, hz2);   //替换掉原字符串中的编码部分
      $(ele).text(result);                        //将字符串插入 .ms 元素
    }
  });

  //取出购物车所有计数控件中的 .add、.jian、.num 元素
  let $add = $('.car .sp .single .right .count .add');
  let $jian = $('.car .sp .single .right .count .jian');
  let $num = $('.car .sp .single .right .count .num');

  //绑定购物车的计数事件
  for (let i = 0; i < $add.length; i++)
    count($($add[i]), $($jian[i]), $($num[i]));

  //购物车删除事件
  $('.car .sp .single .del_outer .del').on('click', function () {
    let $this = $(this.parentNode.parentNode);

    $.get('http://store.com/index/Car/del?id=' + $this.data('id'), function (data) {
      mes('mes', data);
      $this.remove();
    });
  });

  //购物车更新事件，在 time 内，若有超过一次点击，则不发送请求，继续等待 time，直到下一个 time 内不再出现 click 时再发送请求
  let ed = -1;
  let pd = 1;
  let time = 1000;
  let num;
  let temp = 0;
  $('.car .sp .single .right .count .add, .car .sp .single .right .count .jian').on('click', function () {
    let $this = $(this.parentNode.parentNode.parentNode);
    let $elenum = $(this.parentNode.children[1]);
    ed++;
    if (ed >= 0) pd = 0;

    //一个 time 内仅第一次点击能触发间歇调用
    if (pd) {
      num = setInterval(function () {
        if (temp > 0) {
          if (pd) {
            $.get('http://store.com/index/Car/re?count=' + $elenum.text() + '&id=' + $this.data('id'), function (data) {
              mes('mes', data);
            });
            clearInterval(num);                     //解除间歇调用
          }
          pd = 1;                                   //重置
          ed = -1;
        }
        temp++;
      }, time);
    }
  });

  //购物车选择事件
  $('.car .sp .single .enter').data('s', false);
  $('.car .sp .single .enter').on('click', function () {
    let $this = $(this.children[0]);                //获取小圆点

    $(this).data('s', !$(this).data('s'));
    if ($(this).data('s'))
      $this.css({ background: 'black' });
    else
      $this.css({ background: 'transparent' });
  });

  //购物车全选按钮
  $('.car .btns .all').on('click', function () {
    $('.car .sp .single .enter').data('s', true);
    $('.car .sp .single .enter .radius').css({ background: 'black' });
  });

  //购物车购买按钮
  $('.car .btns .allgm').on('click', function () {
    let data = { sp: [], single: 0 };               //准备数据
    let name = $('.car .sp .single .right .sp_name');
    let style = $('.car .sp .single .right .ms');
    let num = $('.car .sp .single .right .count .num');
    let price = $('.car .sp .single .right .price');
    let single = $('.car .sp .single');
    let enter = $('.car .sp .single .enter');

    //整理商品数据
    for (let i = 0; i < name.length; i++) {
      if ($(enter[i]).data('s')) {
        data.sp[i] = {};
        data.sp[i].name = $(name[i]).text();
        data.sp[i].style = $(style[i]).text();
        data.sp[i].num = $(num[i]).text();
        data.sp[i].price = $(price[i]).text().split(' ')[1];
        data.sp[i].id = $(single[i]).data('sid');
      }
    }

    //跳转至提交订单页
    $.get('http://store.com/index/Login/judge', function (data2) {
      data2 = data2.split(',');
      if (data2[0] == '1') {                                      //已登录
        let w = window.open();
        w.location = 'http://store.com/index/index/adddd?data=' + JSON.stringify(data);
      }
      else mes('mes', '请先登录');
    });
  });
});

// 评论及查看评论 ****************************************************************************

//获取评论
$.get('http://store.com/index/Center/getPl', function (data) {
  $('.plckpl').html(data);

  $('.plckpl .single_pl .right .btns .btn').on('click', function(){
    $this = $(this);

    setTimeout(function(){
      $this.remove();
    }, 1000);
  });
});

// 退出登录 ****************************************************************************
$('.exit .btn').on('click', function () {
  $.get('http://store.com/index/Login/eexit', function (data) {
    mes('mes', data);
    setTimeout(function () {
      window.location.replace('http://store.com');
    }, 3000);
  });
});



































