//轮播区开始 *********************************************************************************

//轮播区侧栏背景色变化
$('.lbt_par .aside ul li').on('mouseenter', function () {
  $('.lbt_par .aside ul li').removeClass('active');
  $(this).addClass('active');
});
$('.lbt_par').on('mouseleave', function () {
  $('.lbt_par .aside ul li').removeClass('active');
});

//生成轮播区推荐商品及轮播图
$.get('http://store.com/index/lb/getNavAside', function (data) {

  //生成侧栏
  $('.lbt_par .aside ul').html(data);

  //生成轮播区推荐商品主栏
  $.get('http://store.com/index/lb/asideSp', function (data) {
    $('.lbt_par').html($('.lbt_par').html() + data);

    //轮播区选项卡
    xxk($('.lbt_par .aside ul li'), $('.lbt_par .main'), 0);

    //轮播区二级分类隐藏
    $('.lbt_par').on('mouseleave', function () {
      $('.lbt_par .main').css({
        display: 'none'
      });
    });

    //轮播图，参数依次是目标元素（jq 对象）、元素高度、换元素时间、渐变时间、第一个元素的下标、图片路径数组
    lbFode($('.lbFode'), $('.lbt .lb_radius'), $('.lbt').height(), 3000, 1000, 0, [
      '/static/iva/lb1.jpg',
      '/static/iva/lb2.jpg',
      '/static/iva/lb3.jpg',
      '/static/iva/lb4.jpg',
      '/static/iva/lb5.jpg'
    ]);
  });
});

//轮播区结束 **************************************************************************************

//商品类及其它开始 *********************************************************************************

//生成商品类，传递需要生成商品类的 id
$.get('http://store.com/index/Other/getSpClass?idlb=1,4,5,8,40,41', function (data) {
  $('.hot').after(data);

  //商品类的选项卡，需要传入控件数组、盒子数组，当存在多个商品选项卡时，可给每个选项卡额外加个类名来唯一标识，比如 sp_class + id 的形式
  xxk($('.sp_class1 .top ul li'), $('.sp_class1 .main'), 1);
  xxk($('.sp_class4 .top ul li'), $('.sp_class4 .main'), 1);
  xxk($('.sp_class5 .top ul li'), $('.sp_class5 .main'), 1);
  xxk($('.sp_class8 .top ul li'), $('.sp_class8 .main'), 1);
  xxk($('.sp_class40 .top ul li'), $('.sp_class40 .main'), 1);
  xxk($('.sp_class41 .top ul li'), $('.sp_class41 .main'), 1);
});

//展示推荐商品，传递需要生成推荐商品的商品类的 id
$.get('http://store.com/index/Other/getWntj?idlb=1,4,5,8,40,41', function (data) {
  $('.b_recom .recom_b').html(data);

  //底部推荐，单行点击滑动
  dhhd($('.b_recom .recom_top .contr .l'), $('.b_recom .recom_top .contr .r'), $('.b_recom .recom_b figure'), 108.7 * 4, '%', 600, 4);
});

//展示热点商品
$.get('http://store.com/index/Other/getHot', function (data) {
  $('.hot').html('<h2>热点产品</h2>' + data);
});
//商品类及其它结束 *********************************************************************************















