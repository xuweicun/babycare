// JavaScript Document
$(document).ready(function()
{
	$(".pmenu").mouseover(function()
	{
	$(".childmenu").css({display:"none"});
	 $(this).next(".childmenu").css({display:"block"})
	 
	
	});
	
	$(".childmenu li").mouseout(function()
	{
		
	 $(".childmenu").css({display:"none"});
	
	});

});
