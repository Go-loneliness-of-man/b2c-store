//顶部及导航开始 *********************************************************************************

//获取顶部导航商品类
$.get('http://store.com/index/nav/getNavTop', function (data) {
  $('nav > ul').html(data);
});

//推荐栏展开动画
$('nav ul').delegate('li', 'mouseenter', function () {

  //获取该类下的推荐商品并展示
  $.get('http://store.com/index/nav/topSp?id=' + $(this).data('id'), function (data) {
    $('.recom .child').html(data);
  });

  $('.recom').css({
    height: '240px',
    'border-top': '1px solid rgba(209, 207, 207, 0.6)',
    'box-shadow': '1px 1px 8px #bbb'
  });
});
$('.recom').on('mouseenter', function () {
  $('.recom').css({
    height: '240px',
    'border-top': '1px solid rgba(209, 207, 207, 0.6)',
    'box-shadow': '1px 1px 8px #bbb'
  });
});

//推荐栏缩回动画
$('nav ul').delegate('li', 'mouseleave', function () {
  $('.recom').css({
    height: '0px',
    'border-top': 'none',
    'box-shadow': 'none'
  });
});
$('.recom').on('mouseleave', function () {
  $('.recom').css({
    height: '0px',
    'border-top': 'none',
    'box-shadow': 'none'
  });
});

//搜索框
$('nav form div').on('click', function () {
  let name = [    //搜索时需要删掉的页面结构
    '.lbt_par,',  //首页轮播区
    '.b_recom,',  //首页“为你推荐”
    '.hot,',      //首页“热点商品”
    '.sp_class,', //首页商品类
    '.result,',   //上次的搜索结果
    '.dd,',       //提交订单页
    '.yh,',       //用户中心
    '.xq,',       //订单详情
    '.login,',    //用户登录
    '.pl,',       //评论订单页面
    '.show,',     //购买页商品展示区
    '.other,',    //购买页商品详情及评论
    '.spList'     //商品类页
  ];
  let s = '';
  for (let v in name) s = `${s} ${name[v]}`;
  $(s).remove();  //执行删除

  $.get('http://store.com/index/Search/res?gjz=' + $('nav form input').prop('value'), function (data) {
    $('.recom').after(data);

    //鼠标进入时切换商品图片
    $('.result figure figcaption .style img').on('mouseenter', function () {
      $(this.parentNode.children).removeClass('active');
      $(this).addClass('active');

      //切换图片
      $(this.parentNode.parentNode.parentNode.children[0].children[0]).prop('src', $(this).prop('src'));
    });
  });
});
//顶部及导航结束 *********************************************************************************

//验证是否已登录
$.get('http://store.com/index/Login/judge', function (data) {

  data = data.split(',');
  if (data[0] == '1')                            //已登录
    $('.nav_top ul li:eq(0)').replaceWith('<li class="a_src" data-a_src="http://store.com/index/index/center">' + data[2] + '</li>');
});




















