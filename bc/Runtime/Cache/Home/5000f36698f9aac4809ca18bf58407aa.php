<?php if (!defined('THINK_PATH')) exit();?><!--
$optionClickAction:点击效果,与当前选项的ID有关；
$blurAction:弃选效果；
$defaultClickAction:全部弃选效果;
-->

	
    <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">

    <link href="/Public/css/custom.css" rel="stylesheet">


<body>
<div class="container">
	<div class="row">
		<div class="well">
			<div class="row">
				<a href="/admin.php/Home/Category/insertitem/layer/2">插入</a>根目录
			</div>
			<div class="row">
				<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i; if(($t["layer"]) == "2"): ?><a href="/admin.php/Home/Category/viewitem/id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a>&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="well">
			<div class="row">
				<a href="/admin.php/Home/Category/insertitem/layer/1">插入</a>二级目录
			</div>
			<div class="row">
				<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i; if(($t["layer"]) == "1"): ?><a href="/admin.php/Home/Category/viewitem/id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a>&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
		<div class="well">
			<div class="row">
				<a href="/admin.php/Home/Category/insertitem/layer/0">插入</a>产品
			</div>
			<div class="row">
				<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i; if(($t["layer"]) == "0"): ?><a href="/admin.php/Home/Category/viewitem/id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a>&nbsp;<?php endif; endforeach; endif; else: echo "" ;endif; ?>
			</div>
		</div>
	</div>


 <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 

</body>
 </html>