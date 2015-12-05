<?php if (!defined('THINK_PATH')) exit();?><!--
$optionClickAction:点击效果,与当前选项的ID有关；
$blurAction:弃选效果；
$defaultClickAction:全部弃选效果;
-->

	
    <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">

   
<body>
<a href="/index.php/Home/Category/">管理首页</a>
名称：<?php echo ($item["name"]); ?><br>
<p class="help-block">
<a href="/index.php/Home/Category/deleteitem/id/<?php echo ($item["id"]); ?>">删除分类</a>
</p>
<br/>
<?php if(!empty($father)): ?>上级目录：<?php echo ($father["name"]); ?>
<br/>
<?php else: ?>
<?php if(($item["layer"]) < "2"): ?><a href="/index.php/Home/Category/insertitem/layer/<?php echo ($item["layer+1"]); ?>">增加上级目录</a>
<br/><?php endif; endif; ?>
   <?php if(($item["layer"]) > "0"): ?><div class="well">
		<div class="row">
			<h3>下级目录</h3>
			<p class="help-block">
			<a href="/index.php/Home/Category/insertitem/fatherID/<?php echo ($item["id"]); ?>/layer/<?php echo ($item['layer']-1); ?>">增加下级目录</a>			</p>
			<?php if(!empty($children)): if(is_array($children)): $i = 0; $__LIST__ = $children;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><a href="/index.php/Home/Category/viewitem/id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>
			<?php else: ?>

			<p>没有下一级目录</p><?php endif; ?>
		</div>
	</div><?php endif; ?>
<?php if(is_array($instructions)): foreach($instructions as $key=>$t): ?><div>
<p><?php echo ($item["name"]); ?></p>
<p><?php echo ($item["alias"]); ?></p>
<a href="/index.php/Home/Category/editInstruction/id/<?php echo ($t["id"]); ?>">修改</a>
<a href="/index.php/Home/Category/deleteInstruction/id/<?php echo ($t["id"]); ?>">删除</a>
</div><?php endforeach; endif; ?>
<a href="/index.php/Home/Category/addInstruction/id/<?php echo ($item["id"]); ?>">增加说明</a>
<a href="/index.php/Home/Category/edititem/id/<?php echo ($item["id"]); ?>">编辑</a>
 <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 

</body>
</html>