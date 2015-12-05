<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!--[if IE 8]>
<html xmlns="http://www.w3.org/1999/xhtml" class="ie8" lang="zh-CN">
<![endif]-->
<!--[if !(IE 8) ]><!-->
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>登录</title>
    <link rel='stylesheet' id='wp-admin-css' href="./assets/css/login.css" type='text/css' media='all' />
    <div class="logo-main">
    </div>
</head>
<body class="login ">
<div id="login">
    <h1></h1>
    <form name="loginform" id="loginform" action="xlc_login_a?log" method="post">
        <p>
            <label for="user_login">用户名<br/>
                <input type="text" name="log" id="user_login" class="input" value="" size="20" /></label>
        </p>
        <p>
            <label for="user_pass">密码<br/>
                <input type="password" name="pwd" id="user_pass" class="input" value="" size="20" /></label>
        </p>
<!--        <p class="forgetmenot"><label for="rememberme"><input name="rememberme" type="checkbox" id="rememberme" value="forever"/>记住我的登录信息</label></p>-->
        <p class="submit">
            <input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-large" value="管理员登录" />
            <input type="hidden" name="redirect_to" value="http://salongweb.com/wp-admin/"/>
            <input type="hidden" name="testcookie" value="1" />
        </p>
    </form>
    <script type="text/javascript">
        function wp_attempt_focus(){
            setTimeout( function(){ try{
                d = document.getElementById('user_login');
                d.focus();
                d.select();
            } catch(e){}
            }, 200);
        }
        wp_attempt_focus();
        if(typeof wpOnload=='function')wpOnload();
    </script>
</div>

<div class="clear"></div>
</body>
</html>