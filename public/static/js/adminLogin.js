wheight = $(window).height();                       //获取可视区高度
$('body').css('height', wheight + 'px');            //设置 body 的高度

//背景淡入淡出
bgFode($('body'), wheight, 3000, 1500, 2, 0, ['/static/iva/bg2.PNG', '/static/iva/bg1.PNG']);

//验证登录
$('form label .btn').on('click', function () {
  form = $('form')[0];
  $.post('http://store.com/admin/index/judge', {
    name: form.name.value,
    pwd: form.pwd.value
  }, function (data) {
    data = data.split(',');
    if (data[0] == '1') {                           //登录成功
      mes('mes', data[1]);
      setTimeout(function () {
        location.replace('http://store.com/admin/index/index');
      }, 1000);
    }
    else {                                           //登录失败
      mes('mes', data[1]);
      $('form label input').prop('value', '');
    }
  });
});




