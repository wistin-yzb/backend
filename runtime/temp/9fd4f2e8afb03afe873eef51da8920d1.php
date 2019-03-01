<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:133:"F:\xampp-win32-5.6.3-0-VC11-installerroot\xammp\htdocs\www\www.backend.devp\backend\public/../application/backend\view\all\index.html";i:1550722707;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>统计合集</title>
    <style type="text/css">
        a {
            color: #3c763d;
            text-decoration: none;
        }

        a:hover {
            color: #C30;
        }

        table {
            border: 0;
            border-collapse: separate;
            border-spacing: 1px;
            background: #bbb;
        }

        td {
            background: #fff;
            padding: 8px;
        }

        .running td {
            background: #dff0d8;
        }
    </style>
</head>
<body>
<div style="padding:10px 10px 100px 20px;">
    <table>
        <tr>
            <td>名称</td>
            <td>朋友圈</td>
            <td>微信群</td>
            <td>折线图</td>
        </tr>         
           <!-- <?php if(is_array($jsonlist) || $jsonlist instanceof \think\Collection || $jsonlist instanceof \think\Paginator): $i = 0; $__LIST__ = $jsonlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?> -->
            <tr class="running">
                <td><?php echo $vo['name']; ?></td>
                <td>朋友圈：<?php echo $vo['timeline']; ?></td>
                <td>微信群：<?php echo $vo['friend']; ?></td>
                <td>
                    <a href="http://<?php echo $vo['state_ip']; ?>/r.php?n=<?php echo $vo['name']; ?>" target="_blank">查看</a>
                    &nbsp;&nbsp;
                    <a href="http://<?php echo $vo['state_ip']; ?>/r.php?n=<?php echo $vo['name']; ?> ?>&auto=1"
                       target="_blank">自动</a>
                </td>
            </tr>
            <!-- <?php endforeach; endif; else: echo "" ;endif; ?>-->
    </table>
</div>
</body>
</html>