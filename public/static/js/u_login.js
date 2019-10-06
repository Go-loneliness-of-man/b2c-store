
//验证是否已登录
$.get('http://store.com/index/Login/judge', function (data) {

  data = data.split(',');
  if (data[0] == '1')                            //已登录
    location.replace('http://store.com/index/index/center');
});

$('.login form .btn').on('click', function () {

  let form = $('.login form')[0];

  //合法性检验
  if (form.mail.value == '' || form.pwd.value == '') {
    mes('mes', '邮箱、密码均不能为空');
    return;
  }

  let zz = /^[0-9,a-z,A-Z]+@[0-9,a-z,A-Z]+.com$/i;  //匹配 xxx@xxx.com 格式的邮箱
  if (!zz.test(form.mail.value)) {
    mes('mes', '邮箱格式应为 xxx@xxx.com');
    return;
  }

  zz = /^[0-9,a-z,A-Z,_]+$/i;                       //密码只能由字母数字下划线组成
  if (!zz.test(form.pwd.value)) {
    mes('mes', '密码只能包含字母、数字、下划线');
    return;
  }

  //验证
  $.post('http://store.com/index/Login/judge',
    {
      mail: form.mail.value,
      pwd: form.pwd.value
    },
    function (data) {

      data = data.split(',');
      if (data[0] == '1' || data[0] == '3') {       //登录成功
        mes('mes', data[1]);
        setTimeout(function () {
          location.replace('http://store.com/index/index/center');
        }, 3000);
      }
      else {                                        //登录失败
        mes('mes', data[1]);
        $('form label input').prop('value', '');
      }
    });
});
































