<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 

include_once(COMMON_PATH."Common/bc.common.php");
class InstructionController extends Controller {
	protected $_table = "instruction"; 
	protected $_fathertable = "InstructionTitle";
	protected $_shownum = 10;
	protected $_sucurl = "/index.php/home/brand/viewitems";
	protected $_failurl = "/index.php/home/brand/index";       
	protected $_thumbwidth = 100;
	protected $_thumbheight = 100; 
	public function index(){
	   
		die();
	   
	   
	}
	public function viewTitles()
	{
		$db = M($this->_fathertable);
		$items = $db->select();
		$this->assign("items",$items);
		$this->display();
	}
/****************
* @获取说明标题
* @param item_id 物体id,如果不为0，则仅显示该物体未定义的说明；
*/
  public function listTitle($item_id = 0)
  {
	 
		$db = M($this->_fathertable);
		
		//$map['id'] = array("eq",$id);
		$rs = $db->select();
		$filtered = array();
		if($item_id > 0)
		{
			$db2 = M($this->_table);
			foreach($rs as $r)
			{
				$map['item_id'] = array('eq',$item_id);
				$map['title_id'] = array('eq',$r['id']);
				if(!$db2->where($map)->find())
				{
					$filtered[] = $r;
				}
			}
		}
		if(!IS_AJAX)
		{
			return $item_id > 0 ? $filtered:$rs;
		}

		$idName = "title_id";
		$this->assign("items",$item_id > 0 ? $filtered:$rs);     
		$this->assign("name",$idName);     
		$this->assign("text","选择标题");               
		$data['view'] = $this->fetch();                      
		$this->ajaxReturn($data);      
  }

	public function insertTitle()
	{
		$db = D($this->_fathertable);
		if(IS_POST || IS_AJAX)
		{
			
			if($data = $db->create())
			{
				var_dump($db->title);
			
				 if(@$id = $db->add($data))
				 {
					 //插入成功
					 $this->success("插入数据成功");
					
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
			$items = $db->select();
			$action = "insertTitle";
			$this->assign("items",$items);
			$this->assign("action","insertTitle");
			$this->display();
		}
	}
	public function deleteTitle()
	{
		$id = I('get.id',0,'intval'); 
		if($id == 0)
		{
		   $this->error('参数错误');   
			
		}
		else
		{
			$db = D('InstructionTitle'); 
			if(!$db->relation(true)->delete($id))
			{
				$this->error('操作失败');
			}
			else
			{
				$this->success("操作成功");
			}
		
		} 
	}
	public function editTitle()
	{
		$db = D($this->_fathertable);
		if(IS_POST || IS_AJAX)
		{
		 
			if($data = $db->create())
			{
				 if(@$db->save($data))
				 {
					 //插入成功
					 $this->success("操作成功");
					
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
			$items = $db->select();
			$id = I("get.id",0,"intval");
			
			$map['id'] = array('eq',$id); 
			$item = $db->where($map)->find(); 
			if($id == 0 || !$item)
			{
				$this->error("参数有误");
				die();
			}
			$action = "editTitle";            
			$this->assign("item",$item);
			$this->assign("items",$items);
			$this->assign("action","editTitle");                 
			$this->display();
		} 
	}
  /***********************************
  * editInstruction
  * 编辑说明项
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
		   $db = D($this->_table);
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
    /*
	*查看Bestforbaby的说明
    */
	public function viewBfbItems()
	{
		$item_id = I('get.item_id',0,'intval');
		if($item_id == 0)
		{
			$this->error('参数有误');
			die();
		}
		$db = M($this->_table);
		$items = $db->where("item_id=%d",$item_id)->select();
		$i = 0;
		foreach ($items as $key => $value) {
			$items[$key]['index'] = ++$i;
		}
		$this->assign("items",$items);
		$this->assign("total_num",count($items));
		$this->display("viewitems");

	}
	/*
	*查看项目
	* 
	*/
	public function viewitem()
	{
		 $db = D($this->_table);
		 $id = I('get.id',0,'intval');

		 if($id==0)
		 {
			$this->error('参数有误');               
		 }
		 else
		 {
		   $item = $db->where("id = %d",$id)->find();
		   $instruction = M('Instruction');
		   $instructions = $instruction->where("item_id=%d",$id)->select();      
		   $item['content'] = 
		   htmlspecialchars_decode($item['content'],ENT_QUOTES);   
		   $items = htmldecode($instructions);           
		   $this->assign("item",$item);
		   $this->assign("instructions",$items);
		   $this->display();  
		 }
	}
	public function deleteitem()
	{
		$id = I('get.id',0,'intval'); 
		if($id == 0)
		{
		   $this->error('参数有误');   
			die(); 
		}
		else
		{
			$db = D('Instruction'); 
			if(!$db->where('id=%d',$id)->delete())
			{
				$this->error('操作失败');
			}
			else
			{
				$this->success("操作成功");
			}
		}
	}
	
  
  public function insertitem()
  {
	
	if(IS_POST || IS_AJAX)
	{
		$db = D('Instruction');
		if($data = $db->create())
		{
			
			 $map['item_id'] = array('eq',$db->item_id);
			 $map['title_id'] = array('eq',$db->title_id);
			 $rs;
			 $item = $db->where($map)->find();   
			 
			 $title_db = M($this->_fathertable);
			 $map['id'] = array('eq',$db->title_id); 
			 if($title = $title_db->where($map)->find())
			 {
				 $data['title'] = $title['title'];
			 }
			 if(!$item)
			 {
				 $rs = $db->add($data);
			 }
			 else
			 {
				 $data['id'] = $item['id'];                                  
				 
				 $rs = $db->save($data);
				
			 }              
			 if($rs)
			 {
				$itemID = I("post.item_id",0,'intval');
				$this->success("操作成功",U("/home/bestforbaby/viewitem/id/$itemID"));
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
		
		$item_id = I('get.item_id',0,'intval');       
		$title = $this->listTitle($item_id);
		$db = D('instruction');
		$rs = $db->where('item_id=%d',$item_id)->select();
		$this->assign("item_id",$item_id);
		$this->assign("items",$rs);
		$this->assign("action","insertitem");
		$this->assign("title",$title);
		$this->display();
	}
  }

  public function editItem()
  {       
   $db = D('Instruction');       
	if(IS_POST)
	{
	      $data = $db->create();
           $title_db = M($this->_fathertable);
           $map['id'] = array('eq',$db->title_id); 
           
           if($title = $title_db->where($map)->find())
             {   
                 var_dump($title);
                 $data['title'] = $title['title'];
             }
		  if(!$db->save($data))
		  {
			  
			  $this->error("操作失败");
		  }
		  else
		  {
			  $itemID = I("post.item_id",0,'intval');
			  $this->success("修改成功",U("/home/bestforbaby/viewitem/id/$itemID"));
		  }
	 }
	 else
	 {
			   
	   $id = I('get.id',0,'intval');
	  
	   if($rs = $db->where("id=%d",$id)->select())
	   {
		var_dump($rs);   
	   $title = $this->listTitle($id);
	   $this->assign("title",$title);
	   $this->assign("item",$rs[0]);
	   $this->assign("action",__FUNCTION__);
	   $this->display("insertitem");  
	   }
	   else
	   {
		   $this->error($db->getError());
	   }
	 }
  }
  public function getByTitle()
  {    
	   $title_id = I('get.title_id',0,'intval');      
	   $item_id = I('get.item_id',0,'intval');      
	   $map['title_id'] = array('eq',$title_id);
	   $map['item_id'] = array('eq',$item_id);
	   $db = M($this->_table);
	   if($rs = $db->where($map)->find())
	   {                                                                   
		   $this->assign("item",$rs);
		   if(IS_AJAX)
		   {
			   $data['view'] = $rs['content'];
			   $this->ajaxReturn($data);
		   }
		   else
		   {
			   return $rs;
		   } 
	   }
	   else
	   {
		   if(IS_AJAX)
		   {
			   $data['error'] = 1;
			   $this->ajaxReturn($data);
		   }
		   else
		   {
			   return $rs;
		   } 
	   }
  }
  /***********************************
  * addInstruction
  * 增加说明项
  * @author: Wilson
  */
   public function addItem()
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
  
 
}   
