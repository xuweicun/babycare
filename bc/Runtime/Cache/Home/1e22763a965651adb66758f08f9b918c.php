<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<p>
规格：<?php echo ((isset($size["size"]) && ($size["size"] !== ""))?($size["size"]):"默认"); ?>
</p>
<p>
外观：<?php echo ((isset($view["view"]) && ($view["view"] !== ""))?($view["view"]):"默认"); ?>
</p>
<?php if(is_array($imgs)): foreach($imgs as $key=>$t): ?><img src="<?php echo ($t["thumb_img"]); ?>" alt="coco-babycare" class="c-hidden" /> 
      <a href="/index.php/Home/image/deleteitem/id/<?php echo ($t["id"]); ?>">删除图像</a><?php endforeach; endif; ?>
<BR>
<a href="/index.php/Home/Bestforbaby/viewitem/id/<?php echo ($item["id"]); ?>"><?php echo ($item["category"]); ?></a>
<br>

<a href="/index.php/Home/Bestforbaby/insertimg/item_id/<?php echo ($item["id"]); ?>">插入图像</a>
<br>

</body>
</html>