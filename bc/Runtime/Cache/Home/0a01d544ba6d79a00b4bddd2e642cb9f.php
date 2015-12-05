<?php if (!defined('THINK_PATH')) exit();?><html><head></head>
<body>
<a href="/index.php/Home/Company/">首页</a>
名称：<?php echo ($item["name"]); ?>{if $item.alias}/<?php echo ($item["alias"]); ?> {/if}
国家：<?php echo ($item["country"]); ?>
始于<?php echo ($item["since"]); ?>年
<br/>


<br/>

<?php if(is_array($instructions)): foreach($instructions as $key=>$t): ?><div>
<p><?php echo ($item["name"]); ?></p>
<p><?php echo ($item["alias"]); ?></p>
<a href="/index.php/Home/Company/editInstruction/id/<?php echo ($t["id"]); ?>">修改</a>
<a href="/index.php/Home/Company/deleteInstruction/id/<?php echo ($t["id"]); ?>">删除</a>
</div><?php endforeach; endif; ?>
<a href="/index.php/Home/Company/addInstruction/id/<?php echo ($item["id"]); ?>">增加说明</a>
<a href="/index.php/Home/Company/edititem/id/<?php echo ($item["id"]); ?>">编辑</a>

</body>
</html>