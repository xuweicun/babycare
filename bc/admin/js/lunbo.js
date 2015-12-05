 var t = n = 0, count;    
 $(document).ready(function(){

 count=$("#index_banner_list a").length;          
 $("#index_banner_list a:not(:first-child)").hide();        
 $("#index_banner_info").html($("#index_banner_list a:first-child").find("img").attr('alt'));        
 $("#index_banner_info").click(function(){
	 window.open($("#index_banner_list a:first-child").attr('href'), "_blank")});        
	 $("#index_banner li").click(function() {           
	  var i = $(this).text() - 1;//获取Li元素内的值，即1，2，3，4           
 	n = i;            
	if (i >= count) return;           
	 $("#index_banner_info").html($("#index_banner_list a").eq(i).find("img").attr('alt'));           
	  $("#index_banner_info").unbind().click(function(){window.open($("#index_banner_list a").eq(i).attr('href'), "_blank")})           
	   $("#index_banner_list a").filter(":visible").fadeOut(500).parent().children().eq(i).fadeIn(1000);           
	    $(this).css({"background":"#be2424",'color':'#000'}).siblings().css({"background":"#6f4f67",'color':'#fff'});        });        
		t = setInterval("showAuto()", 4000);        
		$("#index_banner").hover(function(){clearInterval(t)}, function(){t = setInterval("showAuto()", 4000);});    })        
		function showAuto()    
		{       
		 n = n >=(count - 1) ? 0 : ++n;       
		  $("#index_banner li").eq(n).trigger('click');   
		  }
		  