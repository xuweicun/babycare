<?php if (!defined('THINK_PATH')) exit();?><!--
$optionClickAction:点击效果,与当前选项的ID有关；
$blurAction:弃选效果；
$defaultClickAction:全部弃选效果;
-->

	
    <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">

   
</head>
<body>


<div class="container">
    

<!--展示已有内容-->
<a href="/index.php/Home/Category/">首页</a> <a href="javascript:toggleElement('container')">查看所有同级物品</a> 
<div class="btn-group">
   <button type="button" class="btn btn-default btn-sm dropdown-toggle" 
      data-toggle="dropdown">
      重新选择级别 <span class="caret"></span>
   </button>
   <ul class="dropdown-menu" role="menu">
      <li><a href="/index.php/Home/Category/insertitem/layer/2">插入根目录</a></li>
      <li><a href="/index.php/Home/Category/insertitem/layer/1">插入二级目录</a></li>
      <li><a href="/index.php/Home/Category/insertitem/layer/0">插入三级目录</a></li>
      <li><a href="#">分离的链接</a></li>
   </ul>
</div>

<table id="container" style="display: none;" class="table">  
<caption>所有同级物品</caption>
    <thead>
        <tr>
            <th>名称</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
    <?php if(is_array($items)): foreach($items as $key=>$t): ?><tr>
            
            <td><?php echo ($t["name"]); ?></td>
            <td><a href="/index.php/Home/Category/viewitem/id/<?php echo ($t["id"]); ?>">查看</a> <a href="/index.php/Home/Category/edititem/id/<?php echo ($t["id"]); ?>">编辑</a></td>
            
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>

 

<form action="/index.php/Home/Category/insertitem" method="post">
    <input name="name" placeholder="类目名称"/>
    <br/>
    <?php if(($layer) < "2"): ?><select name="father_id">
        <option value="0">选择上级</option>
        <?php if(is_array($father)): foreach($father as $key=>$t): if(!empty($fatherID)): if(($t["id"]) == $fatherID): ?><option value="<?php echo ($t["id"]); ?>" selected><?php echo ($t["name"]); ?></option>
                <?php else: ?>
                <option value="<?php echo ($t["id"]); ?>" ><?php echo ($t["name"]); ?></option><?php endif; ?>
            <?php else: ?>
            <option value="<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></option><?php endif; endforeach; endif; ?>
    </select>
	<a href="/index.php/Home/Category/insertitem/layer/<?php echo ($layer+1); ?>">增加新的上级目录</a> 
    <br/><?php endif; ?>  
    <input name="layer" value="<?php echo ($layer); ?>" style="display:none"/>
    <input type="submit" value="增加"/>
</form>
<?php if(($layer) == "0"): else: ?>
<a href="/index.php/Home/Category/insertitem/layer/0">插入品名</a>
<br/><?php endif; ?>
<?php if(($layer) != "1"): ?><a href="/index.php/Home/Category/insertitem/layer/1">插入类目</a><?php endif; ?>
<br/>
</div>
<script src="/Public/js/jquery-1.6.4.min.js" charset="utf-8"></script> 
<script type="text/javascript" src="/Public/js/onload.js"></script> 
<script  type="text/javascript">

</script> 

 <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 
</body>
 </html>