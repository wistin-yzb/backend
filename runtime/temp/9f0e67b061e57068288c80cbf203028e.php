<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:139:"F:\xampp-win32-5.6.3-0-VC11-installerroot\xammp\htdocs\www\www.backend.devp\backend\public/../application/backend\view\luodi\luodi_add.html";i:1550571998;}*/ ?>
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
<!--[if IE 6]>
<script type="text/javascript" src="/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<!--/meta 作为公共模版分离出去-->

<title>添加域名</title>
<meta name="keywords"
	content="H-ui.admin v3.1,H-ui网站后台模版,后台模版下载,后台管理系统模版,HTML后台模版下载">
<meta name="description"
	content="H-ui.admin v3.1，是一款由国人开发的轻量级扁平化网站后台模板，完全免费开源的网站后台管理系统模版，适合中小型CMS后台系统。">
</head>
<body>
	<article class="page-container">
		<form action="" method="post" class="form form-horizontal"
			id="form-luodi-add">
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>域名：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['domain']; ?>"
						placeholder="" id="domain" name="domain">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
					class="c-red">*</span>备注：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<textarea name="remark" id="remark" cols="" rows=""
						class="textarea" placeholder=""><?php echo $info['remark']; ?></textarea>
					<p class="textarea-numberbar">
						<em class="textarea-length">0</em>/100
					</p>
				</div>
			</div>			
			<div class="row cl">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" >解析的IP：</label>
				<div class="formControls col-xs-8 col-sm-9">
					<input type="text" class="input-text" value="<?php echo $info['ip']; ?>"
						placeholder="" id="ip" name="ip">
				</div>
			</div>				
			<div class="row cl mt-20 skin-minimal">
				<label class="form-label col-xs-3 col-sm-2" style="text-align:right;" ><span
						class="c-red">*</span>是否可用：</label>
				  <div class="radio-box" style="margin-left:15px;">
				    <input type="radio" id="status1" name="status" value=1 <?php if($info['status'] == 1): ?>checked<?php endif; ?>>
				    <label for="status1">可用</label>
				  </div>
				  <div class="radio-box">
				    <input type="radio" id="status2" name="status" value=2  <?php if($info['status'] == 2): ?>checked<?php endif; ?>>
				    <label for="status2">不可用</label>
				  </div>
			  </div>		
			<div class="row cl">
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
	<script type="text/javascript">
		$(function() {
			$('.skin-minimal input').iCheck({
				checkboxClass : 'icheckbox-blue',
				radioClass : 'iradio-blue',
				increaseArea : '20%'
			});
			//validation rules
			$("#form-luodi-add").validate({
				debug : false,
				rules : {
					domain : {
						required : true,
						minlength : 2,
						maxlength : 16
					},
					remark : {
						required : true,
					},
				},
				messages : {
					domain : {
						required : "请输入域名",
						minlength : "标题长度由2~16字符组成"
					},
					remark : {
						required : "请说点什么",
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
	                    url: '<?php echo url("luodi/luodi_submit"); ?>',
	                    success: function(json, textStatus, xhr) {
	                            if (1===json) {
	                                layer.alert('操作成功', function(){	                                
	                                    removeIframe();	 	                                    
	                                    parent.location.reload(); 
	                                    layer_close();                           
	                                });
	                            }else if(-2===json){
	                            	  layer.alert('该落地域名已经存在');
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