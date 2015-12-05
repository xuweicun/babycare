<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <!-- Loading Bootstrap -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Loading Bootstrap -->

  <link href="/Public/css/bootstrap.min.css" rel="stylesheet">

  <!-- Loading Flat UI -->

  <link href="/Public/css/flat-ui.min.css" rel="stylesheet">
  <link href="/Public/css/custom.css" rel="stylesheet">
  <style>
    div.item-carousel{width:90%;max-width:500px;height:100%;overflow: hidden;}
    img.item-carousel{
      display:inline-block;width:500px;height:400px;
    }

    </style>

  <title>物品详情</title>
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
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="/index.php/User">首页 <span class="glyphicon glyphicon-home"></span></a></li>
            <!--<li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>-->
            <li role="presentation" class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"> 分类<b class="caret"></b></a>
              <ul class="dropdown-menu">
                <?php if(is_array($category)): foreach($category as $key=>$t): ?><li><a href="/index.php/User/Index/viewbyctgr/ctgr_id/<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></a></li><?php endforeach; endif; ?>              
              </ul>
            </li>
          </ul> 
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fui-user"></span> 我的账户 <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="fui-gear"></span> 账户设置</a></li>
                <li><a href="#"><span class="fui-list"></span> 订单</a></li>
                <li><a href="#"><span class="fui-tag"></span> 收藏夹</a></li>
                <li class="divider"></li>
                <li><a href="#">登录 <span class="fui-login"></span></a></li>
                <li><a href="#">注销 <span class="fui-logout"></span></a></li>
              </ul>
            </li>           
         </ul>
          <div id="bs-example-navbar-collapse-2" class="collapse navbar-collapse">
            <form class="navbar-form navbar-left" method="post" action="/index.php/User/Index/searchitem" role="search">
              <div class="form-group">
                <input class="form-control" name="key" type="text" size="50" placeholder="名称/用途/品牌...">
              </div>
              <button class="btn btn-danger" type="submit">搜索 <span class="glyphicon glyphicon-search"></span></button>
            </form>
          </div>
       </div><!--/.nav-collapse --> 
      </div>
    </div>


<!--图像区-->


<div class="container">
        <div class="row">
        	<div class="col-sm-12 col-md-6" id="itemImg">
            <div class='alert alert-default pre-hidden' id="noImg" style="width: 500px;height: 400px;">
              <a data-dismiss='alert' class='close' href='#alert'>x</a>
              <p>很抱歉，此款式暂时没有可显示的图片:)</p>
            </div>
            <?php if(!empty($itemViewImg)): ?><div id="carousel-example-generic" style="width:100%;height:100%;margin:auto;z-index:2;" class="carousel  slide" data-ride="carousel" data-keyboard="true">
                <!-- Indicators -->            
                <ol class="carousel-indicators" id="galleryIndex">
                  <?php if(is_array($itemViewImg)): $i = 0; $__LIST__ = $itemViewImg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><li data-target="#carousel-example-generic" data-slide-to="0"></li><?php endforeach; endif; else: echo "" ;endif; ?>
                </ol>

                <!-- Wrapper for slides -->            
                <div class="carousel-inner" style="width:100%;height:100%;margin:auto;" role="listbox" id="galleryContent">
                  <?php if(is_array($itemViewImg)): $i = 0; $__LIST__ = $itemViewImg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i;?><div class="item item-carousel" style="width:90%;max-width:500px;height:100%;overflow: hidden;">
                      <img src="<?php echo ($t["viewimg"]); ?>" style="display:inline-block;width:500px;height:400px;" alt=""></div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
              </div>
          <?php else: ?> 
            
          <img src="<?php echo ($item["img"]); ?>" alt="<?php echo ($item["name"]); ?>coco-babycare" style="width:500px;height:400px;"/><?php endif; ?>
        <?php if(!empty($itemView)): ?><div class="row" style="font-size:14px;width: 90%;margin: auto; margin-top: 10px;">
                      <div class="col-sm-2 col-md-2">
                        <p class="form-control-static" style="font-size:14px;">样式</p>
                      </div>
                    <?php if(!empty($selectedView)): ?><div class="col-sm-10 col-md-10 btn-toolbar" role="toolbar" id="itemView">
                          <?php if(is_array($itemView)): $i = 0; $__LIST__ = $itemView;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i; if(($t['id']) == $selectedView): ?><button class="btn btn-success selectgroup active" onclick="getViewGallery(<?php echo ($item["id"]); ?>,<?php echo ($t["id"]); ?>);"><?php echo ($t["view"]); ?>
                                  <span class="glyphicon glyphicon-check"></span></button>
                                  <?php else: ?>
                                  <button class="btn btn-success selectgroup" onclick="getViewGallery(<?php echo ($item["id"]); ?>,<?php echo ($t["id"]); ?>);"><?php echo ($t["view"]); ?></button><?php endif; endforeach; endif; else: echo "" ;endif; ?>                        
                      </div><?php endif; ?>
                    </div><?php endif; ?>
  <!-- Controls -->
        	</div>
          
      
        	<div class="col-sm-12 col-md-6">
        		
           
              <div class="row alert alert-success">
                <h4><?php echo ($item["name"]); ?> </h4>
                <span class="label label-warning"><?php echo (stripslashes($brand["cn_name"])); ?>(<?php echo (stripslashes($brand["name"])); ?>) <span class="badge badge-info"><?php echo ($item["version"]); ?></span></span> 
                by <span class="label label-info"><?php echo (stripslashes($brand["corp_name"])); ?></span>
                <p class="help-block" style="display: none;"><a href="#">修改基本信息 <span class="glyphicon glyphicon-pencil"></span></a></p> 
              </div>
                    
              
                    <div class="row well" style="font-size:14px;margin-bottom:5px;">
                      <div class="col-sm-2 col-md-2">
                        <span style="font-size:14px;">用户评价</span>
                      </div>
                      <div class="col-sm-10 col-md-10">                       
                         
                            <span class="glyphicon glyphicon-star comment-star active"></span>
                            <span class="glyphicon glyphicon-star comment-star active"></span>
                            <span class="glyphicon glyphicon-star comment-star active"></span>
                            <span class="glyphicon glyphicon-star comment-star active"></span>
                            <span class="glyphicon glyphicon-star comment-star active"></span>
                        
                      </div>
                      
                    </div> 
                    <?php if(!empty($version)): ?><div class="row well" style="font-size:14px;margin-bottom:5px;">
                      <div class="span12">
                      <div class="col-sm-2 col-md-2">
                        <p class="form-control-static" style="font-size:14px;">所有型号</p>
                      </div>
                      <div class="col-sm-10 col-md-10 btn-toolbar" role="toolbar">
                        
                          <?php if(is_array($version)): $i = 0; $__LIST__ = $version;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$t): $mod = ($i % 2 );++$i; if(($t["id"]) == $item["id"]): ?><a class="btn btn-info selectgroup active" href="/index.php/User/Index/viewitem/id/<?php echo ($t["id"]); ?>" style="margin-bottom:2px;"><?php echo ((isset($t["version"]) && ($t["version"] !== ""))?($t["version"]):"默认版本"); ?> 
                            <span class="glyphicon glyphicon-check"></span></a>
                            <?php else: ?>
                            <a class="btn btn-info selectgroup" href="/index.php/User/Index/viewitem/id/<?php echo ($t["id"]); ?>" ><?php echo ((isset($t["version"]) && ($t["version"] !== ""))?($t["version"]):"默认版本"); ?></a><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        
                      </div>
                      </div>
                    </div><?php endif; ?>
                    
                    <div class="row" style="font-size:14px;margin-bottom:5px;">
                      <a class="btn btn-block btn-info" href="<?php echo ((isset($item["buylink"]) && ($item["buylink"] !== ""))?($item["buylink"]):'https://feitui.taobao.com/?spm=2013.1.1000126.3.ItHGH8'); ?>" target="blank">去购买 <span class="glyphicon glyphicon-shopping-cart"></span></a>
                      <a class="btn btn-block btn-success" href="/index.php/User/Instruction/viewBfbItems/item_id/<?php echo ($item["id"]); ?>">基本参数和使用说明 <span class="glyphicon glyphicon-book" style="color:brown;"></span></a>
                    </div>
                    
        		
        	</div>
        </div>


        
      <?php if(!empty($item["video"])): ?><div class="panel panel-default" style="margin-top: 20px;">
         <div class="panel-heading"><h4>使用视频</h4></div>
         <div class="panel-body">
         	<?php echo (htmlspecialchars_decode($item["video"])); ?> 
         </div>
           
        </div><?php endif; ?>
      <div class="panel panel-warning" style="margin-top: 20px;">
        <div class="panel-heading">
          <h4 style="color:green;">基本参数和使用说明</h4>
        </div>
        <div class="panel-body" style="min-height: 300px;">
              <div class="tabbable" id="instruction" style="margin-top:10px;">    
            <ul class="nav nav-tabs" role="tablist">
	            <?php if(empty($item["start_age"])): if(empty($item["end_age"])): else: ?><li role="presentation"><a href="#tab-age" data-toggle="tab" aria-controls="tab-age" role="tab">适用年龄</a></li><?php endif; ?>
	            <?php else: ?><li role="presentation"><a href="#tab-age" data-toggle="tab" aria-controls="tab-age" role="tab">适用年龄</a></li><?php endif; ?>
	            <?php if(!empty($item["life"])): ?><li role="presentation"><a href="#tab-life" data-toggle="tab" aria-controls="tab-life" role="tab">保质期</a><?php endif; ?>
	            <?php if(is_array($instructions)): foreach($instructions as $key=>$t): ?><li role="presentation"><a href="#tab-inst-<?php echo ($t["id"]); ?>" data-toggle="tab" role="tab" ><?php echo ($t["title"]); ?></a></li><?php endforeach; endif; ?>                  
            </ul>    
            <div class="tab-content">              
              <?php if(!empty($item["start_age"])): ?><div class="tab-pane" role="tabpanel" id="tab-age">  
                <p>
                  <?php if(!empty($item["start_age"])): ?>大于<?php if(($item["start_age"]) > "24"): echo ($item['start_age']/12); ?>岁<?php echo ($item['start_age']%12); ?>个月
                    <?php else: ?>
                    <?php echo ($item['start_age']); ?>个月<?php endif; endif; ?>
                  <?php if(!empty($item["end_age"])): ?>小于
                  <?php if(($item["end_age"]) > "24"): echo ($item['end_age']/12); ?>岁
                    <?php else: ?>
                    <?php echo ($item['end_age']); ?>个月<?php endif; endif; ?>
                </p>
                 
              </div> 
              <?php else: ?>
              <?php if(!empty($item["end_age"])): ?><div class="tab-pane" role="tabpanel" id="tab-age">  
                <p>
                  <?php if(!empty($item["start_age"])): ?>大于<?php if(($item["start_age"]) > "24"): echo ($item['start_age']/12); ?>岁<?php echo ($item['start_age']%12); ?>个月
                    <?php else: ?>
                    <?php echo ($item['start_age']); ?>个月<?php endif; endif; ?>
                  <?php if(!empty($item["end_age"])): ?>小于
                  <?php if(($item["end_age"]) > "24"): echo ($item['end_age']/12); ?>岁
                    <?php else: ?>
                    <?php echo ($item['end_age']); ?>个月<?php endif; endif; ?>
                </p>
                 
              </div><?php endif; endif; ?>
            <?php if(!empty($item["life"])): ?><div class="tab-pane" id="tab-life">
	             	<p>
	             		<?php echo (htmlspecialchars_decode($item["life"])); ?>
	             	</p>
	             </div><?php endif; ?>
            <?php if(is_array($instructions)): foreach($instructions as $key=>$t): ?><div class="tab-pane" role="tabpanel" id="tab-inst-<?php echo ($t["id"]); ?>">           
                <p><?php echo (htmlspecialchars_decode($t["content"])); ?></p> 
                     
              </div><?php endforeach; endif; ?>  
     
       
            </div> 
          </div>
          <!--说明区-->  
        </div>
      </div>
      
        
    </div>
    <!-- /.container -->


    <!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
     <!--<script src="/Public/js/jquery.js"></script>-->
 <footer id="footer">
    <div class="container">
        <div class="row hidden-xs">
            <dl class="col-sm-3 site-link">
                <dt>网站相关</dt>
                <dd><a href="/notready">关于我们</a></dd>
                <dd><a href="/notready">服务条款</a></dd>
                <dd><a href="/notready">帮助中心</a></dd>
                <dd><a href="/notready">每周精选</a></dd>
                <dd><a href="/notready">App 下载</a></dd>
            </dl>
            <dl class="col-sm-3 site-link">
                <dt>联系合作</dt>
                <dd><a href="/notready">联系我们</a></dd>
                <dd><a href="/notready">加入我们</a></dd>
                <dd><a href="/notready">合作伙伴</a></dd>
                <dd><a href="/notready">媒体报道</a></dd>
                <dd><a href="/notready">建议反馈</a></dd>
                
            </dl>
            <dl class="col-sm-3 site-link">
                <dt>常用链接</dt>
                <dd><a href="//mirrors.segmentfault.com/" target="_blank">淘宝主页</a></dd>
                <dd>订阅：<a href="/feeds">问答</a> / <a href="/feeds/blogs">文章</a></dd>
                <dd><a href="//segmentfault.com/events?category=4">黑客马拉松</a></dd>
                <!--             <dd><a href="http://zs.segmentfault.com/" target="_blank">一起涨姿势</a></dd> -->
                <dd><a href="https://namebeta.com/" target="_blank">域名搜索注册</a></dd>
            </dl>
            <dl class="col-sm-3 site-link">
                <dt>关注我们</dt>
                <!-- <dd><a href="http://page.renren.com/699146294" target="_blank">人人网</a></dd> -->
                <dd><a href="#" target="_blank">新浪微博</a></dd>				
                <dd>微信：coco_babycare</a></dd>
                
            </dl>
            
        </div>
        <div class="copyright">
            Copyright &copy; 2011-2015 MakeBetter Inc. <a href="http://www.miibeian.gov.cn/"
                                                                                    rel="nofollow">浙ICP备xxx号-2</a>
        </div>
        <p class="text-center">
            <a class="js__view--selector hidden-sm hidden-md hidden-lg" data-action="mobile" href="javascript:;">移动版</a>
            <a class="js__view--selector hidden-sm hidden-md hidden-lg" data-action="desktop" href="javascript:;">桌面版</a>
        </p>
    </div>
</footer>
 <script src="http://cdn.staticfile.org/jquery/2.0.0/jquery.min.js"></script>
 <script>window.jQuery || document.write('<script src="/Public/js/jquery-1.11.1.min.js" type="text/javascript"><\/script>')</script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
 <script src="/Public/js/flat-ui.min.js"></script>

 <script src="/Public/js/application.js"></script>   
    <script src="/Public/js/onload.js"></script> 
    <!--<script type="text/javascript" src="/Public/js/bootstrap.min.js" ></script>-->
    
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var getViewGallery = function(id,viewId)
        {
            var params = { item_id:id, view_id:viewId,isJsonReturn:true};
            var param = $.param(params);
            $.ajax({ 
              type: "post", //以post方式与后台沟通
              url: "/index.php/User/index/getImg", //与此php页面沟通
              dataType:'json',//从php返回的值以 JSON方式 解释
              data: param, //发给php的数据有两项，分别是上面传来的u和p
              success: function(json){      
                  if(json && json['error'])
                  {
                    
                  }
                  else
                  {
                    if (json == null) {
                      $("#noImg").removeClass("pre-hidden").show(); 
                      $("#carousel-example-generic").toggle(); 
                    }
                    else
                    {
                      var index = "";
                      var n = 0;
                      var items = "";
                      for(i in json)
                      {

                          index  = index + "<li data-target='#carousel-example-generic' data-slide-to='"+n+"'></li>";
                          items  = items + "<div class='item item-carousel' ><img class='item-carousel' src='"+json[i].viewimg+"' style='display:inline-block;width:500px;height:400px;'></div>";
                          n = n + 1;
                      }
                      $("#noImg").hide();
                      $("#carousel-example-generic").show(); 

                      $("#galleryIndex").html(index);
                      $("#itemImg ol li").first().addClass("active");

                      $("#galleryContent").html(items);
                      $("#itemImg div.item").first().addClass("active");

                    }
                    //var originVal =  $(event.target).html();
                        //$(event.target).html(originVal+" <span class='glyphicon glyphicon-check'></span>");
                  //  $("#"+id).after(json['view']);
                  }
                },
              fail:function(){}
              });
        }
    </script>   
    <script type="text/javascript">
    $(function(){
        $("#view-size-option a").first().removeClass("btn-info").addClass("btn-danger");
        $("#instruction ul li").first().addClass("active").addClass("li-danger");
        $("#itemImg ol li").first().addClass("active");
        $("#itemImg div.item").first().addClass("active");
        var index = 0;
        $("#itemImg ol li").each(function(){
          $(this).attr("data-slide-to",index);
          index = index + 1;
        });
       
        
        $("#instruction .tab-pane").first().addClass("active");
         
           $("#instruction .tab-pane").addClass("fade").first().addClass("in");
           $("#itemImg div.item").first().addClass("active");
           selectGroup();
    });
    </script> 
    

 
</body>
</html>