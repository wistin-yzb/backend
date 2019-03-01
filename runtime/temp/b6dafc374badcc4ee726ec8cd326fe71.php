<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:137:"F:\xampp-win32-5.6.3-0-VC11-installerroot\xammp\htdocs\www\www.backend.devp\backend\public/../application/backend\view\index\welcome.html";i:1550468245;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/lib/html5shiv.js"></script>
<script type="text/javascript" src="/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>我的桌面</title>
<style>
     .navtop{background-color:#f5f5f5;height:40px;line-height:40px;padding-left:5px;font-size:14px;}
     .navtop img{width:18px;height:16px;margin:0 5px;}
	.mainct{width:100%;height:400px;}
	.reflush{line-height: 1.6em; margin: 5px;}
	.bbtm{border-bottom:1px solid #ccc;}
</style>
</head>
<body>
	<div class="page-container">
		<p class="f-20 text-success navtop bbtm">
		欢迎使用<img src="https://pic.52112.com/icon/256/20180419/14689/698785.png" alt="nav-icon"/>
		<font size="4">v1.0</font>&nbsp;后台
		<a class="btn btn-success radius r reflush"  href="javascript:location.replace(location.href);" title="刷新">
		<i class="Hui-iconfont">&#xe68f;</i></a>
		</p>
		<div id="main1" class="mainct"></div>
		<div id="main2" class="mainct"></div>
		<div id="main3" class="mainct"></div>
		<!--/.分享率=分享数/访问数*100%-->
		<div id="main4" class="mainct"></div>
	</div>
	<footer class="footer mt-20">
		<div class="container">
			<p> 本后台系统由<a href="http://www.h-ui.net/" target="_blank" title="H-ui前端框架">H-ui前端框架</a>提供前端技术支持</p>
		</div>
	</footer>
	<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
	<script type="text/javascript" src="/static/echarts.min.js"></script>
	<script type="text/javascript">
	//数据来源 
	$.ajax({
        url: "<?php echo url('index/statistics'); ?>",
        type: 'GET',
        dataType: 'json',
        success: function (jsonreturn) {	
        	if ('data' in jsonreturn) {
                showChart(jsonreturn);
        	}
        },
        error: function () {
            alert('error!');
        }
    });
	
	//显示图表
	function showChart(jsonreturn){	
     let friend = [];
     let timeline = [];
     let total = [];
     let ratio = [];
     jsonreturn.key.forEach(function (element,index) {
         friend[index] = {
             name: element,
             type: 'line',
             data: jsonreturn.data[element].friend,
             markPoint: {
                 symbolSize:30,
                 data: [
                     {type: 'max', name: ''},
                     {type: 'min', name: ''}
                 ]
             },
             markLine: {
                 data: [
                     {type: 'average', name: '平均值'}
                 ]
             }
         };
         timeline[index] = {
             name: element,
             type: 'line',
             data: jsonreturn.data[element].timeline,
             markPoint: {
                 symbolSize:30,
                 data: [
                     {type: 'max', name: ''},
                     {type: 'min', name: ''}
                 ]
             },
             markLine: {
                 data: [
                     {type: 'average', name: '平均值'}
                 ]
             }
         };
         total[index] = {
             name: element,
             type: 'line',
             data: jsonreturn.data[element].total,
             markPoint: {
                 symbolSize:30,
                 data: [
                     {type: 'max', name: ''},
                     {type: 'min', name: ''}
                 ]
             },
             markLine: {
                 data: [
                     {type: 'average', name: '平均值'}
                 ]
             }
         };
         ratio[index] = {
             name: element,
             type: 'line',
             data: jsonreturn.data[element].ratio,
             markPoint: {
                 symbolSize:40,
                 data: [
                     {type: 'max', name: ''},
                     {type: 'min', name: ''}
                 ]
             },
             markLine: {
                 data: [
                     {type: 'average', name: '平均值'}
                 ]
             }
         }; 
     });
	//-----------------------------------------------------------------------------群分享
	var myChart1= echarts.init(document.getElementById('main1'));
	// 指定图表的配置项和数据
    var option1 = {
    	    title: {
    	        text: '群分享',    	        
    	    },
    	    tooltip: {
    	        trigger: 'axis'
    	    },
    	    legend: {
    	        data:jsonreturn.key
    	    },
    	    toolbox: {
    	        show: true,
    	        feature: {
    	            dataZoom: {
    	                yAxisIndex: 'none'
    	            },
    	            dataView: {readOnly: false},
    	            magicType: {type: ['line', 'bar']},
    	            restore: {},
    	            saveAsImage: {}
    	        }
    	    },
    	    xAxis:  {
    	        name:'小时',
    	        nameTextStyle: {
                    color: 'blue'
                },
    	        data: jsonreturn.hour
    	    },
    	    yAxis: {
    	    	name : '分享数',    	  
    	    	nameTextStyle: {
                    color: 'blue'
                },
    	    },
    	    series: friend
    	};
    // 使用刚指定的配置项和数据显示图表。
    myChart1.setOption(option1);
    
  //-----------------------------------------------------------------------------圈分享
    var myChart2= echarts.init(document.getElementById('main2'));
	// 指定图表的配置项和数据
    var option2 = {
    	    title: {
    	        text: '圈分享',
    	    },
    	    tooltip: {
    	        trigger: 'axis'
    	    },
    	    legend: {
    	        data:jsonreturn.key
    	    },
    	    toolbox: {
    	        show: true,
    	        feature: {
    	            dataZoom: {
    	                yAxisIndex: 'none'
    	            },
    	            dataView: {readOnly: false},
    	            magicType: {type: ['line', 'bar']},
    	            restore: {},
    	            saveAsImage: {}
    	        }
    	    },
    	    xAxis:  {
    	        name:'小时',
    	        nameTextStyle: {
                    color: 'blue'
                },
    	        data: jsonreturn.hour
    	    },
    	    yAxis: {
    	    	name : '分享数',
    	    	nameTextStyle: {
                    color: 'blue'
                },
    	    },
    	    series: timeline
    	};
    // 使用刚指定的配置项和数据显示图表。
    myChart2.setOption(option2);
    
  //-----------------------------------------------------------------------------总量
     var myChart3= echarts.init(document.getElementById('main3'));
	// 指定图表的配置项和数据
    var option3 = {
    	    title: {
    	        text: '总量',
    	    },
    	    tooltip: {
    	        trigger: 'axis'
    	    },
    	    legend: {
    	        data:jsonreturn.key  	      
    	    },
    	    toolbox: {
    	        show: true,
    	        feature: {
    	            dataZoom: {
    	                yAxisIndex: 'none'
    	            },
    	            dataView: {readOnly: false},
    	            magicType: {type: ['line', 'bar']},
    	            restore: {},
    	            saveAsImage: {}
    	        }
    	    },
    	    xAxis:  {
    	    	name:'小时',
    	    	nameTextStyle: {
                    color: 'blue'
                },
    	        data: jsonreturn.hour
    	    },
    	    yAxis: {
    	    	name : '分享数',
    	    	nameTextStyle: {
                    color: 'blue'
                },
    	    },
    	    series: total
    	};
    // 使用刚指定的配置项和数据显示图表。
    myChart3.setOption(option3);
    
    //-----------------------------------------------------------------------------分享率
     var myChart4= echarts.init(document.getElementById('main4'));
	// 指定图表的配置项和数据
    var option4 = {
    	    title: {
    	        text: '分享率',
    	    },
    	    tooltip: {
    	        trigger: 'axis'
    	    },
    	    legend: {
    	        data:jsonreturn.key
    	    },
    	    toolbox: {
    	        show: true,
    	        feature: {
    	            dataZoom: {
    	                yAxisIndex: 'none'
    	            },
    	            dataView: {readOnly: false},
    	            magicType: {type: ['line', 'bar']},
    	            restore: {},
    	            saveAsImage: {}
    	        }
    	    },
    	    xAxis:  {
    	    	name:'小时',
    	    	nameTextStyle: {
                    color: 'blue'
                },
    	        data: jsonreturn.hour
    	    },
    	    yAxis: {
    	    	name : '比例',
    	    	nameTextStyle: {
                    color: 'blue'
                },
    	    },
    	    series: ratio
    	};
      // 使用刚指定的配置项和数据显示图表。
      myChart4.setOption(option4);
	}
	</script>
</body>
</html>