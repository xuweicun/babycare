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
  <div id="layout-container"  style="height:auto;" class="container">
   <div class="row">
          <div class="col-md-12">
            <ul class="breadcrumb">
              <li><a href="/index.php/Home/Brand">品牌管理<span class="glyphicon glyphicon-home"></span></a>
              </li>
              <li><a>增加品牌</a></li>
            </ul>
            <form class="form-horizontal" name="form-id" id="form-id" role="form" method="post" action="/index.php/Home/Brand/<?php echo ($action); ?>" enctype="multipart/form-data">
              <input value="<?php echo ($item["id"]); ?>" name="id" style="display:none">
              <div class="form-group">
                <label class="col-md-2 col-lg-2 control-label">品牌名称</label>
                <div class="col-md-10 col-lg-10">
                  <?php if(isset($item)): ?><input type="text" class="form-control validate[required]" id="name" placeholder="名称" name="name" value="<?php echo ($item["name"]); ?>">
                 <?php else: ?>
                    <input type="text" class="form-control tagsinput validate[required,ajax[ajaxName]]" id="name" placeholder="名称" name="name"><?php endif; ?>

                </div>
              </div>
              <div class="form-group">
                <label class="col-md-2 col-lg-2 control-label">中文名称</label>
                <div class="col-md-10 col-lg-10">
                 <input type="text" class="form-control validate[custom[chinese]]" id="cn_name" placeholder="名称" name="cn_name" value="<?php echo ($item["cn_name"]); ?>">
                </div>
              </div>

             <div class="form-group">
              <label class="col-md-2 col-lg-2 control-label">选择厂商</label>
              <div class="col-md-10 col-lg-10">
              
                  <select data-toggle="select" name="corp_id" class="form-control select select-default mrs mbm">
                      <option>选择厂商</option>
                      <?php if(is_array($companies)): foreach($companies as $key=>$t): if(isset($item)): if(($t["id"]) == $item["corp_id"]): ?><option value="<?php echo ($t["id"]); ?>" selected><?php echo (stripslashes($t["name"])); ?></option>
                            <?php else: ?>
                            <option value="<?php echo ($t["id"]); ?>" ><?php echo (stripslashes($t["name"])); ?></option><?php endif; ?>
                        <?php else: ?>
                          <option value="<?php echo ($t["id"]); ?>" ><?php echo (stripslashes($t["name"])); ?></option><?php endif; ?><!-- for edit company--><?php endforeach; endif; ?>
                    <option>其他</option>
                  </select>
                  <p class="help-block"><a href="/index.php/Home/company/insertitem">增加厂商</a> <input type="checkbox" onclick="" id="valueToCopy" value=""/>品牌与厂商同名</p>
              </div>
            </div><!-- 选择厂商 -->
            <div class="form-group">
                <label class="col-md-2 col-lg-2 control-label">选择类别</label>
                <div class="col-md-10 col-lg-10">
                 <?php if(is_array($selected)): foreach($selected as $key=>$t): ?><input type="checkbox" name="category[]" checked value="<?php echo ($t["id"]); ?>"/><?php echo ($t["name"]); endforeach; endif; ?><!--已经选择的-->                 
                  <?php if(is_array($unselected)): foreach($unselected as $key=>$t): ?><input type="checkbox" name="category[]" value="<?php echo ($t["id"]); ?>"/><?php echo ($t["name"]); endforeach; endif; ?><!--没有选择的--> 
                  <p class="help-block"><a href="/index.php/Home/category/insertitem/layer/1">增加类别</a></p>

                </div>
            </div> 

            <div class="form-group"> 
                <label for="container" class="col-lg-2 control-label">描述</label>
                <div class="col-lg-10">
                  <script id="container" name="description" type="text/plain">
                    <?php echo (htmlspecialchars_decode($item["description"])); ?>
                  </script>
                </div>
              </div>
              <button type="submit" class="btn btn-block btn-primary">提交表单</button>
            </form>
          </div>
        
    </div><!--row end-->
  </div><!--container end-->

 <!-- 加载编辑器的容器 -->
   <script src="/Public/js/jquery-1.11.1.js"></script>    
   <script src="/Public/js/onload.js"></script>    
    <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script>  
   <script src="/Public/js/jquery.validationEngine-zh_CN.js"></script>  
   <script src="/Public/js/jquery.validationEngine.js"></script> 
    <!-- 配置文件 -->
    <script type="text/javascript" src="/Public/js/ueditor.config.js"></script>
    <!-- 编辑器源码文件 -->
    <script type="text/javascript" src="/Public/js/ueditor.all.js"></script>
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container');
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
    <script>
      $(document).ready(function(){
      
        $('select').select2({dropdownCssClass: 'show-select-search'});
      });
      $('input.tagsinput').tagsinput();
    </script>

</body>
</html>