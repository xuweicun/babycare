<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<head>
    <meta charset="utf-8">
       <!-- Loading Bootstrap -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">   
       <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">
<title>码农私厨</title>
</head>
<body>
<div id="layout-container"  style="height:auto;" class="container">
 <div class="row">
        <div class="col-md-12">
          <h4 id="title">编辑物品信息</h4>
          <p class="help-block"><a href="/index.php/Home/Bestforbaby/viewitem/id/<?php echo ($item["id"]); ?>">查看</a></p>
          <form class="form-horizontal" name="form1" role="form" method="post" action="/index.php/Home/Bestforbaby/<?php echo ($action); ?>" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-md-2 col-lg-2 control-label">品牌</label>
              <div class="col-md-10 col-lg-10">
                <p class="form-control-static"> <?php echo (stripslashes($brand["cn_name"])); ?>(<?php echo (stripslashes($brand["name"])); ?>) from <?php echo (stripslashes($brand["corp_name"])); ?></p>
                <p class="help-block">如需更改品牌，请<a href="/index.php/Home/Bestforbaby/editBrand/id/<?php echo ($item["id"]); ?>">重新选择</a></p>
              </div>
              <input name="brand_id" value="<?php echo ($brand["id"]); ?>" style="display:none"/>
            </div>
            <!--品牌类别-->
            <div class="form-group" id="ctgrZone-1" style="display:none;">
              <label class="col-md-2 col-lg-2 control-label">选择类别</label>
              <div class="col-md-10 col-lg-10">
                <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button" id="select-btn1">选择类别 <span class="caret"></span></button>
                  <ul role="menu" class="dropdown-menu">
                    <?php if(is_array($category)): foreach($category as $key=>$t): ?><li>
                    <?php if(empty($t["category_id"])): ?><a onClick="javascript:selectDropDown(this,'<?php echo ($t["name"]); ?>','select-btn1');ajaxListChildren('ctgr-select','<?php echo ($ctgrURL); ?>'+<?php echo ($t["id"]); ?>);"><?php echo ($t['name']); ?></a></li>
                      <?php else: ?>
                      <a onClick="javascript:selectDropDown(this,'<?php echo ($t["name"]); ?>','select-btn1');ajaxListChildren('ctgr-select','<?php echo ($ctgrURL); ?>'+<?php echo ($t["category_id"]); ?>);"><?php echo ($t['name']); ?></a></li><?php endif; endforeach; endif; ?>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                  </ul>
                </div><!-- /btn-group -->
              </div>
            </div>
            <!--物品类别-->
            <div class="form-group">
              <label class="col-md-2 col-lg-2 control-label">类别</label>
              <div class="col-md-10 col-lg-10">
                <p class="form-control-static"> <?php echo ((isset($itemName) && ($itemName !== ""))?($itemName):'未指定'); ?></p>
                <p class="help-block"><a onClick="javascript:toggleElement('ctgrZone-1');toggleElement('ctgrZone-2');">修改类别</a></p>
                <!--隐藏的类别选项-->
                <div class="form-group" id="ctgrZone-2" style="display:none;">
                <select class="form-control-static" id="ctgr-select" name="category_id">
                  <option value="<?php echo ($item["category_id"]); ?>" selected><?php echo ($itemName); ?></option>
                  </select>
                  <p class="help-block"><a href="/index.php/Home/category/insertitem/layer/0">增加类别</a></p>
                </div>
              </div>
            </div>
            <div class="form-group" style="display:none;">
              <label for="id" class="col-lg-2 control-label">ID</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="id" placeholder="名称" name="id" value="<?php echo ($item["id"]); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-lg-2 control-label">名称</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="name" placeholder="名称" name="name" value="<?php echo ($item["name"]); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="version" class="col-lg-2 control-label">版本</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="version" placeholder="版本" name="version" value="<?php echo ($item["version"]); ?>">
              </div>
            </div>
             <div class="form-group">
              <label for="video" class="col-lg-2 control-label">安装视频</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="video" placeholder="输入视频的链接" name="video" value="<?php echo ($item["video"]); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="video" class="col-lg-2 control-label">购买链接</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="buyLink" placeholder="输入商品的店铺链接" name="buyLink" value="<?php echo ($item["buylink"]); ?>">
              </div>
            </div>
             <div class="form-group">
              <label for="start_age" class="col-lg-2 control-label">最小使用月龄</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="version" placeholder="最小" name="start_age" value="<?php echo ($item["start_age"]); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="end_age" class="col-lg-2 control-label">最大使用月龄</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="end_age" placeholder="最大" name="end_age" value="<?php echo ($item["end_age"]); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="life" class="col-lg-2 control-label">保质期或使用期限</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="life" placeholder="保质期或最佳使用期限描述" name="life" value="<?php echo ($item["life"]); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="barcode" class="col-lg-2 control-label">条形码</label>
              <div class="col-lg-10">
                <input type="text" class="form-control" id="barcode" placeholder="条形码或识别码" name="barcode" value="<?php echo ($item["barcode"]); ?>">
              </div>
            </div>
             <div class="form-group">
               <label for="img" class="col-lg-2 control-label">图片</label>
               <div class="col-lg-10" id="img">
                  <input name="img" type="text"  placeholder="图片路径" value="<?php echo ($item["img"]); ?>" class="form-control" style="display:none"/>
                
                    <button class="btn btn-block btn-info"  onclick="window.open('/index.php/Home/Bestforbaby/innerupload/formname/form1/editname/img','图片上传','left=300px,height=400,width=500');">上传图片</button>
               </div><!-- /input-group -->
             </div>
             <div class="form-group">
                <input name="thumb_img" type="text" id="thumb_img" value="<?php echo ($item["thumb_img"]); ?>" size="50" class="c-hidden" style="display:none"/> 
              </div>
              <div class="form-group"> 
                <label for="container" class="col-lg-2 control-label">描述</label>
                <div class="col-lg-10">
                  <script id="container" name="instruction" type="text/plain">
                    <?php echo (htmlspecialchars_decode($item["instruction"])); ?>
                  </script>
                </div>
              </div>
              <button type="submit" class="btn btn-block btn-primary">提交表单</button>
      
      
          </form>
        </div><!-- /.lg-col-12 -->
      </div><!-- /.row -->
 
    
    <!-- 加载编辑器的容器 --> 
    
    <!-- 配置文件 --> 
    <script type="text/javascript" src="/Public/js/ueditor.config.js"></script> 
    <!-- 编辑器源码文件 --> 
    <script type="text/javascript" src="/Public/js/ueditor.all.js"></script> 
    <!-- 实例化编辑器 --> 
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
   <script src="/Public/js/jquery.js"></script>    
   <script src="/Public/js/onload.js"></script> 
   <script type="text/javascript">    
   var selectDropDown = function(selectedID,name,titleID)
    {
        
        var $target = $(selectedID);
        $("#"+titleID).html(name+"<span class='caret'></span>");
        $target.parent().children().each(function()
            {
                $(this).removeClass("active");
            }    
        );     
        $target.addClass("active");   
    }
    </script>  
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/Public/js/flat-ui.min.js"></script>

    <script src="/Public/js/application.js"></script> 
   <script src="/Public/js/jquery.validationEngine-zh_CN.js"></script>  
   <script src="/Public/js/jquery.validationEngine.js"></script> 
    <!-- 配置文件 -->
    
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
       
        $('#form-id').validationEngine(); 
 
        // 自定义参数调用 
        $('#form-id').validationEngine('attach', { 
        promptPosition: 'centerRight', 
        scroll: false,
       // ajaxFormValidation:true,
       ajaxFormValidationMethod:'post',
       // OnAjaxFormComplete:'ajaxFormValidationCallback'
       
      
          }); 
        function ajaxFormValidationCallback(status,form,json,options)
        {
          //Do after the form validation
          if(status=true)
          {
            alert("whatever");
          }
          else
          {
            alert("failed");
          }
        }

    </script>
    

<!--container-->
<div>
</body>
</html>