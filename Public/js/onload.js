// JavaScript Document

//some day to move this into a common js file

var ajaxListChildren = function(id,ajx_url)
{
	//alert("changed");
	var toReplace = "#"+id;
	$.ajax({ 
		type: "post", //以post方式与后台沟通
		url: ajx_url,//"/index.php/Home/Category/listChildren/layer/1",, //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
		//data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: function(json){
				
				if(json['view'] != "error")
				{
					$(toReplace).html(json['view']);
				}
				else
				{
					$(toReplace).html("<option>暂无选项</option>");
				//	$("#"+id).after(json['view']);
				}
			},
		fail:function(){$(toReplace).html();}
		});

}
//function selectDropDown: 用于修改FlatUI中的选项选择事件;
//param selectedID: 被选中的项目的ID;
//param name:被选中项目的名称，用于替换标题;
//param titleID: 标题ID
var selectGroup  = function()
{
	$(".selectgroup").bind("click",function(e){
        var $this = $(e.target);
        $this.parent().children().each(function(){
        	$(this).removeClass("active");
          var content = $(this).html().split("<");
          $(this).html(content[0]);

        });
        var check = $("<span class='glyphicon glyphicon-check'></span>");
        $this.addClass("active").append(check);
        
      })
}
var selectDropDown = function(selectedID,name,titleID)
{
	var $target = $(selectedID);
    $("#"+titleID).html(name+"<span class='caret'></span>");
    $target.parent().children().each(function()
            {
                $(this).removeClass("active");
            }    
        );     
        $target.addClass("active");   
}
var getItemImgs = function(id,viewId,container)
{
	var params = { item_id:id, view_id:viewId};
	var param = $.param(params);
	if(!container)
	{
		container = "imgContainer";
	}
	$.ajax({ 
		type: "post", //以post方式与后台沟通
		url: "/index.php/Home/Bestforbaby/getImg", //与此php页面沟通
		dataType:'json',//从php返回的值以 JSON方式 解释
		data: param, //发给php的数据有两项，分别是上面传来的u和p
		success: function(json){			
				if(json['error'])
				{
					
				}
				else
				{
					if (json['view'].length==0) {

						var view = "<div class='alert alert-warning'><a data-dismiss='alert' class='close' href='#alert'>x</a><p>暂时没有图像</p></div>";
						$("#"+container).html(view);	
					}
					else
					$("#"+container).html(json['view']);
					//var originVal =  $(event.target).html();
      				//$(event.target).html(originVal+" <span class='glyphicon glyphicon-check'></span>");
				//	$("#"+id).after(json['view']);
				}
			},
		fail:function(){}
		});

}
var showElement = function(id)
{
	$("#"+id).show();	
}
var hideElement = function(id)
{
	$("#"+id).hide();	
}
var removeElement = function(id)
{
	$("#"+id).remove();
}
	



var toggleElement = function(id)
{

	$("#"+id).toggle();	

}
var removeElement = function(id)
{
	$("#"+id).remove();
}

//-->
