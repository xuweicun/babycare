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

<meta name="viewport" content="width=device-width">
</head>
<body>
<style>
	 body {
       
        padding-top: 70px;
        font-family: microsoft yahei;
      }
      .navbar-fixed-bottom{
        bottom: 0px !important;
      }
      
</style>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="nav-<?php echo ($item["index"]); ?>">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="history.go(-1);" class="navbar-brand  btn btn-danger"><</a> 
          <a class="navbar-brand">使用</a>
        </div>
        <div class="navbar-collapse collapse">
	        <ul class="navbar navbar-nav navbar-right">
	        	<li class="active"><a href="/index.php/Home/bestforbaby"> <span class="visible-sm visible-xs glyphicon glyphicon-home"></span></a></li>
	        </ul>
	        <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">MonsterCritic <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>
                <li class="divider"></li>
                <li><a href="#">Separated link</a></li>
              </ul>
            </li>
            <li><a href="#"><span class="visible-sm visible-xs">Settings<span class="fui-gear"></span></span><span class="visible-md visible-lg"><span class="fui-gear"></span></span></a></li>
          </ul>
        </div>
      </div>
    </div>
	<div class="container-fluid">
		<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="row hidden" id="content-<?php echo ($item["index"]); ?>">
			<div class="col-sm-12 col-lg-12">
				<?php echo (htmlspecialchars_decode($item["content"])); ?>
			</div>
		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	</div>
	 <!-- Static navbar -->
	<?php if(is_array($items)): $i = 0; $__LIST__ = $items;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><div class="navbar navbar-default navbar-fixed-bottom hidden" role="navigation" id="nav-<?php echo ($item["index"]); ?>">
      <div class="container-fluid">
        <div class="navbar-header">
          <a href="/index.php/Home" class="navbar-brand"> <span class="glyphicon glyphicon-align-justify"></span></a> 
          <a class="navbar-brand" onclick="change_item(<?php echo ($item["index"]); ?>,<?php echo ($total_num); ?>,true);"> <span class="glyphicon glyphicon-circle-arrow-left"></a>
          <a class="navbar-brand"><?php echo ($item["index"]); ?>/<?php echo ($total_num); ?></a>
          <a class="navbar-brand" onclick="change_item(<?php echo ($item["index"]); ?>,<?php echo ($total_num); ?>,false);">  <span class="glyphicon glyphicon-circle-arrow-right"></a>
        </div>
      </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
 <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 
<script>
/*@param： index-当前序号
**@param： total_num-总数 
**@param:  
*/
	function change_item(index,total_num,is_backward)
	{
		if(total_num == 1)
			return;//只有一个元素不做操作；
		var nextItem = is_backward ? index - 1 :　index + 1;
		if(nextItem < 1) nextItem = total_num;//如果是第一页，返回最后一页；
		else
		{
			if(nextItem > total_num) nextItem = 1;//如果是最后一页，前进到第一页；
		}
		show_item(index,nextItem, total_num);
		
	}
/*@param: */
    function show_item(current,next,total_num)
    {
		//显示内容
		$("#content-"+next).removeClass("hidden");
		$("#content-"+current).addClass("hidden");
		//导航条
		$("#nav-"+next).removeClass("hidden");
		$("#nav-"+current).addClass("hidden");
		//菜单
		$("#menu-"+next).addClass("active");
		$("#menu-"+current).removeClass("active");
    }
    $(function(){
    	//隐藏所有元素
    	$("#content-1").removeClass("hidden");
    	$("#nav-1").removeClass("hidden");
    });
</script>

</body>
</html>