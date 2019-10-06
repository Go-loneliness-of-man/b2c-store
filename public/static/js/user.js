//会员列表模块开始 ***********************************************************************************
$('#aside .lbparent .lbx:eq(15)').on('click', function () {
  $.get('http://store.com/admin/Hy/sech?type2=user', function (data) {
    $('.userlb16').html('<ul><li>id</li><li>头像</li><li>昵称</li><li>密码</li><li>邮箱</li><li>地址</li><li>手机号</li><li>性别</li><li>注册时间</li><li>操作</li></ul>' + data);
  });
});

$('.userlb16').delegate('ul li .del', 'click', function () {
  $ul = $(this.parentNode.parentNode);
  $.get('http://store.com/admin/Hy/del?type2=user&id=' + $ul.data('id'), function (data) {
    $ul.remove();
    mes('mes', data);
  });
});
//会员列表模块结束 ***********************************************************************************

//管理员列表模块开始 ***********************************************************************************
$('#aside .lbparent .lbx:eq(16)').on('click', function () {
  $.get('http://store.com/admin/Hy/sech?type2=admin', function (data) {
    $('.adminlb17').html('<ul><li>id</li><li>昵称</li><li>密码</li><li>角色</li><li>操作</li></ul>' + data);
  });
});

$('.adminlb17').delegate('ul li .del', 'click', function () {
  $ul = $(this.parentNode.parentNode);
  $.get('http://store.com/admin/Hy/del?type2=admin&id=' + $ul.data('id'), function (data) {
    $ul.remove();
    mes('mes', data);
  });
});
//管理员列表模块结束 ***********************************************************************************

//修改账户信息模块开始 ***********************************************************************************
$('.form18 form .btn').on('click', function () {
  let $data = $('.form18 form');
  data = new FormData($data[0]);                      //准备表单数据

  let link = new XMLHttpRequest();
  link.open('POST', 'http://store.com/admin/Hy/re', true);

  link.onreadystatechange = function () {
    if (link.readyState == 4) {
      mes('mes', link.responseText);
      console.log(link.responseText);
      $('.form18 form input').prop('value', '');      //清空
    }
  }

  link.send(data);
});
//修改账户信息模块结束 ***********************************************************************************

//新增账户模块开始 ***********************************************************************************

//表单切换
$('.aside19 ul li').on('click', function () {
  $('.form19 form').css('display', 'none');
  $('.form19 form:eq(' + $(this).index() + ')').css('display', 'block');
});

//提交用户表单
$('.form19 form:eq(0) .btn').on('click', function () {

  $data = $('.form19 form:eq(0)')[0];                               //获取表单

  //合法性检验开始
  if ($data.name.value == '') {
    mes('mes', '昵称不能为空');
    return;
  }
  else if ($data.mail.value == '') {
    mes('mes', '邮箱不能为空');
    return;
  }
  else if ($data.pwd.value == '') {
    mes('mes', '密码不能为空');
    return;
  }
  else if ($data.adrs.value == '') {
    mes('mes', '地址不能为空');
    return;
  }
  else if ($data.sex.value == '') {
    mes('mes', '性别不能为空');
    return;
  }
  else if ($data.head.value == '') {
    mes('mes', '请选择头像');
    return;
  }
  //合法性检验结束

  data = new FormData($data);                                       //准备表单数据

  let link = new XMLHttpRequest();
  link.open('POST', 'http://store.com/admin/Hy/add?type2=user', true);

  link.onreadystatechange = function () {
    if (link.readyState == 4) {
      mes('mes', link.responseText);
      $('.form19 form:eq(0) input').prop('value', '');              //清空
    }
  }

  link.send(data);
});

//提交管理员表单
$('.form19 form:eq(1) .btn').on('click', function () {
  $data = $('.form19 form:eq(1)')[0];                               //获取表单

  //合法性检验开始
  if ($data.name.value == '') {
    mes('mes', '昵称不能为空');
    return;
  }
  else if ($data.pwd.value == '') {
    mes('mes', '密码不能为空');
    return;
  }
  else if ($data.type.value == '') {
    mes('mes', '角色不能为空');
    return;
  }
  else if ($data.type.value != 'super' && $data.type.value != 'shoper') {
    mes('mes', '目前管理员角色只有 super、shoper');
    return;
  }
  //合法性检验结束

  $.post('http://store.com/admin/Hy/add?type2=admin', {
    name: $data.name.value,
    pwd: $data.pwd.value,
    type: $data.type.value
  }, function (data) {
    mes('mes', data);
    $('.form19 form:eq(1) input').prop('value', '');              //清空
  });
});


//新增账户模块结束 ***********************************************************************************



























