//商品列表模块开始 ***********************************************************************************

$('.dir2 .dir2_child').data('path', '');          //初始化上架商品模块商品类路径
$('.dir2 .dir2_child').data('pid', -1);           //初始化上架商品模块直系父级类 id

//左侧显示一级商品类
$.get('http://store.com/admin/Splist/getOneClass', function (data) {
  data = data.split('\\');                        //去掉 jq 自动加的转义字符
  $('.dir2 .dir2_child').empty().append(data);
  $('.splb2').empty().append('<ul><li>id</li><li>商品名</li><li>level</li><li>分类名</li><li>封面</li><li>售价</li><li>推荐</li><li>额外属性（JSON）</li><li>操作</li></ul>');
});

//事件委托，进入下一级类，将 path、pid 存储在 .dir2_child 上
$('.dir2 .dir2_child').delegate('li', 'click', function () {
  if (!$('.dir2 .dir2_child').data('path'))         //同步 path、pid
    $('.dir2 .dir2_child').data('path', $('.dir2 .dir2_child').data('path') + $(this).data('id'));
  else
    $('.dir2 .dir2_child').data('path', $('.dir2 .dir2_child').data('path') + ',' + $(this).data('id'));
  $('.dir2 .dir2_child').data('pid', $(this).data('id'));

  //更新目录列表
  $.get('http://store.com/admin/Splist/getSpClass?id=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.dir2 .dir2_child').empty().append(data);
  });

  //更新商品列表，展示该类下的所有商品
  $.get('http://store.com/admin/Splist/getSp?id=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.splb2').empty().append('<ul><li>id</li><li>商品名</li><li>level</li><li>分类名</li><li>封面</li><li>售价</li><li>推荐</li><li>额外属性（JSON）</li><li>操作</li></ul>' + data);
  });
});

//跳回上一级类
$('.dir2 .up').on('click', function () {
  //同步 path、pid
  var t = $('.dir2 .dir2_child').data('path').split(',');
  var temp = t[0];
  if (t.length < 2) {
    $('.dir2 .dir2_child').data('path', '');
    $('.dir2 .dir2_child').data('pid', -1);
  }
  else {
    for (let i = 1; i < t.length - 1; i++)
      temp = temp + ',' + t[i];
    $('.dir2 .dir2_child').data('path', temp);
    $('.dir2 .dir2_child').data('pid', t[t.length - 2]);
  }

  //更新目录列表
  if ($('.dir2 .dir2_child').data('pid') == -1)
    temp = 'getOneClass';
  else
    temp = 'getSpClass?id=' + $('.dir2 .dir2_child').data('pid');
  $.get('http://store.com/admin/Splist/' + temp, function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.dir2 .dir2_child').empty().append(data);
  });

  $('.splb2').empty().append('<ul><li>id</li><li>商品名</li><li>level</li><li>分类名</li><li>封面</li><li>售价</li><li>推荐</li><li>额外属性（JSON）</li><li>操作</li></ul>');

  //更新商品列表，展示该类下的所有商品
  if ($('.dir2 .dir2_child').data('pid') != -1) {
    $.get('http://store.com/admin/Splist/getSp?id=' + $('.dir2 .dir2_child').data('pid'), function (data) {
      $('.splb2').append(data);
    });
  }
});

//事件委托，删除商品类
$('.dir2 .dir2_child').delegate('li svg', 'click', function (ele) {
  ele.stopPropagation();                            //阻止事件冒泡
  $id = $(this.parentNode).data('id');              //指向其父元素

  //询问是否确定删除当前商品类
  inq('确定删除该商品类？当前操作会连带删除该商品类下的所有商品，请谨慎操作。', function () {

    //发送删除请求
    $.get('http://store.com/admin/Splist/dropSpClass?id=' + $id, function (data) {
      console.log(data);
      mes('mes', data);
      //更新目录列表
      if ($('.dir2 .dir2_child').data('pid') == -1)
        temp = 'getOneClass';
      else
        temp = 'getSpClass?id=' + $('.dir2 .dir2_child').data('pid');
      $.get('http://store.com/admin/Splist/' + temp, function (data) {
        data = data.split('\\');                        //去掉 jq 自动加的转义字符
        $('.dir2 .dir2_child').empty().append(data);
      });
    });
  });
});

//商品名关键字搜索
$('.sech2 .btn').on('click', function () {
  let gjz = $('.sech2 input').prop('value');
  $.get('http://store.com/admin/Splist/sechSp?gjz=' + gjz, function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.splb2').empty().append('<ul><li>id</li><li>商品名</li><li>level</li><li>分类名</li><li>封面</li><li>售价</li><li>推荐</li><li>额外属性（JSON）</li><li>操作</li></ul>' + data);
  });
});

//查看商品详细信息
$('.splb2').delegate('ul li .ck', 'click', function () {
  $.get('http://store.com/admin/Splist/ckSp?id=' + $(this.parentNode.parentNode).data('id'), function (data) {
    data = JSON.parse(data);
    content = '<!DOCTYPE html><html lang="zh-CN"><head><title>' + data.name + '</title><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"><style>body{background:#f2f2f2;}table{border-collapse:collapse;margin:50px auto;}table tr th,table tr td{padding:6px 30px;border:black 1px solid;max-width:360px;min-width:80px;}table tr th{background:rgb(95, 186, 214);color:white;}table tr td{text-align:center;}img{height:200px;}</style></head><body>' + tableAtr(data) + tableObj(data) + tableImg(data) + '</body></html>';
    let w = window.open();                          //新建窗口
    w.document.open('text/html');                   //在窗口内创建一个输出流
    w.document.write(content);                      //写入内容
    w.document.close();                             //输出并关闭输出流
  });
});

//查看商品所有评论
$('.splb2').delegate('', 'click', function () {

});

//删除商品
$('.splb2').delegate('ul li .del', 'click', function () {
  $this = $(this.parentNode.parentNode);
  $.get('http://store.com/admin/Splist/dropSp?id=' + $this.data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    mes('mes', data);
    $this.remove();                                 //删除节点
  });
});

//商品列表模块结束 ***********************************************************************************

//上架商品模块开始 ***********************************************************************************

$('.dir3 .add').data('s', 0);                       //初始化上架商品模块添加按钮开关
$('.form3 form').data('path', '');                  //初始化上架商品模块商品类路径
$('.form3 form').data('pid', -1);                   //初始化上架商品模块直系父级类 id

//左侧显示一级商品类
$.get('http://store.com/admin/AddSp/getOneClass', function (data) {
  data = data.split('\\');                        //去掉 jq 自动加的转义字符
  $('.dir3 .dir3_child').empty().append(data);
});

//生成右侧额外字段列表
$.get('http://store.com/admin/AddSp/getExtra', function (data) {
  let ex = JSON.parse(data);                      //将 JSON 转回数组
  let right = '';                                 //右侧额外属性
  for (let i = 0; i < ex.length; i++)             //拼接字符串
    right = right + '<li data-id="' + ex[i]['id'] + '" data-k="' + ex[i]['k'] + '" data-bz="' + ex[i]['bz'] + '">' + ex[i]['name'] + '</li>';
  $('.zdlb3 ul').empty().append(right);
});

//点击右侧额外列表增加表单项
$('.zdlb3').delegate('ul li', 'click', function () {
  let form = '';
  let p = 0;
  let id = $(this).data('id');

  //与表单现有所有额外属性的 id 进行比较，判断是否重复
  $.each($('.form3 .sp_form input'), function (i, ele) {
    if (p = (id == $(ele).data('id') ? 1 : 0)) return false;
  });
  if (p) {                                          //重复，停止执行并提示
    mes('mes', '表单中已有额外属性 “' + $(this).text() + '”，不能重复添加');
    return;
  }
  if ($(this).data('bz').split(',')[0] == 'file')   //判断类型
    form = form + '<label><span class="input">' + $(this).text() + '</span><input data-id="' + $(this).data('id') + '" multiple="multiple" name="' + $(this).data('k') + '[]" placeholder="' + $(this).data('bz') + '"type="' + $(this).data('bz').split(',')[0] + '"></label>';
  else
    form = form + '<label><span class="input">' + $(this).text() + '</span><input data-id="' + $(this).data('id') + '" name="' + $(this).data('k') + '" placeholder="' + $(this).data('bz') + '"type="' + $(this).data('bz').split(',')[0] + '"></label>';
  let btn = $('.form3 .sp_form label:last').detach();   //取出提交按钮
  $('.form3 .sp_form').append(form);                //插入表单
  $('.form3 .sp_form').append(btn);                 //插入提交按钮
});

//事件委托，进入下一级类、向 form 传递 path、pid
$('.dir3 .dir3_child').delegate('li', 'click', function () {
  if (!$('.form3 form').data('path'))               //同步 path、pid
    $('.form3 form').data('path', $('.form3 form').data('path') + $(this).data('id'));
  else
    $('.form3 form').data('path', $('.form3 form').data('path') + ',' + $(this).data('id'));
  $('.form3 form').data('pid', $(this).data('id'));
  //更新目录列表
  $.get('http://store.com/admin/AddSp/getSpClass?id=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.dir3 .dir3_child').empty().append(data);
  });
});

//跳回上一级类
$('.dir3 .up').on('click', function () {
  //同步 path、pid
  var t = $('.form3 form').data('path').split(',');
  var temp = t[0];
  if (t.length < 2) {
    $('.form3 form').data('path', '');
    $('.form3 form').data('pid', -1);
  }
  else {
    for (let i = 1; i < t.length - 1; i++)
      temp = temp + ',' + t[i];
    $('.form3 form').data('path', temp);
    $('.form3 form').data('pid', t[t.length - 2]);
  }
  //更新目录列表
  if ($('.form3 form').data('pid') == -1)
    temp = 'getOneClass';
  else
    temp = 'getSpClass?id=' + $('.form3 form').data('pid');
  $.get('http://store.com/admin/AddSp/' + temp, function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.dir3 .dir3_child').empty().append(data);
  });
});

//添加按钮展开、收回商品类选项动画
$('.dir3 .add').on('click', function () {
  $(this).data('s', !$(this).data('s'));
  if ($(this).data('s'))
    $('.dir3 .add_class').css('height', '78px');
  else
    $('.dir3 .add_class').css('height', '0px');
});

//切换商品、商品类表单区
$('.dir3 .add_class li').on('click', function () {
  if ($(this).index()) {                            //商品

    //生成商品表单
    $.get('http://store.com/admin/AddSp/getExtra', function (data) {
      let ex = JSON.parse(data);                    //将 JSON 转回数组
      let form = '';                                //商品表单
      for (let i = 0; i < ex.length; i++)           //拼接字符串
        if (ex[i]['often'] == '是')                 //判断常用字段，常用字段自动生成到表单
          if (ex[i]['bz'].split(',')[0] == 'file')  //判断类型
            form = form + '<label><span class="input">' + ex[i]['name'] + '</span><input data-id="' + ex[i]['id'] + '" multiple="multiple" name="' + ex[i]['k'] + '[]" placeholder="' + ex[i]['bz'] + '"type="' + ex[i]['bz'].split(',')[0] + '"></label>';
          else
            form = form + '<label><span class="input">' + ex[i]['name'] + '</span><input data-id="' + ex[i]['id'] + '" name="' + ex[i]['k'] + '" placeholder="' + ex[i]['bz'] + '"type="' + ex[i]['bz'].split(',')[0] + '"></label>';
      $('.form3 .sp_form').empty().append('<label><span class="input">商品名称：</span><input name="name" type="text" placeholder="请输入商品名称"></label>' + form + '<label><div class="btn"><div>提</div><div>交</div></div></label>');
    });

    $('.form3 form').css('display', 'none');
    $('.form3 .sp_form').css('display', 'flex');
  }
  else {                                            //商品类
    $('.form3 .sp_form').css('display', 'none');
    $('.form3 .sp_class_form').css('display', 'flex');
  }
});

//提交商品类
$('.form3 .sp_class_form .btn').on('click', function () {
  let level = 0;
  if ($('.form3 .sp_class_form').data('path'))
    level = $('.form3 .sp_class_form').data('path').split(',').length;
  $.post('http://store.com/admin/AddSp/AddSpClass', {
    path: $('.form3 .sp_class_form').data('path'),
    level: level,
    pid: $('.form3 .sp_class_form').data('pid'),
    name: $('.form3 .sp_class_form input')[0].value,
    type: 1,
    ex: ''
  },
    function (data) {
      data = data.split('\\');                        //去掉 jq 自动加的转义字符
      mes('mes', data.toString());
      $('.form3 .sp_class_form input')[0].value = ''; //清空输入框
    });
});

//提交商品
$('.form3 .sp_form').delegate('.btn', 'click', function () {
  let $data = $('.form3 .sp_form');
  let ex = {};                                        //包含每个控件的 id、type，以 name 为 key
  let level = 0;
  let swch = 0;                                       //结束开关
  if ($data.data('pid') == -1) {
    mes('mes', '商品必须处于某个类下，请先选择类！');
    return;
  }

  $.each($('.form3 .sp_form input'), function (i, ele) {
    $ele = $(ele);
    if (i == 0) return true;                          //跳过第一个
    ex[$ele.prop('name')] = [];
    ex[$ele.prop('name')][0] = $ele.data('id');       //赋值 id
    ex[$ele.prop('name')][1] = $ele.prop('type');     //赋值 type
    if ($ele.prop('value') == '') {
      mes('mes', $ele.prop('name') + '不能为空，若没有值可填空格');
      swch = 1;
      return;
    }
  });

  if (swch) return;

  if ($('.form3 .sp_form').data('path'))
    level = $('.form3 .sp_form').data('path').split(',').length;

  let p = {                                           //商品中文名、level、pid、path、type
    name: $('.form3 .sp_form input')[0].value,
    level: level,
    pid: $data.data('pid'),
    path: $data.data('path'),
    type: 0
  };

  data = new FormData($data[0]);                      //准备表单数据
  data.append('p', JSON.stringify(p));                //转为 JSON 传输
  data.append('ex', JSON.stringify(ex));

  let link = new XMLHttpRequest();
  link.open('POST', 'http://store.com/admin/AddSp/AddSps', true);

  link.onreadystatechange = function () {
    if (link.readyState == 4) {
      mes('mes', link.responseText);
      $('.form3 .sp_form input').prop('value', '');   //清空
    }
  }

  link.send(data);//最终数据格式是 input 的 key-val 对，还有一个 p 对象保存了五个基本字段，一个 ex 对象保存了额外属性的 id、type
});

//上架商品模块结束 ***********************************************************************************

//修改商品模块开始 ***********************************************************************************

//提交表单
$('.form4 form label .btn').on('click', function () {
  $data = $('.form4 form')[0];                      //获取表单

  //合法性检测开始
  let zz = /^[^0-9]+$/i;                            //匹配非数字字符
  if (zz.test($data.id.value)) {
    mes('mes', 'id 只能是数字');
    return;
  }
  else if (zz.test($data.eq.value)) {
    mes('mes', 'eq 只能是数字');
    return;
  }
  else if ($data.type.value != 'name' && $data.type.value != 'extra') {
    mes('mes', 'type 请写 name 或 extra');
    return;
  }
  else if ($data.id.value == '' || $data.type.value == '' || $data.k.value == '' || $data.eq.value == '' || $data.v.value == '') {
    mes('mes', '各输入框均不可为空');
    return;
  }
  //合法性检测结束

  $.post('http://store.com/admin/Resp/re', {
    id: $data.id.value,
    type: $data.type.value,
    k: $data.k.value,
    eq: $data.eq.value,
    v: $data.v.value
  }, function (data) {
    $('.form4 form label input').prop('value', '');
    mes('mes', data);
  });
});

//修改商品模块结束 ***********************************************************************************

//分类推荐模块开始 ***********************************************************************************

$('.sp_class_dir5 .dir5_child').data('path', ''); //初始化分类推荐模块商品类路径
$('.sp_class_dir5 .dir5_child').data('pid', -1);  //初始化分类推荐模块直系父级类 id

//左侧显示一级商品类
$.get('http://store.com/admin/Fenclass/getOneClass', function (data) {
  data = data.split('\\');                        //去掉 jq 自动加的转义字符
  $('.sp_class_dir5 .dir5_child').empty().append(data);
  $('.sp_dir5').empty().append('<ul><li>id</li><li>name</li></ul>');
  $('.sp_tj_dir5').empty().append('<ul><li>id</li><li>name</li></ul>');
});

//事件委托，进入下一级类，将 path、pid 存储在 .dir2_child 上
$('.sp_class_dir5 .dir5_child').delegate('li', 'click', function () {
  if (!$('.sp_class_dir5 .dir5_child').data('path'))//同步 path、pid
    $('.sp_class_dir5 .dir5_child').data('path', $('.sp_class_dir5 .dir5_child').data('path') + $(this).data('id'));
  else
    $('.sp_class_dir5 .dir5_child').data('path', $('.sp_class_dir5 .dir5_child').data('path') + ',' + $(this).data('id'));
  $('.sp_class_dir5 .dir5_child').data('pid', $(this).data('id'));

  //更新商品类目录
  $.get('http://store.com/admin/Fenclass/getSpClass?id=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.sp_class_dir5 .dir5_child').empty().append(data);
  });

  //更新商品列表，展示该类下的所有商品
  $.get('http://store.com/admin/Fenclass/getSp?id=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.sp_dir5').empty().append('<ul><li>id</li><li>name</li></ul>' + data);
  });

  //更新推荐列表
  $.get('http://store.com/admin/Fenclass/getRecom?id=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.sp_tj_dir5').empty().append('<ul><li>id</li><li>name</li></ul>' + data);
  });
});

//跳回上一级类
$('.sp_class_dir5 .up').on('click', function () {
  //同步 path、pid
  var t = $('.sp_class_dir5 .dir5_child').data('path').split(',');
  var temp = t[0];
  if (t.length < 2) {
    $('.sp_class_dir5 .dir5_child').data('path', '');
    $('.sp_class_dir5 .dir5_child').data('pid', -1);
  }
  else {
    for (let i = 1; i < t.length - 1; i++)
      temp = temp + ',' + t[i];
    $('.sp_class_dir5 .dir5_child').data('path', temp);
    $('.sp_class_dir5 .dir5_child').data('pid', t[t.length - 2]);
  }

  //更新目录列表
  if ($('.sp_class_dir5 .dir5_child').data('pid') == -1)
    temp = 'getOneClass';
  else
    temp = 'getSpClass?id=' + $('.sp_class_dir5 .dir5_child').data('pid');
  $.get('http://store.com/admin/Fenclass/' + temp, function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.sp_class_dir5 .dir5_child').empty().append(data);
  });

  $('.sp_dir5').empty().append('<ul><li>id</li><li>name</li></ul>');
  $('.sp_tj_dir5').empty().append('<ul><li>id</li><li>name</li></ul>');

  //更新商品列表，展示该类下的所有商品
  if ($('.sp_class_dir5 .dir5_child').data('pid') != -1) {
    $.get('http://store.com/admin/Fenclass/getSp?id=' + $('.sp_class_dir5 .dir5_child').data('pid'), function (data) {
      data = data.split('\\');                      //去掉 jq 自动加的转义字符
      $('.sp_dir5').empty().append('<ul><li>id</li><li>name</li></ul>' + data);
    });

    //更新推荐列表
    $.get('http://store.com/admin/Fenclass/getRecom?id=' + $('.sp_class_dir5 .dir5_child').data('pid'), function (data) {
      data = data.split('\\');                        //去掉 jq 自动加的转义字符
      $('.sp_tj_dir5').empty().append('<ul><li>id</li><li>name</li></ul>' + data);
    });
  }
});

//为商品类添加推荐商品
$('.sp_dir5').delegate('ul', 'click', function () {
  $tjsp = $('.sp_tj_dir5 ul:gt(0)');
  for (let i = 0; i < $tjsp.length; i++)
    if ($($tjsp[i]).data('id') == $(this).data('id')) {
      mes('mes', '该商品已被添加到该类的推荐，请勿重复添加');
      return;
    }
  $.get('http://store.com/admin/Fenclass/addRecom?sid=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.sp_tj_dir5').append(data);
  });
});

//删除某个商品类的推荐商品
$('.sp_tj_dir5').delegate('ul', 'click', function () {
  $this = $(this);
  $.get('http://store.com/admin/Fenclass/delRecom?sid=' + $(this).data('id'), function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $this.remove();
  });
});

//分类推荐模块结束 ***********************************************************************************

//额外字段模块开始 ***********************************************************************************

//当侧栏对应 lbx 被点击时，获取所有字段并显示到字段列表中
$.get('http://store.com/admin/Extra/showExtra', function (data) {
  data = data.split('\\');                        //去掉 jq 自动加的转义字符
  $('.ewlb6').empty().append('<ul><li data-key="id">id</li><li data-key="k">k</li><li data-key="name">中文名</li><li data-key="often">常用</li><li data-key="html">自定义 html 标签</li><li data-key="css">自定义 css 样式</li><li data-key="bz">属性备注</li><li data-key="sid">具有该属性的商品 id</li><li class="del">删除</li></ul>' + data);
});

//事件委托，点击列表项展示字段值
$('.ewlb6').delegate('ul:gt(0) .edt', 'click', function () {
  $textarea = $('.zs6 textarea');                   //获取文本框
  $textarea.prop('disabled', 'disabled');           //设置禁用，禁止编辑
  //这里特意用 $textarea[0].value 的原因是 $textarea.text() 有 Bug，在 textarea 被“编辑”过后 text() 无法再修改其值，但原生 DOM 没有这个问题
  $textarea[0].value = $(this).html();              //传递属性值到文本框内
  $textarea.prop('name', $('.ewlb6 ul:eq(0) li:eq(' + $(this).index() + ')').data('key'));  //设置文本框 name
});

//事件委托，为 textarea 传递当前被点击记录的 id
$('.ewlb6').delegate('ul:gt(0)', 'click', function () {
  $('.zs6 textarea').data('id', $(this).data('id'));//将记录 id 添加到 textarea 的 data-id
});

//解除禁用，允许编辑
$('.zs6 .flex6 .edt6').on('click', function () {
  $('.zs6 form textarea').prop('disabled', '');
});

//向后台提交编辑后结果，更新数据库
$('.zs6 .flex6 .enter6').on('click', function () {
  let $textarea = $('.zs6 textarea');               //获取文本框
  let k = $textarea.prop('name');
  let v = $textarea[0].value;
  //合法性检测开始
  if ((k == 'k' || k == 'name' || k == 'ofen') && v == '') {
    mes('mes', 'k、name、often 均不能为空');
    return;
  }
  if (k == 'k') {
    let zz = /^[a-z,0-9,_]+$/i;                     //匹配字母、数字、下划线
    if (!zz.test(v)) {                              //判断 k 命名是否正确
      zz = /[^a-z,^0-9,^_]+/i;                      //匹配非法字符
      mes('mes', 'key 只能由字母、数字、下划线组成，不能包含字符 “' + zz.exec(v)[0] + '”');
      return;
    }
    let $k = $('.ewlb6 ul:gt(0) li:eq(1)');         //判断 k 是否存在重复
    for (let i = 0; i < $k.length; i++)
      if (v == $($k[i]).text()) {
        mes('mes', 'k 与已有额外属性重复');
        return;
      }
  }
  if (k == 'often' && !(v == '是' || v == '否')) {
    mes('mes', 'often 请填“是”或“否”');
    return;
  }
  //合法性检测结束

  $.post('http://store.com/admin/Extra/reExtra', { //发送 post 请求
    id: $textarea.data('id'),
    key: k,
    val: v
  }, function (data) {                             //回调函数
    mes('mes', data);                              //显示提示消息
  });
  $textarea[0].value = '';                         //清空表单
  setTimeout($('.lbparent ul .lbx:eq(5)').click(), 1000); //刷新
});

//添加新的商品额外字段
$('.form6 form .btn').on('click', function () {
  $ipt = $('.form6 form label input');              //获取输入框

  //合法性检测开始
  if ($ipt[0].value == '' || $ipt[1].value == '' || $ipt[2].value == '') {
    mes('mes', 'k、name、often 均不能为空');
    return;
  }
  let zz = /^[a-z,0-9,_]+$/i;                       //匹配字母、数字、下划线
  if (!zz.test($ipt[0].value)) {                    //判断 k 命名是否正确
    zz = /[^a-z,^0-9,^_]+/i;                        //匹配非法字符
    mes('mes', 'key 只能由字母、数字、下划线组成，不能包含字符 “' + zz.exec($ipt[0].value)[0] + '”');
    return;
  }
  let $k = $('.ewlb6 ul:gt(0) li:eq(1)');           //判断 k 是否存在重复
  for (let i = 0; i < $k.length; i++)
    if ($ipt[0].value == $($k[i]).text()) {
      mes('mes', 'key 与已有额外属性重复');
      return;
    }
  if (!($ipt[2].value == '是' || $ipt[2].value == '否')) {
    mes('mes', 'often 请填“是”或“否”');
    return;
  }
  //合法性检测结束

  $.post('http://store.com/admin/Extra/addExtra', { //发送 post 请求
    k: $ipt[0].value,
    name: $ipt[1].value,
    often: $ipt[2].value,
    html: $ipt[3].value,
    css: $ipt[4].value,
    bz: $ipt[5].value
  }, function (data) {                              //回调函数
    mes('mes', data);                               //显示提示消息
  }, 'text');
  $ipt.prop('value', '');                           //清空表单

  //刷新
  $.get('http://store.com/admin/Extra/showExtra', function (data) {
    data = data.split('\\');                        //去掉 jq 自动加的转义字符
    $('.ewlb6').empty().append('<ul><li data-key="id">id</li><li data-key="k">k</li><li data-key="name">中文名</li><li data-key="often">常用</li><li data-key="html">自定义 html 标签</li><li data-key="css">自定义 css 样式</li><li data-key="bz">属性备注</li><li data-key="sid">具有该属性的商品 id</li><li class="del">删除</li></ul>' + data);
  });
});

//删除额外字段，事件委托
$('.ewlb6').delegate('ul:gt(0) .del', 'click', function () {
  let t = this;
  $.get('http://store.com/admin/Extra/delExtra?id=' + $(this.parentNode).data('id'), function (data) {
    $(t.parentNode).remove();
    mes('mes', data);
  });
});
//额外字段模块结束 ***********************************************************************************







