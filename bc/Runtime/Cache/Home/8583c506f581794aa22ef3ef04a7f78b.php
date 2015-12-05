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
<a href="/index.php/Home/Category/">首页</a>
<?php if(is_array($items)): foreach($items as $key=>$t): ?><a href="/index.php/Home/Category/viewitem/id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a><p></p><?php echo ($t["function"]); ?><p></p>
<p><a href="/index.php/Home/Category/insertitem/fatherID/<?php echo ($t["id"]); ?>/layer/<?php echo ($t["layer-1"]); ?>">新增下一级</a></p>
<p><a href="/index.php/Home/Category/deleteitem/id/<?php echo ($t["id"]); ?>">删除</a></p><?php endforeach; endif; ?>
<form action="searchitem" method="post">
<input name="key" placeholder="二维码or name"/>
<button type="submit">查询</button>
</form>
<?php echo ($page); ?>
</body>
 </html>