// JavaScript Document
$(document).ready(function()
{
	//���빺�ﳵ
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
				alert('�ɹ����빺�ﳵ');
			}
		}
		
		);
		
		 getshopcar();
		
	});
	/*��չ��ﳵ*/
	$("#ajax_clearCar").live("click",function()
	{
		$.get("index.php?m=shopcar&a=clearcar");
		getshopcar();
	});
	/*�༭��ʳ����*/
	$(".ajax_cainum").live("blur",function()
	{
		$t=$(this);
		$caiid=$t.attr("caiid");
		$cainum=$t.val();
		$url="index.php?m=shopcar&a=ajaxedinum&caiid="+$caiid+"&cainum="+$cainum;
		
		$.get($url);
		getshopcar();
	});
	
	//��֤�û��Ƿ��Ѵ���
	$("#ajax_username").bind("keyup",function()
	{
	$.get(
	"index.php?m=ajax&a=ckuser&username="+$("#ajax_username").val(),function(data)
	{
		
		if(data==1)
		{
			$("#ajax_username_res").html("�ܱ�Ǹ�����û��Ѵ��ڣ�");
		}else
		{
			$("#ajax_username_res").html("��ϲ�����û�������ע�ᣡ");
		}
	}
	)
	
	});
	//��֤�����Ƿ�Ϸ�
	$("#ajax_ckemail").bind("keyup",function()
	{
	$.get(
	"index.php?m=ajax&a=ckemail&email="+$("#ajax_ckemail").val(),function(data)
	{
		
		if(data==1)
		{
			$("#ajax_ckemail_res").html("��ϲ�������ʽ��ȷ��");
		}else
		{
			$("#ajax_ckemail_res").html("�ܱ�Ǹ�������ʽ����ȷ��");
		}
	}
	)
	
	});
	
	//��֤��֤���Ƿ�Ϸ�
	$("#ajax_ckyzm").bind("keyup",function()
	{
		$.get("index.php?m=ajax&a=ckyzm&yzm="+$("#ajax_ckyzm").val(),function(data)
		{
			if(data==1)
		{
			$("#ajax_ckyzm_res").html("��֤����ȷ��");
		}else
		{
			$("#ajax_ckyzm_res").html("��֤�����");
		}
			
		});
		
	});
	/*ͼƬ�ƶ��ֲ�*/
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
	//ͼƬ�ƶ��ֲ�����
	/*������������˵�*/
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
	//��ȡ���ﳵ
	function getshopcar()
	{
	
		$.get(
		"index.php?m=shopcar&a=ajaxgetshopcar",function(data)
		{
			$("#ajax_shopcarbox").html(data);
		}
		)			
	}
	
	