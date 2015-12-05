<?php if (!defined('THINK_PATH')) exit();?><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!DOCTYPE HTML>
<html manifest="msj_m.manifest">        
<meta charset="gb2312">
<title>码农私厨</title>




<body>
<a href="/index.php/Home/">首页</a>
  <?php if(is_array($items)): foreach($items as $key=>$t): ?><a href="/index.php/Home/Instruction/editTitle/id/<?php echo ($t["id"]); ?>"><?php echo ($t["title"]); ?></a>
  <br/><?php endforeach; endif; ?>
<form method="post" action="/index.php/Home/Instruction/<?php echo ($action); ?>" name="f1" enctype="multipart/form-data">
<input name="title" placeholder="名称" value="<?php echo ((isset($item["title"]) && ($item["title"] !== ""))?($item["title"]):''); ?>"/>

  <br/>

<button type="submit">提交</button>

</form>
 <!-- 加载编辑器的容器 -->
   <script src="/js/jquery-1.6.4.min.js"></script>    
    <!-- 配置文件 -->
    <script type="text/javascript" src="/Public/js/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
   

</body>
 </html>