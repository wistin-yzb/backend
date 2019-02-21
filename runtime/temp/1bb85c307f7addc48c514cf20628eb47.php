<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:142:"F:\xampp-win32-5.6.3-0-VC11-installerroot\xammp\htdocs\www\www.backend.devp\backend\public/../application/backend\view\server\server_list.html";i:1550715508;}*/ ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport"
	content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
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
<title>服务器列表</title>
</head>
<body>
<nav class="breadcrumb">
		<i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>
		服务器列表 <span class="c-gray en">&gt;</span> <?php echo $n; ?> <a
			class="btn btn-success radius r"
			style="line-height: 1.6em; margin-top: 3px"
			href="javascript:location.replace(location.href);" title="刷新"><i
			class="Hui-iconfont">&#xe68f;</i></a>
	</nav>
	<div class="page-container">
		<form action="<?php echo url('server/server_list'); ?>" method="post">
			<div class="text-c">
			    服务器状态：
			    <span class="select-box inline">
					<select id="is_active" name="is_active" class="select">
						<option value="0" <?php if($is_active == 0): ?>selected<?php endif; ?>>全部</option>
						<option value="1" <?php if($is_active == 1): ?>selected<?php endif; ?>>正常</option>
						<option value="2" <?php if($is_active == 2): ?>selected<?php endif; ?>>关闭</option>
					</select>
				</span>
				<input type="text" class="input-text" style="width: 250px" placeholder="服务器名称"
					id="keywords" name="keywords" value="<?php echo $filter['keywords']; ?>">
				<button type="submit" class="btn btn-success radius" id="search" name="">
					<i class="Hui-iconfont">&#xe665;</i> 搜服务器
				</button>
			</div>
			<input type="hidden" name="n" value="<?php echo $n; ?>"/>
			<input type="hidden" name="line_id" value="<?php echo $line_id; ?>"/>
		</form>
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<span class="l"> <a href="javascript:;"
				onclick="server_add('添加服务器','<?php echo url('server/server_add'); ?>?line_id=<?php echo $line_id; ?>','750','700')"
				class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i>
					添加服务器</a>
			</span> <span class="r">共有数据：<strong><?php echo (isset($filter['total']) && ($filter['total'] !== '')?$filter['total']:0); ?></strong>
				条
			</span>
		</div>
		<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">				
				<thead>
				<tr role="row"><th scope="col" colspan="14" rowspan="1">注：案例&lt;&lt;<font color="#5a98de"><?php echo $n; ?></font>&gt;&gt;所有服务器列表</th></tr>
					<tr class="text-c">
						<th width="100">落地模式</th>
						<th width="200">服务器名</th>
						<th width="200">备注</th>
						<th width="200">外网ip</th>
						<th width="200">排序</th>
						<th width="200">域名1<br/><span style="border-top:1px solid #ccc;">入口|落地域名</span></th>
						<th width="200">域名2<br/><span style="border-top:1px solid #ccc;">分享备用域名</span></th>
						<th width="200">域名3<br/><span style="border-top:1px solid #ccc;">在线分享域名1</span></th>
						<th width="200">域名4<br/><span style="border-top:1px solid #ccc;">在线分享域名2</span></th>
						<th width="200">域名5<br/><span style="border-top:1px solid #ccc;">微信接口账号</span></th>
						<th width="250">更新时间</th>												
						<th width="200">使用状态</th>
						<th width="350">操作</th>
					</tr>
				</thead>
				<tbody>
					<!-- <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
					<tr class="text-c">
						<td class="td-status">
						      <?php if($vo['d1_model']==1): ?>
						       <a class="label radius" style="background-color: #5a98de;" href="javascript:void(0)">手动</a>
						       <?php else: ?>						       
						        <a class="label radius" style="background-color: #5EB95E;" href="javascript:void(0)">自动</a>
						      <?php endif; ?>
						</td>
						<td><?php echo $vo['name']; ?></td>		
						<td><?php echo $vo['desc']; ?></td>	
						<td><?php echo $vo['public_ip']; ?></td>
						<td><?php echo $vo['sort']; ?></td>
						<td><?php echo $vo['d1']; ?></td>
						<td><?php echo $vo['d2']; ?></td>
						<td><?php echo $vo['d3']; ?></td>
						<td><?php echo $vo['d4']; ?></td>
						<td><?php echo $vo['d5']; ?></td>										
						<td><?php echo !empty($vo['update_time'])?$vo['update_time']:'-'; ?></td>						
						<td class="td-status">
						      <?php if($vo['is_active']==1): ?>
						       <span class="label label-success radius">已启用</span>
						       <?php else: ?>
						       <span class="label label-defaunt radius">已停用</span>
						      <?php endif; ?>
						</td>
						<td class="td-manage">			
						     <?php if($vo['is_active']==2): ?> <a style="text-decoration: none"
								onClick="server_start(this,'<?php echo $vo['id']; ?>')" href="javascript:;" title="启用">
								<i class="Hui-iconfont">&#xe6e1;</i></a>
							  <?php else: ?>
							  <a style="text-decoration: none" onClick="server_stop(this,'<?php echo $vo['id']; ?>')" href="javascript:;" title="停用">
							  <i class="Hui-iconfont">&#xe631;</i></a>
							  <?php endif; ?>											  
								<a title="同步" style="text-decoration:none" class="ml-5" href="javascript:void(0);" onclick="server_sync(<?php echo $vo['id']; ?>)"><i>📡</i></a>
								<a title="编辑" href="javascript:;" onclick="server_edit('修改服务器','<?php echo url('server/server_add'); ?>','<?php echo $vo['id']; ?>','750','700')" class="ml-5" style="text-decoration: none">
								<i class="Hui-iconfont">&#xe6df;</i></a> 	
								<a title="删除" href="javascript:;" onclick="server_del(this,'<?php echo $vo['id']; ?>')"
								class="ml-5" style="text-decoration: none">
								<i class="Hui-iconfont">&#xe6e2;</i></a>							
						</td>
					</tr>
					<!-- <?php endforeach; endif; else: echo "" ;endif; ?> -->
				</tbody>
		</table>
		</div>
	</div>
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
		src="/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
	<script type="text/javascript" src="/lib/laypage/1.2/laypage.js"></script>
	<script type="text/javascript">
	$(function(){
		$('.table-sort').dataTable({
			 "processing": true,
			"aaSorting": [[ 1, "desc" ]],//默认第几个排序
			"bStateSave": true,//状态保存
			'searching': false,
			'ordering': false,
			'info': true,
			'autoWidth': true,
			"aoColumnDefs": [
			  //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
			  {"orderable":false,"aTargets":[0,1,2,3,4,5]}// 制定列不参与排序
			]
		});		
	});
	/*服务器-启用*/
	function server_start(obj,id){
		layer.confirm('确认要启用吗？',function(index){
			$.ajax({
				type: 'POST',
				url: '<?php echo url("server/switch_state"); ?>',
				dataType: 'json',
				data:{"id":id,"is_active":1},
				success: function(data){					
					if(data==1){
						$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="server_stop(this,'+id+')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
						$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
						$(obj).remove();
						layer.msg('已启用!',{icon: 6,time:1000});
					}else{
						layer.msg('启用失败!',{icon: 5,time:1000});
					}
				},
				error:function(data) {
					console.log(data.msg);
				},
			});
		});
	}
	/*服务器-停用*/
	function server_stop(obj,id){
		layer.confirm('确认要停用吗？',function(index){
			$.ajax({
				type: 'POST',
				url: '<?php echo url("server/switch_state"); ?>',
				dataType: 'json',
				data:{"id":id,"is_active":2},
				success: function(data){
					if(data==1){
						$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="server_start(this,'+id+')" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
						$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
						$(obj).remove();
						layer.msg('已停用!',{icon: 5,time:1000});
					}else{
						layer.msg('停用失败!',{icon: 5,time:1000});
					}				
				},
				error:function(data) {
					console.log(data.msg);
				},
			});		
		});
	}
	/*服务器-添加*/
	function server_add(title,url,w,h){
		layer_show(title,url,w,h);
	}
	/*服务器-编辑*/
	function server_edit(title,url,id,w,h){
		var url = url +'?id='+id;
		layer_show(title,url,w,h);
	}
	/*服务器-同步*/
	function server_sync(id){
	        var index = layer.load(0, {time: 100 * 1000});
	        $.ajax({
	            url: "<?php echo url('server/server_info'); ?>",
	            type: 'POST',
	            dataType: 'json',
	            data: {id: id},
	            success: function (data) {
			               console.log(data);
			               $.ajax({
			   	            url: 'http://' + data.public_ip + '/sync.php',
			   	            type: 'POST',
			   	            dataType: 'json',
			   	            data: {data: data},
			   	            success: function (returnjson) {
			   	                layer.close(index);
			   	                if (0 === returnjson.error) {
			   	                    layer.alert('同步成功');
			   	                } else {
			   	                    layer.alert(returnjson.msg);
			   	                }
			   	            },
			   	            error: function () {
			   	                layer.close(index);
			   	                layer.alert('同步失败');
			   	            }
			   	        });
	            },
	            error: function () {
	                layer.close(index);
	                layer.alert('抓取数据失败');
	            }
	        });	       
	}
	/*服务器-删除*/
	function server_del(obj,id){
		layer.confirm('确认要删除吗？',function(index){
			$.ajax({
				type: 'POST',
				url: '<?php echo url("server/server_del"); ?>',
				dataType: 'json',
				data:{"ids":id},
				success: function(data){
					if(data==1){
						$(obj).parents("tr").remove();
						layer.msg('已删除!',{icon:1,time:1000});
					}else{
						layer.msg('删除失败!',{icon: 5,time:1000});
					}
				},
				error:function(data) {
					console.log(data.msg);
				},
			});		
		});
	}
	</script>
</body>
</html>