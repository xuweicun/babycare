<?php if (!defined('THINK_PATH')) exit();?><html><head></head>
<body>
<a href="/index.php/Home/Brand/">首页</a>
<?php echo ($item["name"]); ?>

<?php echo ($item["corp"]); ?>


<br/>
<img src="<?php echo ($item["img"]); ?>" alt="<?php echo ($item["name"]); ?>"/>
<?php if(is_array($instructions)): foreach($instructions as $key=>$t): ?><div>
<p><?php echo ($t["title"]); ?></p>
<p><?php echo ($t["content"]); ?></p>
<a href="/index.php/Home/Brand/editInstruction/id/<?php echo ($t["id"]); ?>">修改</a>
<a href="/index.php/Home/Brand/deleteInstruction/id/<?php echo ($t["id"]); ?>">删除</a>
</div><?php endforeach; endif; ?>
<a href="/index.php/Home/Brand/addInstruction/id/<?php echo ($item["id"]); ?>">增加说明</a>
<a href="/index.php/Home/Brand/edititem/id/<?php echo ($item["id"]); ?>">编辑</a>
<a href="/index.php/Home/Brand/insertitem/brand_id/<?php echo ($item["id"]); ?>">增加物品</a>
</body>
</html>