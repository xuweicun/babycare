<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Flat UI Free</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!-- Loading Bootstrap -->
    <link href="/Public/css/bootstrap.min.css" rel="stylesheet">
 
    <!-- Loading Flat UI -->
    <link href="/Public/css/flat-ui.css" rel="stylesheet">
    <link href="/Public/css/custom.css" rel="stylesheet">
 

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="../../dist/js/vendor/html5shiv.js"></script>
      <script src="../../dist/js/vendor/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <style>
      body {
        min-height: 2000px;
        padding-top: 70px;
      }
      div.thumbnail img{
        
        min-width: 50%;
        height:300px;
      }
    </style>
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



    <div class="container-fluid">
      <div class="jumbotron">
        <h2 >了解更多，照顾更好</h2>
        <P>在这里找到母婴用品的用法、评价、产地、材质以及更多:)</P>
        <P style="color:green;">Find everything you should know about the items you bought for your lovely baby :)</P>
        <P>一位曾经因一无所知而手忙脚乱的新爸爸创建于2015，只为所有全心全意抚育宝宝的爸爸妈妈.</P>
        
        <P style="color:green;">Since 2015, created by a new dad who doesn't know what to use, where to buy and how to use, for every mom and dad who try their best to take care of the baby.</P>
       
        <a href="https://feitui.taobao.com/?spm=2013.1.1000126.3.ItHGH8" class="btn  btn-sm btn-success">逛逛我们的淘宝店铺<span class="glyphicon glyphicon-shopping-cart"></span></a>
      </div>
      <div class="row-fluid">
        <div class="span12">
          <div class="row-fluid">
          <div class="row">
           
            <?php if(is_array($items)): foreach($items as $key=>$t): ?><div class="col-sm-6 col-md-3">

              <div class="thumbnail thumbnail-alert">
                <img data-src="<?php echo ($t["thumb_img"]); ?>" src="<?php echo ($t["img"]); ?>" alt="image not found">
                <div class="caption">
                  <h6><?php echo ((isset($t["name"]) && ($t["name"] !== ""))?($t["name"]):'name not found'); ?></h6>
                  <p><?php echo ($t["company"]); echo ($t["brand"]); ?></p>
                  <p><a role="button" class="btn btn-primary btn-block" href="/index.php/User/Index/viewitem/id/<?php echo ($t["id"]); ?>">详情 <span class="glyphicon glyphicon-arrow-right"></span></a>
                   
               </p>
                </div>
              </div>
            </div><?php endforeach; endif; ?>
          </div>
          <?php echo ($page); ?>
           

      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    
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
    <script src="/Public/js/application.js"></script>
    <script type="text/javascript">
        //$('#modal').modal({keyboard:true});
    </script>

  </body>
</html>