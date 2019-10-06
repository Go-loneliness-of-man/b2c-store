
$.get('http://store.com/admin/Tj/getMoney', function (data) {
  let ele = echarts.init($('.top11 .tj')[0]);
  data = JSON.parse(data);

  //配置参数
  let option = {
    title: {
      text: '总营业额'
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
      data: ['总营业额']
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
        name: '总营业额',
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

$.get('http://store.com/admin/Tj/getCount', function (data) {
  let ele = echarts.init($('.top12 .tj')[0]);
  data = JSON.parse(data);

  //配置参数
  let option = {
    title: {
      text: '总订单量'
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
      data: ['总订单量']
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

$.get('http://store.com/admin/Tj/getCsucs', function (data) {
  let ele = echarts.init($('.top13 .tj')[0]);
  data = JSON.parse(data);

  //配置参数
  let option = {
    title: {
      text: '成交订单量'
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
      data: ['成交订单量']
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
        name: '成交订单量',
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

$.get('http://store.com/admin/Tj/getMoneyHtml', function (data) {
  $('.bottom11 .lb').html('<ul><li>日期</li><li>营业额</li></ul>' + data);
});

$.get('http://store.com/admin/Tj/getCountHtml', function (data) {
  $('.bottom12 .lb').html('<ul><li>日期</li><li>订单量</li></ul>' + data);
});

$.get('http://store.com/admin/Tj/getCsucsHtml', function (data) {
  $('.bottom13 .lb').html('<ul><li>日期</li><li>成交量</li></ul>' + data);
});



























































