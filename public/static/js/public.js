
//在 body 上加个暗色蒙板，点击消失，参数是标签 id
function mengban (id) {
  $('body').append($('<div id="' + id + '"></div>').css({
    width: '100%',
    height: $(window).height() + 'px',
    background: 'rgba(0,0,0,0.7)',
    position: 'absolute',
    'z-index': '1',
    top: '0px',
    left: '0px'
  }));
  $('#' + id).on('click', function () {
    $(this).remove();
  });
}

//显示个提示消息，点击或经过三秒消失，参数是标签 id，消息内容 s
function mes (id, s) {
  let w = 28, h = 35, c = 20, temp;                     //单个字符宽、高，一行字符数，实际行宽 temp
  if (s.length > c) temp = w * c;
  else temp = w * s.length;
  $('body').append($('<div id="' + id + '">' + s + '</div>').css({
    width: temp + 'px',
    hieght: s.length / c * h + 'px',
    lineHeight: h + 'px',
    fontSize: w - 5 + 'px',
    textAlign: 'center',
    background: 'rgb(0,0,0)',
    color: 'rgb(230,230,230)',
    position: 'absolute',
    padding: 15 + 'px 20px',
    borderRadius: 10 + 'px',
    'z-index': '1',
    top: '24%',
    left: ($(window).width() - temp) / 2 + 'px'
  }));
  $('#' + id).on('click', function () {                 //点击消失
    $(this).remove();
  });
  setTimeout(function () {                              //五秒消失
    $('#' + id).remove();
  }, 3000);
}

//显示询问框，具有两个按钮，参数是消息内容 s、回调函数 hd
function inq (s, hd) {
  mengban('mengban');                                   //蒙板
  $('body').append('<div id="inq"><div class="inq_top">' + s + '</div><div class="inq_bottom"><div class="yes">确定</div><div class="no">取消</div></div></div>');

  $('#mengban').on('click', function () {               //点击蒙板退出
    $('#inq').remove();
  });

  $('.no').on('click', function () {                    //取消
    $('#inq').remove();
    $('#mengban').remove();
  });

  $('.yes').on('click', function () {                   //确定，执行回调
    hd();
    $('#mengban').remove();
    $('#inq').remove();
  });
}

//按顺序替换一个对象的键，原理是复制，不支持深拷贝，参数是被拷贝对象、新键数组、旧键数组，两数组元素一一对应
function thKey (obj, keys, vals) {
  let o = {};
  let i = 0;
  for (let i = 0; i < keys.length; i++)
    o[keys[i]] = obj[vals[i]];
  return o;
}

//将一个 input 数组的 name、value 拼接为查询字符串并返回
function ipt_s ($ipt) {
  let s = '?';                                          //准备字符串
  $.each($ipt, function (i, ele) {                      //迭代
    s = s + $ipt[i].name + '=' + $ipt[i].value;         //进行一次拼接
    if (i != $ipt.length - 1) s = s + '&';              //若不是最后一个，加 &
  });
  return s;
}

//接收商品对象，生成属性表格，不解析值为对象的属性（包括数组）
function tableAtr (obj) {
  let table = '<table border="1">';
  let th = '<tr>';
  let td = '<tr>';
  for (var atr in obj) {
    if (typeof obj[atr] != 'object') {
      th = th + '<th>' + atr + '</th>';
      td = td + '<td>' + obj[atr] + '</td>';
    }
  }
  th = th + '<tr>';
  td = td + '<tr>';
  table = table + th + td + '<table>';
  return table;
}

//接收商品对象，生成属性表格，只解析值为对象的属性，每个属性单独解析为一个表格，该属性应该具有两个数组，第一个数组存储标题 th，第二个数组存储对应的值 td
function tableObj (obj) {
  let table = '';
  let max = 0;
  for (var atr in obj) {
    if (typeof obj[atr] == 'object') {              //判断对象

      table = table + '<table border="1">';
      let th = '<tr>';
      let td = '';

      for (var atr2 in obj[atr][0])                 //生成 th
        th = th + '<th>' + obj[atr][0][atr2] + '</th>';
      th = th + '</tr>';

      for (var atr3 in obj[atr][1])
        if (obj[atr][1][atr3].length > max)         //获取最大长度
          max = obj[atr][1][atr3].length;

      for (let i = 0; i < max; i++) {               //生成 td
        td = td + '<tr>';
        for (var atr4 in obj[atr][1])               //一行 tr
          if ((typeof obj[atr][1][atr4][i]) == 'undefined')
            td = td + '<td>' + '--' + '</td>';
          else
            td = td + '<td>' + obj[atr][1][atr4][i] + '</td>';
        td = td + '</tr>';
      }
      table = table + th + td + '</table>';         //完成当前 table
    }
  }
  return table;
}

//接收商品对象，生成图片列表，只解析值为对象的属性，并且只将其中的图片用 html 表示出来，该属性应该具有两个数组，第一个数组存储标题 th，第二个数组存储对应的值 td
function tableImg (obj) {
  let imgs = '';
  for (var atr in obj) {
    if (typeof obj[atr] == 'object') {              //判断对象
      for (var atr2 in obj[atr][0]) {
        if ((obj[atr][0][atr2].split('[]')[1]) == '') {         //判断是否是图片
          imgs = imgs + '<h2>' + obj[atr][0][atr2] + '</h2>';   //生成标题
          for (var atr3 in obj[atr][1][atr2])                   //生成图片
            imgs = imgs + '<img src="http://store.com' + obj[atr][1][atr2][atr3] + '" alt=""/>';
        }
      }
    }
  }
  return imgs;
}

//多图背景淡入淡出，参数依次是目标元素（jq 对象）、图片高度、换图时间、渐变时间、图总数、第一张图的下标、路径数组
function bgFode ($targ, h, time, jbtime, count, eq, src) {
  for (let i = 0; i < count; i++)                           //生成元素
    $targ.append('<div class="fodeBg"></div>');
  $bg = $('.fodeBg');
  $bg.css({                                               //设置样式
    width: '100%',
    position: 'absolute',
    top: '0px',
    transition: 'all ' + (jbtime / 1000) + 's',
    height: h + 'px',
    opacity: 0
  });
  $.each($bg, function (i, img) {                         //设置路径并使其层叠
    $(img).css({
      background: 'url(' + src[i] + ') center/cover',
      'z-index': '-' + (i + 1)
    });
  });
  $($bg[eq]).css({ 'opacity': 1 });                       //显示第一张图
  eq++;
  setInterval(function () {                               //循环淡入淡出
    $bg.css({ 'opacity': 0 });                            //所有淡出
    $($bg[eq]).css({ 'opacity': 1 });                     //下一个淡入
    eq++;
    if (eq > count - 1) eq = 0;
  }, time);
}

//淡入淡出轮播图，参数依次是轮播元素数组（jq 对象）、轮播图小圆点父元素（jq 对象）、元素高度、换元素时间、渐变时间、第一个元素的下标、图片路径数组
//注：小圆点类名为 lb_radius_c
function lbFode ($bg, $radius, h, time, jbtime, eq, src) {
  let count = src.length;                                 //元素总数
  let num;                                                //间歇调用编号
  let temp = '';                                          //临时变量

  $bg.css({                                               //设置轮播元素样式
    width: '100%',
    position: 'absolute',
    top: '0px',
    transition: 'all ' + (jbtime / 1000) + 's',
    height: h + 'px',
    opacity: 0,
    cursor: 'pointer'
  });

  $.each($bg, function (i, img) {                         //依次设置图片路径并使其层叠，并生成小圆点
    $(img).css({
      background: 'url(' + src[i] + ') center/cover',
      'z-index': i
    });
    temp += '<div class="lb_radius_c" data-eq="' + i + '"></div>';
  });

  $radius.html(temp);                                     //插入小圆点
  let $radius_c = $('.lb_radius_c');                      //获取小圆点

  //循环渐变
  function loop () {
    num = setInterval(function () {                       //循环淡入淡出
      $bg.css({ 'opacity': 0 });                          //所有淡出
      $radius_c.css({ background: 'rgba(0,0,0,0.6)' });   //小圆点变黑
      $($bg[eq]).css({ 'opacity': 1 });                   //下一个淡入
      $($radius_c[eq]).css({ background: 'rgba(255,255,255,0.6)' });  //小圆点变白
      eq++;
      if (eq > count - 1) eq = 0;
    }, time);
  }

  //点击小圆点，切换图片
  $radius_c.on('click', function () {
    clearInterval(num);
    eq = $(this).data('eq');
    $bg.css({ 'opacity': 0 });                            //所有淡出
    $($bg[eq]).css({ 'opacity': 1 });                     //小圆点所代表的轮播元素淡入
    $radius_c.css({ background: 'rgba(0,0,0,0.6)' });     //小圆点变黑
    $($radius_c[eq]).css({ background: 'rgba(255,255,255,0.6)' });  //小圆点变白
    loop();                                               //继续轮播
  });

  $($bg[eq]).css({ 'opacity': 1 });                       //显示第一个元素
  $($radius_c[eq]).css({ background: 'rgba(255,255,255,0.6)' });  //小圆点变白
  eq++;
  loop();
}

//切换轮播图（控件为缩略图），参数依次是轮播元素数组（jq 对象）、缩略图数组（jq 对象）、元素高度、换元素时间、第一个元素的下标
function lbFodeContro ($bg, $contro, h, time, eq) {
  let count = $contro.length;                             //元素总数
  let num;                                                //间歇调用编号

  $bg.css({                                               //设置轮播元素样式
    height: h,
    cursor: 'pointer'
  });

  //存储下标
  $.each($contro, function (i, img) {
    $(img).data('eq', i);
  });

  //循环渐变
  function loop () {
    num = setInterval(function () {                       //循环
      eq++;
      if (eq > count - 1) eq = 0;
      $bg.css({ background: 'url(' + $($contro[eq]).prop('src') + ') center/cover' });//切换
    }, time);
  }

  //点击缩略图，切换图片
  $contro.on('click', function () {
    clearInterval(num);
    eq = $(this).data('eq');
    $bg.css({ background: 'url(' + $($contro[eq]).prop('src') + ') center/cover' });//切换
    loop();                                               //继续轮播
  });

  $bg.css({ background: 'url(' + $($contro[eq]).prop('src') + ') center/cover' });//切换
  loop();
}

//单行滑动，点击一次按钮滑动，需要事先做好布局，参数依次是左、右按钮、所有移动项、每次点击时 items 增/减的 translateX() 的值、值的单位、滑动时间、每次滑动的元素个数
function dhhd ($l, $r, $items, dist, dw, time, count) {

  //初始化
  let dist_r = 0;                                          //位移
  let c = 0;                                               //当前右移次数
  let top = $items.length / count - 1;                     //计算右移最大次数

  $items.css({
    transform: 'translateX(0%)',
    transition: 'all ' + (time / 1000) + 's'
  });

  $l.on('click', function () {
    if (c > 0) {                                           //当右移次数小于等于 0 时，不能向左移动
      dist_r += dist;
      $items.css('transform', 'translateX(' + (dist_r + dw) + ')');
      c--;
    }
  });

  $r.on('click', function () {
    if (c < top) {                                         //到达末尾，无法再向右移动
      c++;
      dist_r -= dist;
      $items.css('transform', 'translateX(' + (dist_r + dw) + ')');
    }
  });
}

//选项卡，参数依次是控件数组（jq 对象）、被切换元素（jq 对象）、开关 s（1、0，用于确定是否默认显示第一个）
function xxk ($contr, $box, s) {

  //初始化
  if (s) {
    $($box[0]).css({ display: 'flex' });
    $($contr[0]).addClass('active');
  }

  $.each($contr, function (i, ele) {
    $(ele).data('eq', i);
  });

  $contr.on('mouseenter', function () {
    $box.css({ display: 'none' });                          //隐藏所有
    $contr.removeClass('active');                           //移除所有 active
    $($contr[$(this).data('eq')]).addClass('active');       //添加 active
    $($box[$(this).data('eq')]).css({ display: 'flex' });   //显示对应元素
  });
}

//将 cookie 解析为对象
function getCookie () {
  let c = decodeURIComponent(document.cookie).split(';');
  let k;
  let v;
  let data = {};
  for (let temp in c) {
    k = c[temp].split('=')[0].trim();                     //去掉前后空格
    v = c[temp].split('=')[1].trim();
    data[k] = v;
  }
  return data;
}

//变量查询表，用于记录项目中不容易看懂的变量名，接收变量名，返回变量的注释
function varHash (k) {
  let hash = {                                            //变量查询表
    ewlb6: '后台额外字段模块的“额外列表盒子”，用于展示额外字段',
    sp: '商品，该变量名除单独出现外，还经常混在其它变量名中，如 sp_class、splb2 等',
    zs6: '后台额外字段模块的“属性值盒子”，用于展示属性值',
    sp_class: '商品类',
    splb2: '后台商品列表模块的“商品列表盒子”，用于展示商品记录'
  }
  for (let key in hash)
    if (k == key)
      return hash[key];
  return '该变量未收入变量查询表中';
}

//判断某值是否存在于某数组内
function exArr (v, arr) {
  for (let k in arr)
    if (arr[k] == v) return 1;  //存在
  return 0;                     //不存在
}

//计数控件，依次是加、减、数字展示元素，均为 jq 对象
function count ($add, $jian, $num) {
  $add.on('click', function () {
    $num.text(parseInt($num.text()) + 1);
  });

  $jian.on('click', function () {
    if ($num.text() > 1)
      $num.text(parseInt($num.text()) - 1);
  });
}

//方便在前端查看后端调试信息
function debug (data) {
  let w = window.open();                          //新建窗口
  w.document.open('text/html');                   //在窗口内创建一个输出流
  w.document.write(data);                         //写入内容
  w.document.close();                             //输出并关闭输出流
}

//将 unicode 编码转为中文
function unizchina (str) {
  if (!str) return;
  var len = 1;
  var result = '';
  for (var i = 0; i < str.length; i = i + len) {
    len = 1;
    var temp = str.charAt(i);
    if (temp == '\\') {
      if (str.charAt(i + 1) == 'u') {
        var unicode = str.substr((i + 2), 4);
        result += String.fromCharCode(parseInt(unicode, 16).toString(10));
        len = 6;
      }
      else result += temp;
    }
    else result += temp;
  }
  return result;
}

//页面不使用 a 元素跳转，而是采用为每个具有跳转作用的元素添加 data-a_src 属性，其属性值为跳转路径，目前将该类元素统一添加到 .a_src 类。
$('body').delegate('.a_src', 'click', function () {
  let w = window.open();                                  //新建窗口
  w.location = $(this).data('a_src');                     //跳转
});








