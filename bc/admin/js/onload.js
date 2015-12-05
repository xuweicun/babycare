

var flag_for_fixedsearch = 0;
// 判断屏幕是否旋转

function orientationChange() {

	switch(window.orientation) {

	　　case 0:

			//alert("肖像模式 0,screen-width: " + screen.width + "; screen-height:" + screen.height);

			break;

	　　case -90:

			//alert("左旋 -90,screen-width: " + screen.width + "; screen-height:" + screen.height);

			break;

	　　case 90:   

			//alert("右旋 90,screen-width: " + screen.width + "; screen-height:" + screen.height);

			break;

	　　case 180:   

		　//　alert("风景模式 180,screen-width: " + screen.width + "; screen-height:" + screen.height);

		　　break;

	};
}
// 添加事件监听

addEventListener('load', function(){

	orientationChange();

	window.onorientationchange = orientationChange;

});


var menu = new Object();
menu.cdMenuClicked = function(cat_id)
{
	//获得菜单所有li；
	var $lists = $('#left-menu ul').children();
	
	$lists.each(
	function()
	{
		var $li = $(this);
		var $li_a = $li.children("a");
		   
		var str = "#food_cat_"+$li.attr('id');
		if($li.attr('id') == cat_id)
		{
			$li_a.css("background","#fff6f1").css("color","#e4393c");
			$(str).css("display","block");
			
		}
		else
		{
			$li_a.css("background","#efefee").css("color","#333");
			$(str).css("display","none");
		}
	}); 
}
	
var cart = new Object();
cart.clearCart = function(id,source)
{
	$item_num = $("#items").children().size();//剩余商品条目数量；
	var info = {};
	if(id>0)
	{
		info['id'] = id;
		info['act'] = "delete_one";
		if(source != "minus_button")
		{
			switch($item_num)
			{
				case 1:
				if(!confirm("您确定要清空购物车吗？"))
				{
					return;
				}
				break;
				default:
				if(!confirm("您确定要删除该商品吗？"))
				return;
				break;
			}
		}
	}
	else
	{
		if(confirm("您确定要清空购物车吗？"))
		{info['act'] = "delete_all";}
		else
		{return;}
	}
	var param = $.param(info);
	$.ajax({ 
		type: "post", //以post方式与后台沟通
		url: "index.php?m=ajax&a=ajaxClearCart", //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
		data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: function(json){//如果调用php成功
			
			if(!json['err_info'])
				return;
			$cart = $("#cart_info");
			if(json['err_info']=="Done")
			{
				if(id != undefined && info['act'] == "delete_one")
				{
					$("#item_"+id).remove();
					var $items = $("#items");
					if($items.children().size()==0)
					{
						$items.remove();
						 window.location.href="index.php"; 
						}
				}
				else
				{
					$("#cart-content").remove();
					 window.location.href="index.php"; 
						   
				}
			}
		},
		fail:function()
		{alert("fail");}
		}); 
	}
cart.incNum = function(food_id)
{
	
	var food_num = $(food_id);
	var value = food_num.attr("value");
	var $info_id = food_num.attr("id").split("_");
	var id = $info_id[1];
	value = parseInt(value) + 1;
		var food_info = {id:id,num:value};
		if(value == 1)
		{			
			///如果value之前是0，则需要创建该菜品在购物车中的值。
			food_info['act'] = "new";
			var info = $("#info_"+id);//info前面加$，表示这个是jquery对象；
			
			var info_str = info.text().split(" ");
			//name,price和image src分别存储在一个不显示的元素的标签中
			food_info['name'] = info_str[0];
			food_info['price'] = info_str[1];
			food_info['img'] = info.attr("title"); 			
		}
		
		updateChart(food_info);				
		food_num.attr("value",value);
		
}
cart.decNum = function(food_id)
{
	
	var food_num = $(food_id);
	var value = parseInt(food_num.attr("value"));
	var info_id = food_num.attr("id").split("_");
	var id = info_id[1];
	var tag = food_num.attr("tag");
	  if(value>0)
		{
			if(tag=="cart-page")
			{
				if(value == 1)
				{
					var str = $("#items").children().size() > 1?"您确认删除该商品？":"您确认要清空购物车？";
					if(confirm(str))
					{
						cart.clearCart(id,"minus_button");
					}
					else
					{
						return;
					}
				}
			}
			value = parseInt(value) - 1;
			var food_info = {id:id,num:value};
			if(value == 1)
			{
				food_info['act'] = "update";
			}
			
			food_num.attr("value",value);
		
			//更新session购物车和数据库
			 updateChart(food_info);

		}
		else
		{
			return;
		}
		  
		
}
function updateChart(food_info)
{
	var param = $.param(food_info);
	
	$.ajax({ 
		type: "post", //以post方式与后台沟通
		url: "index.php?m=ajax&a=ajaxUpdateCart", //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
		data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: function(json){//如果调用php成功
		
			if(json['err_info'])
				console.log(json['err_info']);
			
			if(json['zongshu']<= 0)
			{
				$cart = $("#empty_cart");
				$cart.css("display","block");
				$("#cart").css("display","none");
				return;
			}
			$cart = $("#cart");
			$cart.children(":eq(0)").html(json['zongshu']+"件");
			$cart.children(":eq(2)").html(json['zongjia']+"元");
			$cart.css("display","block");

			$("#empty_cart").css("display","none");
			
		},
		fail:function()
		{alert("fail");
		console.log("s"); }
		});
	
}
var opts = {
  lines: 12, // The number of lines to draw
  length: 5, // The length of each line
  width: 2, // The line thickness
  radius: 5, // The radius of the inner circle
  color: '#000', // #rbg or #rrggbb
  speed: 1, // Rounds per second
  trail: 100, // Afterglow percentage
  shadow: false // Whether to render a shadow
};
var cdOrderSubmit = function()
{
	event.preventDefault();
	if(!c_orderSubmit())
	{
		return false;
	}
	
	var target = $('#progress');
	var spinner = new Spinner(opts).spin(target);
	var name = $("#guest-name").val();
	var phone = $("#guest-phone").val();
	var address = $("#guest-adress").val();
	var note = $("#guest-note").val();
	var guest_info = {name:name,phone:phone,address:address,note:note,a:'ajaxOrderSubmit'};
	var param = $.param(guest_info);
	$.ajax({ 
		type: "post", //以post方式与后台沟通
		url: "index.php?m=ajax&a=ajaxOrderSubmit", //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
		data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: function(json){
			if(json && json['err_info'])
			{
				if(confirm("非常抱歉，订单提交失败，是否放弃本次点餐？"))
					{
						location.href="index.php";
						return false;
					}
				else
					return false;
			}
			window.location.href="index.php?m=order&a=showinfo&orderno="+json['orderno']; 
			},
		fail:function(json){
			
			}
	});
   
}
var cdJsonAjax = function(method,url,param,sucFunc,failFunc)
{
	$.ajax({ 
		type: method, //以post方式与后台沟通
		url: url, //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
		data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: sucFunc(json),
		fail:failFunc(json)});
}
var cdAjaxPageLoad = function()
{

	var $ctgrs = $('#menu-list').children();
	var $first = $('#menu-list li:first a');
	//设置第一个li为默认选中项
	$first.css("background","#fff6f1").css("color","#e4393c");
	$ctgrs.each(    
	function(){
		var $li = $(this);
		var food_cat = {cat_id:$li.attr('id'),a:'ajaxWeb'};
		var param = $.param(food_cat); 
		var result = $.ajax({
		type:"post",
		url:"index.php?m=ajax&a=ajaxWeb",//待优化；
		data:param,
		success:function()
		{
		  
			var cat_div_id = "#food_cat_"+$li.attr('id');
			
			var $c_d_i = $(cat_div_id);
			$c_d_i.html(result.responseText);
			//$c_d_i.removeAttr("style");
			
		}
		}
		);
	}
	);
	//显示第一个类别的商品；
	var cat_div_id = "#food_cat_"+$ctgrs.first().attr('id');
	var $item = $(cat_div_id);
	$item.css("display","block");
	
}

