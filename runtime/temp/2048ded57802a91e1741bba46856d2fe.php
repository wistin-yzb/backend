<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:141:"F:\xampp-win32-5.6.3-0-VC11-installerroot\xammp\htdocs\www\www.backend.devp\backend\public/../application/backend\view\server\server_add.html";i:1550571843;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport"
	content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<link rel="Bookmark" href="/favicon.ico">
<link rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="/lib/html5shiv.js"></script>
<script type="text/javascript" src="/lib/respond.min.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css"
	href="/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css"
	href="/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css"
	href="/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css"
	href="/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css"
	href="/static/h-ui.admin/css/style.css" />
	<link rel="stylesheet" type="text/css"
	href="/static/webuploader-0.1.5/webuploader.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->
<title>添加服务器案例</title>
<meta name="keywords" content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description" content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">	
</head>
<body>
	<article class="page-container">
		<form action="" method="post" class="form form-horizontal" id="form-server-add">
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>服务器名称：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['name']; ?>"
						placeholder="" id="name" name="name">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>排序：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['sort']; ?>" placeholder="" id="sort" name="sort">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" >备注：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['desc']; ?>"
						placeholder="" id="desc" name="desc">
				</div>
			</div>			
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>微信appId：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['app_id']; ?>"
						placeholder="" id="app_id" name="app_id">
				</div>
			</div>				
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>微信appSecret：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['app_secret']; ?>"
						placeholder="" id="app_secret" name="app_secret">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>公网ip：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['public_ip']; ?>"
						placeholder="" id="public_ip" name="public_ip">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>内网ip：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['private_ip']; ?>"
						placeholder="" id="private_ip" name="private_ip">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>百度统计id：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['baidu_id']; ?>"
						placeholder="" id="baidu_id" name="baidu_id">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;"> 返回广告url：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['back_url']; ?>"
						placeholder="" id="back_url" name="back_url">
				</div>
			</div>
			<div class="row cl mt-20 skin-minimal">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
						class="c-red">*</span>落地模式：</label>
				  <div class="radio-box" style="margin-left:15px;">
				    <input type="radio" id="d1_model1" name="d1_model" value=1 <?php if($info['d1_model'] == 1): ?>checked<?php endif; ?>>
				    <label for="d1_model1">手动</label>
				  </div>
				  <div class="radio-box">
				    <input type="radio" id="d1_model2" name="d1_model" value=2  <?php if($info['d1_model'] == 2): ?>checked<?php endif; ?>>
				    <label for="d1_model2">自动</label>
				  </div>
			  </div>		
			  <div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;">域名①：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['d1']; ?>"
						placeholder="" id="d1" name="d1">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;">域名②：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['d2']; ?>"
						placeholder="" id="d2" name="d2">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;">域名③：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['d3']; ?>"
						placeholder="" id="d3" name="d3">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;">域名④：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['d4']; ?>"
						placeholder="" id="d4" name="d4">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;">域名⑤：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['d5']; ?>"
						placeholder="" id="d5" name="d5">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;">微信js-sdk安全域验证文件：</label>
				<div class="formControls col-xs-8 col-sm-9">                             					
					  <div id="uploader" class="wu-example">
						    <!--用来存放文件信息-->
						    <div id="thelist" class="uploader-list"></div>
						    <div class="btns">
						        <div id="picker">选择文件</div>
						        <span id="ctlBtn" class="btn btn-default size-M">开始上传</span>
						    </div>
						</div>						
				</div>
			</div>
			<div class="row cl" style="margin-bottom:60px;">
				<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">				
					<button class="btn btn-primary radius"><i class="Hui-iconfont">&#xe632;</i>保存</button>					
				   <button class="btn btn-default radius" onclick="layer_close()"><i class="Hui-iconfont">&#xe66b;</i>取消</button>		
				</div>
			</div>
			<input type="hidden" id="id" name="id" value="<?php echo $info['id']; ?>" />
			<input type="hidden" id="line_id" name="line_id" value="<?php echo $info['line_id']; ?>" />
		</form>
	</article>

	<!--_footer 作为公共模版分离出去-->
	<script type="text/javascript" src="/lib/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="/lib/layer/2.4/layer.js"></script>
	<script type="text/javascript" src="/static/h-ui/js/H-ui.min.js"></script>
	<script type="text/javascript"
		src="/static/h-ui.admin/js/H-ui.admin.js"></script>
	<!--/_footer 作为公共模版分离出去-->

	<!--请在下方写此页面业务相关的脚本-->
	<script type="text/javascript"
		src="/lib/My97DatePicker/4.8/WdatePicker.js"></script>
	<script type="text/javascript"
		src="/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
	<script type="text/javascript"
		src="/lib/jquery.validation/1.14.0/validate-methods.js"></script>
	<script type="text/javascript"
		src="/lib/jquery.validation/1.14.0/messages_zh.js"></script>
	<script type="text/javascript"
		src="/static/webuploader-0.1.5/webuploader.js"></script>	
	<script>
	var BASE_URL = "/static/webuploader-0.1.5",
	$list = $("#thelist"),  
	state = "pending",
	$ctlBtn = $("#ctlBtn"),
	uploader,
	serverurl = '/fileupload.php';
	
	// 初始化Web Uploader
    var uploader = WebUploader.create({
    	auto:false,
   	    // swf文件路径
   	    swf: BASE_URL + '/Uploader.swf',
   	    // 文件接收服务端。
   	    server: serverurl, 
   	    // 选择文件的按钮。可选。
   	    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
   	    pick:  {
            id: '#picker',
            multiple:false,  //单文件上传
            label: '点击选择文件'           
        },
   	    // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
   	    resize: false,
	   	 accept: {
	   		title: 'txt',
            extensions: 'txt',
            mimeTypes: 'txt/*'
	     },
   	});
	// 当有文件被添加进队列的时候
	uploader.on( 'fileQueued', function( file ) {		
		 $list .append( '<div id="' + file.id + '" class="item">' +
	        '<h4 class="info">' + file.name + '</h4>' +
	        '<p class="state">等待上传...</p>' +
	    '</div>' );
	});
	//文件上传进度
	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
	    var $li = $( '#'+file.id ),
	        $percent = $li.find('.progress .progress-bar');
	    // 避免重复创建
	    if ( !$percent.length ) {
	        $percent = $('<div class="progress progress-striped active">' +
	          '<div class="progress-bar" role="progressbar" style="width: 0%">' +
	          '</div>' +
	        '</div>').appendTo( $li ).find('.progress-bar');
	    }
	    $li.find('p.state').text('上传中');
	    $percent.css( 'width', percentage * 100 + '%' );
	});
	//文件成功、失败处理
	uploader.on( 'uploadSuccess', function( file ) {
	    $( '#'+file.id ).find('p.state').text('已上传');
	});	
	uploader.on( 'uploadError', function( file ) {
	    $( '#'+file.id ).find('p.state').text('上传出错');
	});	
	uploader.on( 'uploadComplete', function( file ) {
	    $( '#'+file.id ).find('.progress').fadeOut();
	})
	uploader.on('all', function (type) {
            if (type === 'startUpload') {
                state = 'uploading';
            } else if (type === 'stopUpload') {
                state = 'paused';
            } else if (type === 'uploadFinished') {
                state = 'done';
            }
            if (state === 'uploading') {
            	$ctlBtn.text('暂停上传');
            } else {
            	$ctlBtn.text('开始上传');
            }
        });
	//开始上传 
	$ctlBtn.on('click', function() { 
		console.log(uploader,uploader.options.server);
        var publicId = $.trim($('#public_ip').val());
        var upcont = $.trim($('#thelist .info').text());
		if(!$('#public_ip').val()){
	    	layer.alert('请输入公网ip');return;
	    }
		if(!upcont){
	    	layer.alert('请上传txt格式的附件');return;
	    }
		uploader.options.server = 'http://' + publicId + serverurl;
		if (state === 'uploading') {
            uploader.stop();
        } else {
            uploader.upload();
        }
	});  
	</script>	
	<script type="text/javascript">
		$(function() {
			$('.skin-minimal input').iCheck({
				checkboxClass : 'icheckbox-blue',
				radioClass : 'iradio-blue',
				increaseArea : '20%'
			});
			//validation rules
			$("#form-server-add").validate({
				debug : false,
				rules : {
					name : { 
						required : true,
						minlength : 2,
						maxlength : 16
					},
					sort : {
						required : true,
					},
					app_id : {
						required : true,
					},
					app_secret : {
						required : true,
					},
					public_ip : {
						required : true,
					},
					private_ip : {
						required : true,
					},
					baidu_id : {
						required : true,
					},
				},
				messages : {
					name : {
						required : "请输入服务器名称",
						minlength : "标题长度由2~16字符组成"
					},
					sort : {
						required : "请输入排序数字",
					},
					app_id : {
						required : "请输入微信appId",
					},
					app_secret : {
						required : "请输入微信appSecret",
					},
					public_ip : {
						required : "请输入公网ip",
					},
					private_ip : {
						required : "请输入内网ip",
					},
					baidu_id : {
						required : "请输入百度统计id",
					},
				},
				onkeyup : false,
				focusCleanup : true,
				success : 'valid',
				submitHandler: function (form) {
	                var data = new FormData($(form)[0]);
	                $.ajax({
	                    type: 'POST',
	                    dataType: 'json',
	                    processData: false, // 告诉jquery不要处理数据
	                    contentType: false, // 告诉jquery不要设置contentType
	                    data: data,
	                    url: '<?php echo url("server/server_submit"); ?>',
	                    success: function(json, textStatus, xhr) {
	                            if (1===json) {
	                                layer.alert('操作成功', function(){	                                
	                                    removeIframe();	 	                                    
	                                    parent.location.reload(); 
	                                    layer_close();                           
	                                });
	                            }else if(-2===json){
	                                layer.alert('该服务器名已经存在');
	                            } else {
	                                layer.alert('操作失败');
	                            }
	                    },
	                    error: function(xhr, textStatus, errorThrown) {
	                        layer.alert('操作失败！');
	                    }
	                });
	            }
			});      		    
		});
	</script>
	<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>