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

    <link href="/Public/css/custom.css" rel="stylesheet">

</head>

<body>

<br>
<div class="container">
      <ul class="nav nav-pills" role="tablist">
      <li><a href="/index.php/Home/Bestforbaby/viewitem/id/<?php echo ($item["id"]); ?>"><?php echo ($item["name"]); ?> from <?php echo ($item["brand"]); ?></a></li>
      <li><a href="/index.php/Home/Bestforbaby/index">管理首页 <span class='glyphicon glyphicon-home'></span></a></li>
      </ul>
 <form method="post" action="/index.php/Home/Bestforbaby/<?php echo ($action); ?>" name="f1" enctype="multipart/form-data">
 	<input name="item_id" type="text" id="item_id" value="<?php echo ($item["id"]); ?>" size="50" style="display:none" />
      <select name="view_id">
      <option>选择外观</option>
      <?php if(is_array($itemView)): foreach($itemView as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ((isset($t["view"]) && ($t["view"] !== ""))?($t["view"]):"默认"); ?></option><?php endforeach; endif; ?>
      </select>
      <!--<select name="size_id">
      <option>选择规格</option>
      <?php if(is_array($itemSize)): foreach($itemSize as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ((isset($t["size"]) && ($t["size"] !== ""))?($t["size"]):"默认"); ?></option><?php endforeach; endif; ?>
      </select>-->
      <input name="img" type="text" id="img" size="50" onchange="showPrev()" onFocus="showPrev()"/>
      <input name="thumb_img" type="text" id="thumb_img" size="50" class="c-hidden-no" style="display:none"/>
      <input type="button" class="btn btn-info" name="button2" id="button2" value="上传图片" onclick="window.open('/index.php/Home/bestforbaby/innerupload/formname/f1/editname/img/prevname/prevImg','文件上传','left=300px,height=400,width=500');" class="btn" />

      <button type="submit" class="btn btn-info">提交</button>
      <link rel="stylesheet" href="${ctx}/css/jquery-jcrop/jquery.Jcrop.css" type="text/css" />   
      <div class="row well" id="prevImgContainer"><img id="prevImg" name="prevImg" style="width:50%;"> 
      <input type="text" class="hidden-no" id="x1" name="x1">
       <input type="text" class="hidden-no" id="y1" name="y2">
       <input type="text" class="hidden-no" name="x2" id="x2">
       <input type="text" class="hidden-no" name="y2" id="y2">
       <input type="text" class="hidden-no" id="w" name="w">
       <input type="text" class="hidden-no" id="h" name="h"> </div>

     
 </form>
      
      <div class="row well">
      <button class="btn btn-info" onclick="javascript:cropPrev();">裁剪</button>
            <div class="btn-toolbar" id="itemview">
                  <?php if(is_array($itemView)): $i = 0; $__LIST__ = $itemView;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><button class="btn btn-info selectgroup" onClick="javascript:getItemImgs(<?php echo ($item["id"]); ?>,<?php echo ($t["id"]); ?>,'itemViewContainer');"><?php echo ($t["view"]); ?></button><?php endforeach; endif; else: echo "" ;endif; ?>
            </div></div>
            <div class="row" id="itemViewContainer">
           
            <?php if(is_array($viewImgs)): foreach($viewImgs as $key=>$t): ?><div class="col-sm-6 col-md-3">

              <div class="thumbnail thumbnail-warning" >
                <img data-src="<?php echo ($t["thumb_img"]); ?>" src="<?php echo ($t["viewimg"]); ?>" alt="image not found">
                <div class="caption">
                  <h5><?php echo ((isset($t["name"]) && ($t["name"] !== ""))?($t["name"]):'name not found'); ?></h5>
                  <p><?php echo ($t["company"]); echo ($t["brand"]); ?></p>
                  <p>
                 <a role="button" class="btn btn-default btn-block" href="/index.php/Home/Bestforbaby/deleteimg/id/<?php echo ($t["img_id"]); ?>">删除</a>
               </p>
                </div>
              </div>
            </div><?php endforeach; endif; ?>
</div>
</div>

 <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script> 
<script type="text/javascript" src="/Public/js/onload.js"></script>
<script type="text/javascript" src="/Public/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript">
var cropPrev = function()
{
	var jcrop_api;
 	$("#prevImg").Jcrop({
    onChange: showCoords,
    onSelect: showCoords,
    onRelease: clearCoords
  }, function(){
    jcrop_api = this;
  });
 	$('#prevImgContainer').on('change','input',function(e){
    var x1 = $('#x1').val(),
    x2 = $('#x2').val(),
    y1 = $('#y1').val(),
    y2 = $('#y2').val();
	});

    jcrop_api.setSelect([x1, y1, x2, y2]);
}
function showCoords(c){
  $('#x1').val(c.x);
  $('#y1').val(c.y);
  $('#x2').val(c.x2);
  $('#y2').val(c.y2);
  $('#w').val(c.w);
  $('#h').val(c.h);
};
  
function clearCoords(){
  $('#coords input').val('');
};
</script>
<script type="text/javascript">
$("document").ready(function(){
      var $this = $("#itemView button").first();
      var originVal =  $this.html();
      $("#itemView button").first().html(originVal+" <span class='glyphicon glyphicon-check'></span>");
      $(".selectgroup").bind("click",function(e){
        var $this = $(e.target);
        $this.parent().children().removeClass("active").each(function(){
         // var content = parse($(this).html(),"<");
          //$(this).html(content[0]);

        });
        var check = $("<span class='glyphicon glyphicon-check'></span>");
        $this.addClass("active")//.append(check);
        
      })
      
});

var 
</script>
</body>
</html>