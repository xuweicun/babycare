<?php if (!defined('THINK_PATH')) exit();?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!DOCTYPE HTML>
<html manifest="msj_m.manifest">        
<meta charset="gb2312">
<title>码农私厨</title>

<script src="/js/jquery-1.6.4.min.js"></script>    
<script type="text/javascript" charset="utf-8">

var ajaxUpload = function()
{
	//var info = new array();
	//var param = $.param(info);
	$.ajax({ 
		type: "post", //以post方式与后台沟通
		url: "/index.php/Home/bestforbaby/upload", //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
	//	data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: function(json){alert(json['result']);},
		fail:function(){}
		}); 
}
</script>

<body>
<div class="c-home">
<a href="/index.php/Home/Bestforbaby/index">回首页</a>
<br/>
<a href="/index.php/Home/Bestforbaby/viewitem/id/<?php echo ($id); ?>">查看物品</a>
<br/>
<a href="/index.php/Home/Bestforbaby/edititem/id/<?php echo ($id); ?>">编辑物品</a>
</div>

<?php if(is_array($items)): foreach($items as $key=>$t): ?><div>
<a href="/index.php/Home/bestforbaby/viewInstruction/id/<?php echo ($t["id"]); ?>"><?php echo ($t["title"]); ?></a>
</div><?php endforeach; endif; ?>
<form method="post" action="/index.php/Home/bestforbaby/addInstruction" name="f1" enctype="multipart/form-data">
<input name="item_id" value="<?php echo ($id); ?>" style="display:none;"/>
<input name="title" placeholder="项目" />
<script id="container" name="content" type="text/plain">输入内容</script>
<button type="submit">提交</button>

</form>
 <!-- 加载编辑器的容器 -->
   
    <!-- 配置文件 -->
    <script type="text/javascript" src="/Public/js/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/Public/js/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>

</body>
 </html>