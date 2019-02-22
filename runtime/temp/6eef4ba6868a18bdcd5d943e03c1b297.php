<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:142:"F:\xampp-win32-5.6.3-0-VC11-installerroot\xammp\htdocs\www\www.backend.devp\backend\public/../application/backend\view\dnspod\dnspod_list.html";i:1550835087;}*/ ?>
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
<title>Dnspod动态解析记录列表</title>
</head>
<body>
<nav class="breadcrumb">
		<i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span>Dnspod <span class="c-gray en">&gt;</span>控制台<a
			class="btn btn-success radius r" style="line-height: 1.6em; margin-top: 3px"
			href="javascript:location.replace(location.href);" title="刷新"><i class="Hui-iconfont">&#xe68f;</i></a>
 </nav>
	<div class="page-container">
		<form action="<?php echo url('dnspod/dnspod_list'); ?>" method="post">
			<div class="text-c">
				<input type="text" class="input-text" style="width: 250px" placeholder="域名"
					id="keywords" name="keywords" value="<?php echo $filter['keywords']; ?>">
				<button type="submit" class="btn btn-success radius" id="search" name="">
					<i class="Hui-iconfont">&#xe665;</i> 搜索
				</button>
			</div>
		</form>
		<div class="cl pd-5 bg-1 bk-gray mt-20">
			<?php if($filter['keywords'] != ''): ?>
			<span class="l"> <a href="javascript:;" onclick="dnspod_add('添加记录','<?php echo url('dnspod/dnspod_add'); ?>?domain=<?php echo $filter['keywords']; ?>','600','350')"
				class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i>添加记录</a>
			</span>
			<?php endif; ?>
			 <span class="r">共有数据：<strong><?php echo (isset($filter['total']) && ($filter['total'] !== '')?$filter['total']:0); ?></strong>条
			</span>
		</div>
		<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">				
				<thead>
				    <tr role="row"><th scope="col" colspan="14" rowspan="1">注：dnspod域名动态解析</th></tr>
					<tr class="text-c">
						<th width="200">主机记录</th>
						<th width="200">记录值</th>								
						<th width="250">更新时间</th>	
						<th width="350">操作</th>
					</tr>
				</thead>
				<tbody>
					<!-- <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
					<tr class="text-c">
						<td><?php echo $vo['name']; ?></td>		
						<td><?php echo $vo['value']; ?></td>										
						<td><?php echo !empty($vo['updated_on'])?$vo['updated_on']:'-'; ?></td>											
						<td class="td-manage">														
								<a title="删除" href="javascript:;" onclick="dnspod_del(this,'<?php echo $vo['id']; ?>')"
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
			  {"orderable":false,"aTargets":[0,1,2,3]}// 制定列不参与排序
			]
		});		
	});
	/*域名解析-添加*/
	function dnspod_add(title,url,w,h){
		layer_show(title,url,w,h);
	}
	/*域名解析-编辑*/
	function  dnspod_edit(title,url,id,w,h){
		var url = url +'?id='+id;
		layer_show(title,url,w,h);
	}
	/*域名解析-删除*/
	function  dnspod_del(obj,id){
		layer.confirm('确认要删除吗？',function(index){
			$.ajax({
				type: 'POST',
				url: '<?php echo url("dnspod/dnspod_del"); ?>',
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