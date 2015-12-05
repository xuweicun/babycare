<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
    <!--
$optionClickAction:点击效果,与当前选项的ID有关；
$blurAction:弃选效果；
$defaultClickAction:全部弃选效果;
-->

	
    <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">

   
<title>增加规格选项</title>
</head>
<body>

    <style>
      body {
        min-height: 2000px;
        padding-top: 70px;
      }
    </style>
    <!-- Static navbar -->
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
          </button>
          <a class="navbar-brand" href="/index.php/Home/bestforbaby/index">MAMA CARE</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/index.php/Home/bestforbaby/index">首页</a></li>
            <!--<li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>-->
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">分类<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php if(is_array($category)): foreach($category as $key=>$t): ?><li><a href="/index.php/Home/Bestforbaby/viewitems/ctgr_id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a></li><?php endforeach; endif; ?>              
              </ul>
            </li>
          </ul> 
          <div id="bs-example-navbar-collapse-2" class="collapse navbar-collapse">
            <form class="navbar-form navbar-left" method="post" action="/index.php/Home/Bestforbaby/searchitem" role="search">
              <div class="form-group">
                <input class="form-control" name="key" type="text" placeholder="名称/用途/品牌...">
              </div>
              <button class="btn btn-danger" type="submit">搜索</button>
            </form>
          </div>
        </div><!--/.nav-collapse -->
      </div>
    </div>


<!--图像区-->


<div class="container">
<div class="row">
 <ul class="breadcrumb">
            <li><a href="/index.php/Home/Bestforbaby">物品管理</a></li>
            <li><a href="/index.php/Home/bestforbaby/viewitem/id/<?php echo ($item["id"]); ?>">查看物品</a></li>
            <li><a>新增规格选项</a></li>
  </ul>

	<form method="post" id="form" action="/index.php/Home/Bestforbaby/<?php echo ($action); ?>" name="f1" enctype="multipart/form-data" class="form form-inline">
  		<input name="item_id" value="<?php echo ($item["id"]); ?>" style="display:none;"/>
      <?php if(!empty($size)): ?><input name="id" value="<?php echo ($size["id"]); ?>" style="display:none;"/><?php endif; ?><!--编辑时需要-->
	  	<label for="size">输入规格描述：</label>
	  	<input id="size" class="form-control" name="size" placeholder="默认规格" value="<?php echo ($size["size"]); ?>" class="validate[required]"/>
	  	<button type="submit" class="btn btn-primary">提交</button>
	</form>
</div>
<div class="row">
 <ul class="breadcrumb">
 	<li>当前已有的规格选项</li>
 	<?php if(is_array($sizeOption)): foreach($sizeOption as $key=>$t): ?><li><a href="/index.php/Home/Bestforbaby/editSize/itemID/<?php echo ($item["id"]); ?>/sizeID/<?php echo ($t["id"]); ?>"><?php echo ((isset($t["size"]) && ($t["size"] !== ""))?($t["size"]):'默认'); ?></a></li><?php endforeach; endif; ?>
  </ul>

</div></div>
<!-- 加载编辑器的容器 --> 
 <script src="/Public/js/jquery-1.11.1.js"></script>    
   <script src="/Public/js/onload.js"></script>    
    
   <script src="/Public/js/jquery.validationEngine-zh_CN.js"></script>  
   <script src="/Public/js/jquery.validationEngine.js"></script> 
  <script type="text/javascript" charset="utf-8">
 $('#form-id').validationEngine(); 
 
        // 自定义参数调用 
        $('#form').validationEngine('attach', { 
        promptPosition: 'centerRight', 
        scroll: false,
       // ajaxFormValidation:true,
       ajaxFormValidationMethod:'post',
       // OnAjaxFormComplete:'ajaxFormValidationCallback'
       
      
          }); 

</script> 
  <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 
</body>
</html>