//初始化开始
wheight = $(window).height();                         //获取可视区高度
nav_height = 50;                                      //导航条高度
$('#aside').css('height', wheight + 'px');            //设置侧栏高度
$('#main').css('height', wheight - nav_height + 'px');//设置主栏高度

//初始化滚动条
window.asideScrollBar = new scrollbot('#aside', 0).setStyle({
  "background": "rgba(180, 180, 180,0.6)",
  "z-index": "2"
},
  {
    "background": "rgb(18, 20, 24)"
  });
$('.scrollbot-scrollbar').css('width', '10px');       //设置滚动条宽度

$('.lbparent').data('s', 0);                          //初始化侧栏列表开关

//初始化侧栏列表标题序号
$.each($('.lbparent .tag'), function (i, ele) {
  $(ele).data('order', i);
});

//初始化侧栏列表项序号
$.each($('.lbparent ul .lbx'), function (i, ele) {
  $(ele).data('order', i);
});

//初始化与侧栏列表项相对应的 main_child 序号
$.each($('#main .main_child'), function (i, ele) {
  $(ele).data('order', i);
});

//默认显示首页
$('#main .main_child:eq(0)').css('display', 'block');
//初始化结束

//请求后台，根据 cookie 找到 session 判断是否为登录状态，若是则登录，否则跳转到登录页
$.get('http://store.com/admin/index/judge', function (data) {
  if (data.split(',')[0] != 1)                      //需要进行登录
    location.replace('http://store.com/admin/index/login');
});

//侧栏展开动画
$('.lbparent .tag').on('click', function () {
  let i = $(this).data('order');                      //获取下标
  let h = 60;                                         //单个列表项高度
  let c = $('.lbparent:eq(' + i + ') ul li').length;  //获取列表项个数
  $(this).data('s', !$(this).data('s'));              //打开、关闭开关
  if (c <= 1) {                                       //子元素小于等于一个不进行展开
    $('.lbparent:eq(' + i + ') ul .lbx').click();     //执行点击事件
    $('.lbparent ul .lbx').removeClass('lbact');      //移除其它 lbx 的 lbact 类
    $(this).addClass('lbact');                        //添加 lbact 类
    return;
  }

  if ($(this).data('s'))                              //判断是展开还是收缩
    $('.lbparent:eq(' + i + ') ul').css('height', h * c + 'px'); //展开
  else
    $('.lbparent:eq(' + i + ') ul').css('height', '0px');        //收缩
  window.asideScrollBar.refresh();                    //刷新滚动条尺寸
});

//侧栏弹出动画
$('#header_one li:nth-child(1)').on('click', function () {
  $('#aside').css('width', '260px');
  mengban('aside_mengban');

  //侧栏收回动画
  $('#aside_mengban').on('click', function () {
    $('#aside').css('width', '0px');
  });
});

//main_child 切换
$('.lbparent ul .lbx').on('click', function () {
  $('#main .main_child').css('display', 'none');
  $('#main .main_child:eq(' + $(this).data('order') + ')').css('display', 'block');
  $('ul .lbx,.lbparent .tag').removeClass('lbact'); //移除其它 lbx 的 lbact 类
  $(this).addClass('lbact');                        //当前 lbx 添加 lbact 类
});

//退出登录
$('header #header_two li').on('click', function () {
  $.get('http://store.com/admin/index/eExit', function (data) {
    mes('mes', data);
    setTimeout(function () {
      location.replace('http://store.com/admin/index/login');
    }, 1000);
  });
});









