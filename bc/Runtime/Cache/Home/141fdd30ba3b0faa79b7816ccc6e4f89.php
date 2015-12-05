<?php if (!defined('THINK_PATH')) exit();?><html><head></head>
<body>
<a href="/index.php/Home/bestforbaby">首页</a>
<?php if(is_array($items)): foreach($items as $key=>$t): ?><a href="/index.php/Home/bestforbaby/viewitem/id/<?php echo ($t["id"]); ?>"><?php echo ((isset($t["name"]) && ($t["name"] !== ""))?($t["name"]):'名称未定义'); ?></a><p></p><p></p>

<p><a href="/index.php/Home/bestforbaby/deleteitem/id/<?php echo ($t["id"]); ?>">删除</a></p>
<p><a href="/index.php/Home/bestforbaby/insertColor/id/<?php echo ($t["id"]); ?>">增加外观</a></p>
<p><a href="/index.php/Home/bestforbaby/insertSize/id/<?php echo ($t["id"]); ?>">增加规格</a></p><?php endforeach; endif; ?>
<form action="searchitem" method="post">
<input name="key" placeholder="二维码or name"/>
<button type="submit">查询</button>
</form>
<?php echo ($page); ?>
</body>
 </html>