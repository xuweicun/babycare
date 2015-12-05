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
      
      <div class="row-fluid">
        <div class="span12">
          <div class="row-fluid">
          
          <div class="well">
            搜索关键词：<span class="label label-success"><?php echo $_POST['key'];?>  <a href="/index.php/User"><span class="glyphicon glyphicon-trash" style="color:white;"></span></a></span> 
            
          </div>
          <?php if(empty($items)): ?><div class="alert alert-warning">
            <span class="glyphicon glyphicon-exclamation-sign"></span> 对不起，没有搜索结果，请检查您的搜索关键词...
          </div><?php endif; ?>
          <div class="row">
           
            <?php if(is_array($items)): foreach($items as $key=>$t): ?><div class="col-sm-6 col-md-3">

              <div class="thumbnail thumbnail-alert">
                <img data-src="<?php echo ($t["thumb_img"]); ?>" src="<?php echo ($t["img"]); ?>" alt="image not found">
                <div class="caption">
                  <h5><?php echo ((isset($t["name"]) && ($t["name"] !== ""))?($t["name"]):'name not found'); ?></h5>
                  <p><?php echo ($t["company"]); echo ($t["brand"]); ?></p>
                  <p><a role="button" class="btn btn-primary btn-block" href="/index.php/User/Index/viewitem/id/<?php echo ($t["id"]); ?>">详情</a>
                   <a role="button" class="btn btn-info btn-block" href="/index.php/User/Index/edititem/id/<?php echo ($t["id"]); ?>">编辑</a>
                 <a role="button" class="btn btn-default btn-block" href="/index.php/User/Index/deleteitem/id/<?php echo ($t["id"]); ?>">删除</a>
               </p>
                </div>
              </div>
            </div><?php endforeach; endif; ?>
          </div>
          <?php echo ($page); ?>
           

      </div>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/Public/js/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/Public/js/bootstrap.min.js"></script>
    <script src="/Public/js/flat-ui.min.js"></script>

    <script src="/Public/js/application.js"></script>
    <script type="text/javascript">
        //$('#modal').modal({keyboard:true});
    </script>

  </body>
</html>