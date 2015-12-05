<?php if (!defined('THINK_PATH')) exit();?><html><head></head>
<body>
<a href="/index.php/Home/bestforbaby/insertitem">增加项目</a>
<a href="/index.php/Home/bestforbaby/viewitems">查看所有项目</a>
<form action="/index.php/Home/bestforbaby/searchitem" method="post">
<input name="key" placeholder="二维码/名称/品牌/厂商"/>
<button type="submit">查询</button>
</form>
</body>
 </html>