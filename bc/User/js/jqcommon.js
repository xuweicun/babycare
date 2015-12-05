// JavaScript Document
$(document).ready(function()
{
	//加入购物车
	$(".addCar").click(function()
	{
		$id=$(this).attr("caiid");
		
		$.get(
		"index.php?m=shopcar&a=add_db&ajax=1&id="+$id,function(data)
		{
			if(data)
			{
				alert(data);
			}else
			{
				alert('成功加入购物车');
			}
		}
		
		);
		
		 getshopcar();
		
	});
	/*清空购物车*/
	$("#ajax_clearCar").live("click",function()
	{
		$.get("index.php?m=shopcar&a=clearcar");
		getshopcar();
	});
	/*编辑美食数量*/
	$(".ajax_cainum").live("blur",function()
	{
		$t=$(this);
		$caiid=$t.attr("caiid");
		$cainum=$t.val();
		$url="index.php?m=shopcar&a=ajaxedinum&caiid="+$caiid+"&cainum="+$cainum;
		
		$.get($url);
		getshopcar();
	});
	
	//验证用户是否已存在
	$("#ajax_username").bind("keyup",function()
	{
	$.get(
	"index.php?m=ajax&a=ckuser&username="+$("#ajax_username").val(),function(data)
	{
		
		if(data==1)
		{
			$("#ajax_username_res").html("很抱歉，该用户已存在！");
		}else
		{
			$("#ajax_username_res").html("恭喜！该用户名可以注册！");
		}
	}
	)
	
	});
	//验证邮箱是否合法
	$("#ajax_ckemail").bind("keyup",function()
	{
	$.get(
	"index.php?m=ajax&a=ckemail&email="+$("#ajax_ckemail").val(),function(data)
	{
		
		if(data==1)
		{
			$("#ajax_ckemail_res").html("恭喜！邮箱格式正确！");
		}else
		{
			$("#ajax_ckemail_res").html("很抱歉，邮箱格式不正确！");
		}
	}
	)
	
	});
	
	//验证验证码是否合法
	$("#ajax_ckyzm").bind("keyup",function()
	{
		$.get("index.php?m=ajax&a=ckyzm&yzm="+$("#ajax_ckyzm").val(),function(data)
		{
			if(data==1)
		{
			$("#ajax_ckyzm_res").html("验证码正确！");
		}else
		{
			$("#ajax_ckyzm_res").html("验证码错误");
		}
			
		});
		
	});
	/*图片移动轮播*/
	$("#slide-gallery-prev").live("click",function()
	{
		left=parseInt($("#slide-gallery-container").css("left"));
		num=$("#slide-gallery-container").attr("num");
		len=$("#slide-gallery-container>li").length;
		f=$("#slide-gallery-container>li:eq(0)");
		w=parseInt(f.css("width"))+parseInt(f.css("padding-right"));
		left=left+(-w)*num;
		if(left>-len*w)
		{
		$("#slide-gallery-container").css("left",left+"px");
		}
		
	});
	
	$("#slide-gallery-next").click(function()
	{
		num=$("#slide-gallery-container").attr("num");
		left=parseInt($("#slide-gallery-container").css("left"));
		len=$("#slide-gallery-container>li").length;
		f=$("#slide-gallery-container>li:eq(0)");
		w=parseInt(f.css("width"))+parseInt(f.css("padding-right"));
		left=left+w*num;
		
		if(left<=0)
		{
		$("#slide-gallery-container").css("left",left+"px");
		}
	});
	//图片移动轮播结束
	/*配送区域二级菜单*/
	$("#ajax_sendarea1").live("change",function()
	{
		
		$.get("index.php?m=shopcar&a=AjaxSendArea&pid="+$(this).val(),function(data)
		{
			$("#ajax_sendarea2").empty();
			if(data)
			{
				$("#ajax_sendarea2").append(data);
				$("#ajax_sendarea2").css("visibility","visible");
			}else
			{
				$("#ajax_sendarea2").css("visibility","hidden");
			}
												
		});
	});


	
});
	//获取购物车
	function getshopcar()
	{
	
		$.get(
		"index.php?m=shopcar&a=ajaxgetshopcar",function(data)
		{
			$("#ajax_shopcarbox").html(data);
		}
		)			
	}
	
	