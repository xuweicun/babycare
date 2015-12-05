var imgctrl=0;
var imgname="";
function chimg(){
	if(imgctrl==1)
	{
		$("#picimg").attr("src",imgname);
	}
}
$(document).ready(function()
{
	$("#picimg").attr("src",$(".thumb_pic:eq(0)").attr("name"));
	
	$(".thumb_pic").live('mouseover',function()
	{
		imgctrl=1;
		imgname=$(this).attr("name");
		setTimeout("chimg()",1000);
	
	});
	
	$(".thumb_pic").live('mouseout',function()
	{
		imgctrl=0;
	});
	
	
	$("#lastpicbtn,#nextpicbtn").click(function()
	{
		$.get(
		$(this).attr("href"),
		{
			
		},function(data)
		{
			if(data)
			{
				
				$("#lastpicbtn").attr("href",data.lastpage);
				$("#nextpicbtn").attr("href",data.nextpage);
			str="";
			for(i=0;i<data.rs.length;i++)
			{
				str+='<div class="img"><img class="thumb_pic" src="'+data.rs[i].thumb_picurl+'" name="'+data.rs[i].picurl+'" /></div>';
			}
			$("#picnavmid").html(str);
			}
		},"json"
		)
	});
})