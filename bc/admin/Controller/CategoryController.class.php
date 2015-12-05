<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class CategoryController extends Controller {
	protected $_table = "category"; 
	protected $_fathertable = "";
	protected $_shownum = 10;
	protected $_sucurl = "/index.php/home/category/viewitems";
	protected $_bindingTable = "bc_best_for_baby";
	protected $_controller = "/index.php/home/category/";
	public function index(){

		$this->display();

	} 
	/*
	*查看所有 
	* 
	*/

	public function viewitems($level = -1,$outside = false)
	{
		//判断是其他控制器外部调用还是浏览器访问
		$level = $outside ? $level : I('get.layer',0,'intval');//default: layer 0        
		$db = D($this->_table);
		
		$count=$db->where("layer = %d",$level)->count();       
		
		$page=new \Think\Page($count,$this->_shownum); 
		$items = $db->where("layer = %d",$level)->select();
		
		 
		if($outside)
		{
			//This is a date request;
			return $items;
			die();
		}
		//var_dump($page);
		$show = $page->show();
		
		$this->assign("items",$items);
		$this->display();
	}
	public function getItems($level)
	{
		return $this->viewItems($level,true);
	}
	/*
	*查看某个
	* 
	*/
	public function viewitem()
	{
		$db = D($this->_table);
		$id = I('get.id',0,'intval');
		if($id==0)
		{
			$this->error('不存在',$this->_sucurl,2);   
			die();
		}
		else
		{
			$item = $db->where("id = %d",$id)->find();
			if($item['father_id'] > 0)
			{
				$father = $db->where("id=%d",$item['father_id'])->find(); 
				$this->assign("father",$father); 
			}           
			$this->assign("item",$item);
			// $this->assign("instructions",$items);
			$this->display();  
		}
	}
	public function editLink()
	{
		$id = I('get.id',0,'intval');
		$action = I('get.type','add_dad');
		$db = M($this->_table);
		$item =  $db->where('id=%d',$id)->find(); 
		if(IS_POST)
		{
			if($db->create()->save())
			{
				$this->success("成功",$this->_sucurl,1); 
			}
			else
			{
				$this->error("失败",$this->_sucurl,1);
			}
		}
		else
		{
			if($action == "add_dad")
			{
				$layer = $item['layer'] + 1;    
			}    
			else
			{
				$layer = $item['layer'] - 1;    
			}
			$items;
			$show;
			if($rs = $this->_getLayer($layer,$items,$show))
			{
				$this->assign("items",$items);
				$this->assign("page",$show);
			}
			$this->display();
		}
	}
	private function _getLayer($layer,&$items=null,&$show=null)
	{                  
		$db = M($this->_table);
		$count = $db->where("layer = %d",$layer)->count();       
		if($count == 0 || !$count)
		{
			return $count;
		}
		$page=new \Think\Page($count,$this->_shownum); 
		$items = $db->limit($page->firstRow.','.$page->listRows)->select();
		//var_dump($page);
		$show = $page->show();
		if(IS_AJAX)
		{

			$this->ajaxReturn();
		}
	}
	public function deleteitem()
	{
		$id = I('get.id',0,'intval'); 
		if($id == 0)
		{
			$this->error('对象不存在');   
			die(); 
		}
		else
		{
			$db = D($this->_table); 
			if($item = $db->where('id=%d',$id)->find())
			{
				if($item['layer'] == 0)
				{
					$count = $db->table("bc_best_for_baby")->where("category_id=%d",$id)->count();
					if($count > 0)
					{
						$this->error("由于当前有属于此类别的物品，因此无法删除该类别");
						die();
					}

				}  
				if(!$db->where('id=%d',$id)->delete())
				{
					$this->error('操作失败');
				}
				else
				{                     
					$this->_dropChildren($id);
					
				}
			}
			else
				$this->error('对象不存在');

		}
	}

	private function _dropChildren($id)
	{
		$db = D($this->_table); 
		$items = $db->where("father_id = %d",$id)->select();
		foreach($items as $t)
		{
			$t['father_id'] = 0;
			$db->save($t);
		}
	}
	/*
	* 
	*/
	public function searchitem()
	{      
		$db = D($this->_table);
		$key = I('post.key','');

		if(!empty($key))
		{                       
			$key = '%'.$key.'%';               
			$map['name'] = array('like',$key);             
			$items = $db->where($map)->count();      
			$page  = new \Think\Page($count,$this->_shownum); 
			$items = $db->where($map)->limit($page->firstRow.','.$page->listRows)->select();        
			$show  = $page->show();              
			$this->assign("items",$items);       
			$this->assign("page",$show);
		}    
		$this->display();  
	}
	private function _listItems($db,&$items,&$page,$where = null)
	{
		$key = '%'.$key.'%';               
		$items = $db->where($where)->count();      
		$page  = new \Think\Page($count,$this->_shownum); 
		$items = $db->where($where)->limit($page->firstRow.','.$page->listRows)->select();        
		$show  = $page->show();              
	}
	public function insertitem()
	{
		$db = D($this->_table); 
		if(IS_POST)
		{        

			if($data = $db->create())
			{
				$this->insertFatherLayer($db);
				if(@$id = $db->add($data))
				{
					//插入成功
					$this->success("插入数据成功");
					// echo("<img src = '{$db->img}'></img>");
				}
				else
				{
					$this->error($db->getError());
				}              
			}
			else
			{
				$this->error($db->getError());     
			}
		}
		else
		{

			$layer = I('get.layer',0,'intval');
			
			$father_layer = $layer+1;
			$where = "layer=$father_layer";                 
			$father = $db->where($where)->select(); 
			$items = $db->where("layer=$layer")->select();
			$this->assign("father",$father);
			$this->assign("items",$items);              
			$this->assign("layer",$layer);
			$this->display();
		}
	}
	public function listChildren()
	{

	  if(IS_AJAX)
	  {
		   $id = I('get.id',0,'intval');
		   $type = I('post.type',null);
		   $toDo = I('post.toDo',null);
		   
		   if($id > 0)
		   {
			   $db = M($this->_table);
			   $rs = $db->where("father_id=%d",$id)->select();
			   
			   if($rs)
			   {
				   $idName = "ctgr_id";
				   $this->assign("to_do",is_null($toDo) ?  "选择类别":$toDo);
				   $this->assign("items",$rs);     
				   $this->assign("set_name",$idName);     
				   $this->assign("option_name",$idName);  
				   $this->assign("type",is_null($type)? "select":$type);   
				   $data['view'] = $this->fetch();                      
				   $this->ajaxReturn($data);
			   }
			   else
			   {
				   $data['view'] = "error";
				   $this->ajaxReturn($data);                   
			   }
		   }       
		   else
		   {
				$err['err'] = "error: id incorrect";//err_msg  code
				$this->ajaxReturn($err);    
		   }
		   
	  }
	  else
	  {
		  return;
	  }
	}
	public function editChildren()
	{
		$id = I('get.id',0,'intval');     

		if(IS_POST)
		{
			$selected = I('post.selected');
			foreach($selected as $t)
			{
				$this->_editFather($t,$id);
			}

		}
		else
		{   
			$db = M($this->_table);
			$item =  $db->where('id=%d',$id)->find();  
			$layer = $item['layer'] - 1;
			$items = $db->where('layer=%d',$layer)->select();
			$this->assign('item',$item);
			$this->assign('items',$items);
			$this->display();
		}
	}
	private function _editFather($id,$father_id)
	{

	}
	public function innerupload()
	{
		$this->display();
	}
	public function uploadimg()
	{
		$config = array(
		'maxSize'    =>    3145728,
		'rootPath'   =>    THINK_PATH,
		'savePath'   =>    './Public/Uploads/',
		'saveName'   =>    array('uniqid',''),
		'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
		'autoSub'    =>    true,
		'subName'    =>    array('date','Ymd'),

		);
		$info = $this->upload($config);
		if(!$info) 
		{// 上传错误提示错误信息

			$this->error($upload->getError());

		}
		else
		{// 上传成功
			$formname=trim($_POST['formname']);
			$editname=trim($_POST['editname']);
			$savepath = str_replace("./","/",$info['img']['savepath']);       
			dump($savepath); 
			$savepath =  "/".pathconvert($_SERVER['DOCUMENT_ROOT'],THINK_PATH).$savepath.$info['img']['savename'];
			//表单数据获取验证

			$savepath = str_replace("//","/",$savepath);
			dump($savepath);


			$filepath = $config['rootPath'].str_replace("./","/",$info['img']['savepath']);
			$filepath = $filepath.$info['img']['savename'];
			// $image = new \Think\Image();   
			// $image->open($filepath);

			$thumb_savepath = createthumb($filepath,$savepath,100,100);//str_replace(".jpg","_thumb.jpg",$filepath);
			//$image->thumb(150,150)->save($thumb_savepath);
			echo "<script>window.opener.document.".$formname.".".$editname.".value='".$savepath."'</script>";//这一句改变了它的值;
			echo "<script>window.opener.document.".$formname.".thumb_".$editname.".value='".$thumb_savepath."'</script>";//这一句改变了它的值;
			echo "<script>alert('success');window.close();</script>";
		}
	}
	/*
	* BindingTable:如果一个表中不仅关联了其他表的主键，而且还关联了
	* 另外一个值，则适用于本函数；
	* id:主键值，id_key为在关联表中的key名称；
	* name:一般为名称，name_key为关联表中的名称，也是实际需要更新的值
	* table:关联表明 
	*/
	public function updateBindingTable($id,$name,$id_key,$name_key,$table)
	{
		$db = M($this->_table);        
		$items = $db->table($table)->where("$id_key=$id")->select;
		foreach($items as $t)
		{
			$t[$name_key] = $name;
			$db->table($table)->save($t);
		}

	}
	public function insertFatherLayer(&$db)
	{
		$model = $this->_table;
		$rs = insertorselect($model,$db->father_id,I('post.new_father'));
		if(!$rs)
		{

			$this->error($model."数据插入出错");  
			die(); 
		}
		else
		{  

			$db->father_id = $rs['id'];
		}                  
	}
	public function editItem()
	{       
		$db = D($this->_table);       
		if(IS_POST)
		{
			$vo = $db->create();
			trace($vo,'create vo');
			$this->insertFatherLayer($db);      
			if(!$rs = $db->save())
			{
				trace($rs,'save rs');
				$this->error("操作失败");
			}
			else
			{ 
				$data['id'] = $db->father_id;
				$data['layer'] = $db->layer + 1;
				$db->save($data);
				$this->updateBindingTable($db->id,$db->name,
				"category_id","category","bc_best_for_baby"); 
				$this->success("修改成功"); 
			}
		}
		else
		{

			$id = I('get.id',0,'intval');

			if($rs = $db->where("id=%d",$id)->find())
			{                                                             
				if($rs['father_id'] > 0)
				{
					$father = $db->where("id=%d",$rs['father_id'])->find();
				}

				$father_layer = $rs['layer']+1;
				$where = "layer=$father_layer";                 
				$fathers = $db->where($where)->select();
				$this->assign("fathers",$fathers);
				$this->assign("layer",$layer);
				$this->assign("father_layer",$father_layer);
				$this->assign("item",$rs);
				$this->assign("father",$father);
				$this->display();  
			}
			else
			{
				$this->error($db->getError());
			}
		}
	}
	/***********************************
	* addInstruction
	* 增加说明项
	* @author: Wilson
	*/
	public function addInstruction()
	{
		if(!IS_POST)
		{  
			$id = I('get.id',0,'intval');
			if($id == 0)
			{
				$this->index();
				die();
			} 
			$db = D('instruction');
			$rs = $db->where('item_id=%d',$id)->select();
			$this->assign("id",$id);
			$this->assign("items",$rs);
			$this->display();
		}
		else
		{
			$db = D('instruction'); 
			if($db->create())
			{
				if($db->Add())
					$this->success("成功");
				else
				{
					$this->error($db->getError());
				}
			} 
			else
			{
				$this->error($db->getError());
			}
		}
	}
	/***********************************
	* addInstruction
	* 增加说明项
	* @author: Wilson
	*/
	public function editInstruction()
	{
		if(!IS_POST)
		{  
			$id = I('get.id',0,'intval');
			if($id == 0)
			{
				$this->index();
				die();
			} 
			$db = D('instruction');
			$rs = $db->where('id=%d',$id)->select();
			$this->assign("id",$id);
			$this->assign("item",$rs[0]);
			$this->display();
		}
		else
		{
			$db = D('instruction'); 
			if($data = $db->create())
			{
				if($db->Save())
				{
					$this->success("修改成功","/index.php/home/bestforbaby/viewitem/id/".$data[item_id]);
				}
				else
				{
					$this->error($db->getError());
				}
			} 
			else
			{
				$this->error($db->getError());
			}
		}
	}
	public function upload($config)
	{
		if(!$config)
			$config = array(
			'maxSize'    =>    3145728,
			'rootPath'   =>    './ThinkPHP/',
			'savePath'   =>    './Public/Uploads/',
			'saveName'   =>    array('uniqid',''),
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),
			'autoSub'    =>    true,
			'subName'    =>    array('date','Ymd'),
			);
		$upload = new \Think\Upload($config);// 实例化上传类
		// 上传文件

		$info = $upload->upload();

		return $info;

	}

}   
