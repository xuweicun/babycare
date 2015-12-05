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

<!--
$optionClickAction:点击效果,与当前选项的ID有关；
$blurAction:弃选效果；
$defaultClickAction:全部弃选效果;
-->

	
    <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">

    <link href="/Public/css/custom.css" rel="stylesheet">

<body>

<div id="layout-container"  style="height:auto;" class="container">
 <div class="row">
        <div class="col-md-12">
          <ul class="breadcrumb">
            <li><a href="/index.php/Home/Bestforbaby">物品管理</a></li>
            <li><a>选择品牌</a></li>
          </ul>
          <form class="form-horizontal" name="form1" id="form" role="form" method="post" action="/index.php/Home/Bestforbaby/<?php echo ($action); ?>/action/selectbrand" name="f1" enctype="multipart/form-data" enctype="multipart/form-data">
            <input name="id" value="<?php echo ($item["id"]); ?>" style="display:none;"/>
            <div class="form-group">
              <label class="col-md-2 col-lg-2 control-label">选择厂商</label>
              <div class="col-md-10 col-lg-10">
                <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-info dropdown-toggle" type="button" id="select-btn-corp">下拉选择 <span class="caret"></span></button>
                  <ul role="menu" class="dropdown-menu">
                    <?php if(is_array($companies)): foreach($companies as $key=>$t): ?><li><a onClick="javascript:selectDropDown(this,'<?php echo ($t["name"]); ?>','select-btn-corp');listChildren(<?php echo ($t["id"]); ?>,'brand-container');"><?php echo ($t['name']); ?>(<?php echo ($t["cn_name"]); ?>)</a></li>
                    <!--<li><a onClick="javascript:toggleElement('title');"><?php echo ($t['name']); ?></a></li>--><?php endforeach; endif; ?>
                    
                  </ul>
                </div><!-- /btn-group -->
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 col-lg-2 control-label">选择品牌</label>
              <div class="col-md-10 col-lg-10">
                <div class="btn-group" id="brand-container">
                  <select name="brand_id" class="form-control select select-danger mrs mbm">
                    <option>选择品牌</option>
                    <?php if(is_array($brands)): foreach($brands as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"
                    <?php if(!empty($item)): if(($t["id"]) == $item["brand_id"]): ?>selected<?php endif; endif; ?>
                    ><?php echo ($t["name"]); ?>|<?php echo ((isset($t["cn_name"]) && ($t["cn_name"] !== ""))?($t["cn_name"]):''); ?></option><?php endforeach; endif; ?>
                  </select>
                </div><!-- /btn-group -->

       
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-2 col-lg-2 control-label"></label>
              <div class="col-md-10 col-lg-10 btn-group">
              
              <?php if(!empty($item)): ?><a type="button" href="/index.php/Home/Bestforbaby/edititem/id/<?php echo ($item["id"]); ?>" class="btn btn-large btn-info">返回编辑</a>
                  <a type="button" href="/index.php/Home/Bestforbaby/viewitem/id/<?php echo ($item["id"]); ?>" class="btn btn-large btn-danger">查看物品[<?php echo ($item["name"]); ?>]</a><?php endif; ?>
              <button type="submit" class="btn btn-large btn-primary">下一步</button>
            </div>
            </div>
          </form><!--form ends-->
        </div><!--col ends-->
      </div><!--row ends-->
    </div><!--container ends-->


<!--container-->
  <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script>   
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
 <script type="text/javascript" charset="utf-8">

var listChildren = function(id,toReplace)
{
  $.ajax({ 
    type: "post", //以post方式与后台沟通
    url: "/index.php/Home/Company/listChildren/id/"+id, //与此php页面沟通
    dataType:'json',//从php返回的值以 JSON方式 解释
    //data: param, //发给php的数据有两项，分别是上面传来的u和p
    success: function(data){
      $("#"+toReplace).html(data['view']);
      
      },
    fail:function(){$("#"+toReplace).html();}
    });

}
$(document).ready(function(){
      
        $('select').select2({dropdownCssClass: 'show-select-search'});
      });
      $('input.tagsinput').tagsinput();

</script>
</body>
</html>