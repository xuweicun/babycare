<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Basic -->
	<meta charset="UTF-8" />

	<title>库存管理</title>

	<script src="/Public/js/browser-check.js"></script>

	<!-- Mobile Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

	<!-- Vendor CSS-->
<link href="/Public/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="/Public/assets/vendor/skycons/css/skycons.css" rel="stylesheet" />
<link href="/Public/assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="/Public/assets/vendor/css/pace.preloader.css" rel="stylesheet" />

<!-- Plugins CSS-->
<link href="/Public/assets/plugins/jquery-ui/css/jquery-ui-1.10.4.min.css" rel="stylesheet" />
<link href="/Public/assets/plugins/scrollbar/css/mCustomScrollbar.css" rel="stylesheet" />
<link href="/Public/assets/plugins/bootkit/css/bootkit.css" rel="stylesheet" />
<link href="/Public/assets/plugins/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet" />
<link href="/Public/assets/plugins/bootstrap-datepicker/css/datepicker-theme.css" rel="stylesheet" />
<link href="/Public/assets/plugins/magnific-popup/css/magnific-popup.css" rel="stylesheet" />
<link href="/Public/assets/plugins/jqvmap/jqvmap.css" rel="stylesheet" />
<link href="/Public/assets/plugins/pnotify/css/pnotify.custom.css" rel="stylesheet" />
<link href="/Public/assets/plugins/select2/select2.css" rel="stylesheet" />
<!-- Theme CSS -->
<link href="/Public/assets/css/jquery.mmenu.css" rel="stylesheet" />

<!-- Page CSS -->
<link href="/Public/assets/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="/Public/assets/css/angular-datatables.min.css" rel="stylesheet" />
<link href="/Public/assets/css/style.css" rel="stylesheet" />
<link href="/Public/assets/css/add-ons.min.css" rel="stylesheet" />

<link href="/Public/js/toastr/toastr.min.css" rel="stylesheet" />

<!-- end: CSS file-->
<!-- Head Libs -->
<style>
    li.selected a {
        background-color: green;
    }

    div.selected {
        border: 2px solid darkred !important;
    }

    div.non-selected {
        border: 2px solid white !important;
    }

    .btn-selected {
        border: 2px solid darkred !important;
        color: darkred;
    }

    .btn-not-selected {
        border: 2px solid lightgray !important;
    }

    body {
        min-height: 1000px;
    }

    .dataTables_filter label {
        width: unset !important;
    }

    .dataTables_filter input {
        width: unset !important;
    }

    .main {
        padding-top: 90px;
    }
</style>


</head>


<body ng-app="device" ng-controller="statusMonitor  as showCase" ng-cloak ng-init="is_ok = false" ng-mousedown="on_mouse_move()" ng-mousemove="on_mouse_move()">
	<!-- Start: Header -->
	<div class="navbar" role="navigation" ng-show="!taskPool.user_left && is_ok">
		<div class="container-fluid container-nav">
			<!-- Navbar Action -->
			<ul class="nav navbar-nav navbar-actions navbar-left">
				<li class="visible-md visible-lg"><a href="#" id="main-menu-toggle"><i class="fa fa-th-large"></i></a></li>
				<li class="visible-xs visible-sm"><a href="#" id="sidebar-menu"><i class="fa fa-navicon"></i></a></li>
			</ul>
			<!-- Navbar Left -->
			<div class="navbar-left">
				<!-- Search Form -->
				<form class="search navbar-form" action="search.php" target="_blank" method="post">
					<div class="input-group input-search">
						<input type="text" class="form-control bk-radius" name="key" id="q" placeholder="搜索...">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
						</span>
					</div>
				</form>
			</div>
			<!-- Navbar Right -->
			<div class="navbar-right">
				<!-- Notifications
				<div ng-include="pageViewUrls.notifyViewUrl"></div>
					 -->
				<!-- End Notifications -->
				<!-- Userbox -->
				<div class="userbox">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<!--<figure class="profile-picture hidden-xs">
							<img src="/Public/assets/img/avatar.jpg" class="img-circle" alt="" />
						</figure>-->
						<div class="profile-info">
							<span class="name">您好,<<?php echo ($username); ?>></span>
							<span class="role">
								<i class="fa fa-circle" ng-class="{false:'bk-fg-success',true:'bk-fg-default'}[user.off_line]"></i>
								<span ng-bind="role+'权限'" ng-show="!user.off_line"></span>
								<span ng-show="user.off_line">离线</span>
							</span>
							<span id="username" style="display:none" ng-disabled="user.off_line"><<?php echo ($username); ?>></span>
							<span id="userid" style="display:none" ng-disabled="user.off_line"><<?php echo ($userid); ?>></span>
							<span id="can_write" style="display:none" ng-disabled="user.off_line"><<?php echo ($can_write); ?>></span>
							<span id="token" style="display:none" ng-disabled="user.off_line"><<?php echo ($token); ?>></span>
						</div>
						<i class="fa custom-caret"></i>
					</a>

					<div class="dropdown-menu">
						<ul class="list-unstyled">
                            <li class="dropdown-menu-header bk-bg-white bk-margin-top-15">
                                <div class="progress progress-xs  progress-striped active">
                                    <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="60"
                                         aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                                        60%
                                    </div>
                                </div>
                            </li>
							<li>
								<a href="" ng-click="user_profile.showChangePasswordModal()"><i class="fa fa-usd"></i> 修改密码</a>
							</li>

                            <li>
                                <a href="" ng-click="taskPool.user_force_leave();">
                                    <i class="fa fa-lock" aria-hidden="true"></i><span>锁屏</span>
                                </a>
                            </li>
							<li>
								<a href="" ng-click="user_profile.show_logout_modal();"><i class="fa fa-power-off"></i> 注销</a>
							</li>
						</ul>
					</div>
				</div>

				<!-- End Userbox -->
			</div>
			<!-- End Navbar Right -->
		</div>
	</div>
	<!-- End: Header -->
	<div class="container-fluid content" ng-show="!taskPool.user_left">
		<div class="row">
			<div class="sidebar" ng-show="!taskPool.user_left">
				<div ng-include="pageViewUrls.siderBarUrl"></div>
			</div>
			<div class="main" ng-show="!user.off_line">
				<div class="container-fluid content" ng-hide="is_ok">
					<h4>系统正在努力加载中...请稍候！</h4>
				</div>
				<!-- Start: Content -->
				<div class="container-fluid content hidden" ng-class="{'hidden':!is_ok}" ng-show="page_index == 'main'">
					﻿<div class="row">
    <div class="panel panel-success col-lg-12 ">
        <div class="panel-heading">
            <i class="fa fa-gears"></i>数据存储柜({{cabs.curr.id}}#)
            <a href="" ng-click="initCab();" class="pull-right btn btn-danger btn-xs bk-margin-top-5"
               title="重新获取在位存储柜的数量和基本信息"><i class="fa fa-refresh"></i>存储柜在位状态查询</a>
            <a href="" class="btn btn-primary btn-xs pull-right  bk-margin-top-5 bk-margin-right-5" ng-show="cabs.getLth() > 0"
               ng-click="cabs.show_select_modal();"><i class="fa fa-refresh"></i>选择存储柜</a>
        </div>
        <div class="panel-body">
            <div class="col-lg-12">
                <p ng-show="cabs.getLth() == 0">当前没有任何存储柜信息,建议您进行 <a href="" class="btn btn-primary btn-xs" ng-click="initCab();">系统初始化</a></p>
            </div>

            <!-- <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12" ng-repeat="item in cabs.cabs">
                 <a href="" class="panel bk-widget bk-border-off" ng-click="cabs.on_select($index)"
                    ng-class="{true:'selected',false:'non-selected'}[item.selected]" style="color:white;">-->
            <div class="col-lg-5 col-md-6 col-sm-6 col-xs-12 bk-margin-top-5 bk-margin-bottom-5" ng-show="cabs.getLth()>0">
                <div class="panel bk-widget bk-border-off bk-margin-off" style="color:white;">
                    <div class="panel-body" ng-class="{true:'bk-bg-warning',false:'bk-bg-info'}[cabs.curr.bad_disk_cnt > 0]">
                        <div style="position:absolute;width:16px;right:45px;top:10px">
                            <div style="position:absolute;left:0px;top:4px;height:8px;width:2px;background-color:white;"></div>
                            <div style="position:absolute;left:2px;top:0px;height:16px;width:32px;border:white 1px solid;float:left;filter:alpha(opacity=10)">
                                <div style="background-color:white;height:12px;margin:1px;width:{{item.electricity}}%;float:right"></div>
                                <div style="position:absolute;font-size:9px;text-align:center;width:inherit;padding-top:1px"
                                     title="剩余电量">
                                    {{cabs.curr.electricity}}%
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <span style="font-size:16px;width:inherit;margin-right:10px">存储柜（{{cabs.curr.sn}}）</span>
                            </div>
                        </div>
                        <hr style="margin-top:10px;margin-bottom:10px">
                        <div class="row">
                            <span class="col-lg-12">
                                <i class="fa fa-leaf" title="电压"></i> {{cabs.curr.voltage}}V <i class="fa fa-flash"
                                                                                                style="margin-left:10px"
                                                                                                title="电流"></i>
                                {{cabs.curr.current}}A
                                <p class="pull-right bk-margin-off" ng-show="deployer.idx>0">获取硬盘信息: {{deployer.idx}}/{{deployer.getLength()}}</p>
                            </span>
                        </div>
                        <br />
                        <div class="row">
                            <div class="col-lg-12">
                                在位[<b>
                                    <span class="bk-fg-danger"
                                          ng-bind="cabs.curr.loaded_disk_cnt"></span>
                                </b>]块，桥接[<b>
                                    <span class="bk-fg-danger" ng-bind="cabs.curr.bridged_disk_cnt"></span>
                                </b>]块
                                <span class="pull-right">
                                    共{{cabs.curr.lvl_cnt}}层({{cabs.curr.grp_cnt}}组({{cabs.curr.dsk_cnt}}位))
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 col-sm-6 col-xs-12 bk-margin-top-5 bk-margin-bottom-5" ng-show="cabs.curr != null">
                <div class="panel bk-widget bk-border-off bk-margin-off" style="color:white;">
                    <div class="panel-body bk-bg-primary">
                        <div class="row">
                            <div class="col-lg-12">
                                <span style="font-size:16px;width:inherit;margin-right:10px">健康状况</span>
                            </div>
                        </div>
                        <hr style="margin-top:10px;margin-bottom:10px">
                        <br><br>
                        <div class="row">
                            <div class="col-lg-12">
                                <span>
                                    Smart异常[ <b class="bk-fg-danger">{{cabs.curr.bad_disk_cnt}}</b> ]块
                                </span>，<span>
                                    MD5异常[ <a href="" class="bk-fg-danger" title="MD5异常硬盘清单"
                                            data-container="body" data-toggle="popover" data-placement="top"
                                            data-content="请在系统报表中查看详情"><b>{{cabs.curr.bad_md5_disk_cnt}}</b></a> ]块
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body bk-bg-very-light-gray bk-padding-5 text-center" ng-show="cabs.changed">
            <p class="bk-fg-primary bk-fg-lighten">
                存储柜信息发生变化,请 <a href="#" onclick="location.reload();">点此刷新页面</a> 查看
            </p>
        </div>
    </div>
</div>

					<div class="row" ng-show="cabs.getLth() > 0">
						<div class="panel panel-default col-lg-9">
							<div class="panel-heading">
								<i class="fa fa-building-o"></i>数据存储柜({{cab.id}}#)
								<a href="" class="btn btn-danger pull-right btn-xs bk-margin-5" ng-click="deploy(cab.id,'diskinfo');" ng-disabled="deployer.working;" title="查询过程中请勿进行其他操作，以免查询失败">当前柜磁盘信息查询</a>
								<a href="" class="btn btn-danger pull-right btn-xs bk-margin-5" ng-click="deploy(cab.id,'filetree',cab.sn);" ng-disabled="deployer.working;" title="查询过程中请勿进行其他操作，以免查询失败">当前柜文件目录查询</a>
								<a href="" class="btn btn-danger pull-right btn-xs bk-margin-5" ng-click="stopDeploy(cab.id);" ng-show="deployer.working;" title="查询过程中请勿进行其他操作，以免查询失败">停止当前柜查询操作</a>
								<a ng-click="cab.start_cmd_device_status()"
								   class="btn btn-primary btn-xs pull-right bk-margin-5"
								   ng-class="{ true:'btn-warning', false:'btn-primary' }[cab.is_device_status_cmd_going()]"
								   title="查询当前柜磁盘在位信息">
									当前柜磁盘在位查询
								</a>
							</div>
							<div class="panel-body" ng-include="pageViewUrls.cabinetViewUrl">
							</div>
						</div>
						<div class="panel panel-default col-lg-3">
							<div class="panel-heading">
								<i class="glyphicon glyphicon-hdd bk-margin-left-5"></i>盘位信息
							</div>
							<div class="panel-body" ng-include="pageViewUrls.diskViewUrl">
							</div>
						</div>
					</div>
					<div class="row" ng-show="taskPool.ready==true" ng-controller="InitCtrl">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" ng-include="pageViewUrls.taskViewUrl">
						</div>
					</div>
				</div>
				<div class="container-fluid content" ng-show="page_index == 'user_log'">
					<div ng-include="pageViewUrls.userLogViewUrl"></div>
				</div>
				<div class="container-fluid content" ng-show="page_index == 'manul'">
					<div ng-include="pageViewUrls.manulViewUrl"></div>
				</div>
				<!--/container-->
			</div>
		</div>
	</div>
    <div class="container-fluid content" ng-show="taskPool.user_left">
        <div class="row">
            <!-- Main Page -->
            <div class="body-sign body-locked">
                <div class="center-sign">
                    <div class="panel bk-bg-white panel-sign">
                        <div class="panel-body text-center bk-padding-off bk-wrapper">
                            <div class="bk-avatar bk-avatar120-halfdown">
                                <div class="bk-vcenter"></div>
                                <div class="bk-fg-info bk-fg-darken">
                                    <img src="Public/assets/img/avatar1.jpg" alt="" class="img-circle bk-img-120 bk-border-white bk-border-darken bk-border-3x" />
                                </div>
                            </div>
                        </div>
                        <div class="panel-body bk-bg-white bk-padding-left-30 bk-padding-right-30 bk-avatar120-halfdown-after text-center">
                            <h3 class="bk-margin-off"><strong><<?php echo ($username); ?>></strong></h3>
                            <div class="bk-padding-bottom-30 bk-padding-top-10">
                                <p>页面锁定</p>
                            </div>
                            <div class="form-group">
                                <div class="input-group input-group-icon">
                                    <input id="prependedInput" class="form-control bk-radius" size="16" type="password" placeholder="请输入解锁密码" ng-model="user_unlock_pwd" />
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <span class="bk-fg-danger text-left">
                                {{user_unlock_msg}}
                            </span>
                            <div class="pull-right">
                                <button type="button" class="btn btn-primary" ng-click="user_unlock()" ng-disabled="!user_unlock_pwd || btn_guard">解锁</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Main Page -->

        </div>
    </div><!--/container-->
	<div ng-include="pageViewUrls.modalHelperUrl"></div>
<div ng-include="pageViewUrls.userModalsUrl"></div>
<!-- start: JavaScript-->

<!-- Vendor JS-->
<script src="/Public/assets/vendor/js/jquery.min.js"></script>
<script src="/Public/assets/vendor/js/jquery-2.1.1.min.js"></script>
<script src="/Public/assets/vendor/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/Public/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/Public/assets/vendor/skycons/js/skycons.js"></script>
<script src="/Public/assets/vendor/js/pace.min.js"></script>
<script src="/Public/js/md5.js"></script>

<!-- Plugins JS-->
<script src="/Public/assets/plugins/jquery-ui/js/jquery-ui-1.10.4.min.js"></script>
<script src="/Public/assets/plugins/scrollbar/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/Public/assets/plugins/bootkit/js/bootkit.js"></script>
<script src="/Public/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="/Public/assets/plugins/magnific-popup/js/magnific-popup.js"></script>

<script src="/Public/assets/plugins/select2/select2.js"></script>
<script src="/Public/assets/plugins/jquery-datatables/media/js/jquery.dataTables.js"></script>
<script src="/Public/js/angular-1.4.min.js"></script>
<script src="/Public/js/angular-datatables.min.js"></script>
<!-- Theme JS -->
<script src="/Public/assets/js/jquery.mmenu.min.js"></script>
<script src="/Public/assets/js/core.min.js"></script>

<!-- Pages JS -->
<script src="/Public/assets/js/pages/ui-modals.js"></script>
<script src="/Public/assets/plugins/jquery-validation/js/jquery.validate.js"></script>
<script src="/Public/assets/plugins/pnotify/js/pnotify.custom.js"></script>

<script src="/Public/js/angular-sanitize.min.js"></script>
<script src="/Public/js/toastr/toastr.min.js"></script>

<!-- global variables define -->
<script src="/Public/js/cabinet/globalvars.js"></script>

<!-- 用于前端命令处理 -->

<script src="/Public/js/cabinet/modalhelper.js"></script>
<script src="/Public/js/cabinet/CabCmd.js"></script>
<script src="/Public/js/cabinet/CabCmd.js"></script>
<script src="/Public/js/cabinet/CabCmdHelper.js"></script>
<script src="/Public/js/cabinet/TaskPool.js"></script>
<script src="/Public/js/cabinet/deployer.js"></script>
<script src="/Public/js/cabinet/caution.js"></script>
<!-- cabinet.js 必须放到 globaljs.js之前 -->
<script src="/Public/js/cabinet/Disk.js"></script>
<script src="/Public/js/cabinet/cabinet.js"></script>
<script src="/Public/js/cabinet/cabinethelper.js"></script>
<script src="/Public/js/cabinet/user.js"></script>
<script src="/Public/js/cabinet/userLog.js"></script>

<script src="/Public/js/cabinet/globaljs.js"></script>

<!-- page_init.js 必须放到 globaljs.js之后 -->
<script src="/Public/js/cabinet/page_init.js"></script>
<script src="/Public/js/cabinet/services.js"></script>

<!-- end: JavaScript-->

</body>
</html>