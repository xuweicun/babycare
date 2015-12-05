<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
       <!-- Loading Bootstrap -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <link rel="stylesheet" href="/Public/css/validationEngine.jquery.css">
       <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">
    <!-- Loading Validation Engine -->

<title><?php echo ((isset($title) && ($title !== ""))?($title):"BABYCARE"); ?></title>
</head>

<body>
<div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
          
          <div class="row">
           <div class="col-sm-12 col-md-12">
            <?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><p><a href="/index.php/Home/Brand/edititem/id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?>(<?php echo ((isset($t["cn_name"]) && ($t["cn_name"] !== ""))?($t["cn_name"]):"中文名称未指定"); ?>)</a>|<a href="/index.php/Home/Brand/deleteitem/id/<?php echo ($t["id"]); ?>">删除</a></p><?php endforeach; endif; else: echo "" ;endif; ?>
            <?php if(empty($items)): ?><h4>暂无数据</h4><?php endif; ?>
          </div>
          
          </div>
          <?php echo ($page); ?>
     
    </div>	
</div>
</div>
<form action="searchitem form-inline" method="post" role="search">
<input name="key" placeholder="名称"/>
<button type="submit">查询</button>
</form>

 <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 
</body>
 </html>