
//获取操作日志
$.get('http://store.com/admin/Sy/getRz', function (data) {
  $('.czrz div').html('<ul><li>昵称</li><li>操作时间</li><li>使用权限</li><li>操作 IP</li></ul>' + data);
});
$('.lbparent ul .lbx:eq(0)').on('click', function () {
  $.get('http://store.com/admin/Sy/getRz', function (data) {
    $('.czrz div').html('<ul><li>昵称</li><li>操作时间</li><li>使用权限</li><li>操作 IP</li></ul>' + data);
  });
});

//获取登录日志
$.get('http://store.com/admin/Sy/getLogin', function (data) {
  $('.zjlogin div').html('<ul><li>昵称</li><li>登录时间</li><li>操作 IP</li></ul>' + data);
});
$('.lbparent ul .lbx:eq(0)').on('click', function () {
  $.get('http://store.com/admin/Sy/Login', function (data) {
    $('.zjlogin div').html('<ul><li>昵称</li><li>登录时间</li><li>操作 IP</li></ul>' + data);
  });
});

//获取紧急待办数据
$.get('http://store.com/admin/Sy/getJjdb', function (data) {
  data = data.split(',');
  let $text = $('.jjdb .b .single .bottom');
  $($text[0]).text(data[0]);
  $($text[1]).text(data[1]);
});
$('.lbparent ul .lbx:eq(0)').on('click', function () {
  $.get('http://store.com/admin/Sy/getJjdb', function (data) {
    data = data.split(',');
    let $text = $('.jjdb .b .single .bottom');
    $($text[0]).text(data[0]);
    $($text[1]).text(data[1]);
  });
});

$.get('http://store.com/admin/Sy/getDdTj', function (data) {
  let ele = echarts.init($('.bottom1 .ddtj .ddtjCharts')[0]);
  data = JSON.parse(data);

  //配置参数
  let option = {
    title: {
      text: '订单统计'
    },

    //数据系列颜色
    color: ['black', 'red'],

    //提示框触发条件
    tooltip: {
      trigger: 'axis',
      show: false
    },

    //右上角工具箱
    toolbox: {

      //工具箱整体是否显示
      show: true,

      //设置排列方向
      orient: 'vartical',

      //配置具体工具项
      feature: {
        mark: {
          show: true
        },

        //数据列表
        dataView: {
          show: true,

          //是否只读
          readOnly: true
        },

        //柱状、折线切换按钮
        magicType: {
          show: true,
          type: ['line', 'bar']
        },

        //还原按钮
        restore: {
          show: true
        },

        //保存为图片
        saveAsImage: {
          show: true
        }
      }
    },

    //图例名称，需与 series 中的数据系列保持一致
    legend: {
      data: ['总订单量', '总成交量']
    },

    //x 轴
    xAxis: {

      //x 轴上的项
      data: (function () {
        let y = [];
        for (let i = 0; i < 30; i++)
          y[i] = `${i + 1}`;
        return y;
      })()
    },
    yAxis: {},

    //数据缩放区域控件
    dataZoom: {
      show: true,

      //缩放变化是否实时显示
      realtime: true,

      //初始区域起始百分比
      start: 0,

      //初始区域结束百分比
      end: 40
    },

    //数据系列
    series: [
      {
        name: '总订单量',
        type: 'line',
        data: //data[0]
          (function () {
            let max = 30;
            let points = [];
            for (let i = 0; i < max; i++)
              points[i] = 20 + parseInt(Math.random() * 100);
            return points;
          })()
      },
      {
        name: '总成交量',
        type: 'line',
        data: //data[1]
          (function () {
            let max = 30;
            let points = [];
            for (let i = 0; i < max; i++)
              points[i] = 20 + parseInt(Math.random() * 100);
            return points;
          })()
      }
    ]
  };

  //将配置参数应用于图表并展示
  ele.setOption(option);
});

$.get('http://store.com/admin/Sy/getUhTj', function (data) {
  let ele = echarts.init($('.bottom1 .uhtj .uhtjCharts')[0]);
  data = JSON.parse(data);

  //配置参数
  let option = {
    title: {
      text: '用户统计'
    },

    //数据系列颜色
    color: ['red'],

    //提示框触发条件
    tooltip: {
      trigger: 'axis',
      show: false
    },

    //右上角工具箱
    toolbox: {

      //工具箱整体是否显示
      show: true,

      //设置排列方向
      orient: 'vartical',

      //配置具体工具项
      feature: {
        mark: {
          show: true
        },

        //数据列表
        dataView: {
          show: true,

          //是否只读
          readOnly: true
        },

        //柱状、折线切换按钮
        magicType: {
          show: true,
          type: ['line', 'bar']
        },

        //还原按钮
        restore: {
          show: true
        },

        //保存为图片
        saveAsImage: {
          show: true
        }
      }
    },

    //图例名称，需与 series 中的数据系列保持一致
    legend: {
      data: ['注册用户数']
    },

    //x 轴
    xAxis: {

      //x 轴上的项
      data: (function () {
        let y = [];
        for (let i = 0; i < 30; i++)
          y[i] = `${i + 1}`;
        return y;
      })()
    },
    yAxis: {},

    //数据缩放区域控件
    dataZoom: {
      show: true,

      //缩放变化是否实时显示
      realtime: true,

      //初始区域起始百分比
      start: 0,

      //初始区域结束百分比
      end: 40
    },

    //数据系列
    series: [
      {
        name: '注册用户数',
        type: 'line',
        data: //data
          (function () {
            let max = 30;
            let points = [];
            for (let i = 0; i < max; i++)
              points[i] = 20 + parseInt(Math.random() * 100);
            return points;
          })()
      }
    ]
  };

  //将配置参数应用于图表并展示
  ele.setOption(option);
});











































