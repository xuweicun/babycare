<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
use Home\Controller\CategoryController;
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class BrandController extends Controller {
	
	protected $_table = "brand"; 
	protected $_fathertable = "company";
	protected $_ctgrTable = "BrandCategory";
	protected $_shownum = 10;
	protected $_sucurl = "/index.php/home/brand/viewitems";
	protected $_insertSucUrl = "/index.php/home/brand/viewitem/id/";         
	protected $_failurl = "/index.php/home/brand/index";       
	protected $_thumbwidth = 100;
	protected $_thumbheight = 100; 
	public    $categoryLayer = 1;
	public    $itemLayer = 0;
	public    $layer = array("item"=>0,"category"=>1);
	public function index(){  
	  $this->display();          
	} 
	/*
	*查看所有 
	* 
	*/
   
	public function viewitems()
	{
		$db = D($this->_table);
		$count=$db->count();       
		$page=new \Think\Page($count,$_shownum); 
		$items=$db->limit($page->firstRow.','.$page->listRows)->select();
		//var_dump($page);
		$show = $page->show();
		$count = list_pages($db,$items,$page,
		 $this->_shownum,$map);
		 // =$db->where($map)->select();   
		 $this->assign("items",$items);
		$this->assign("page",$page);  
		$this->assign("items",$items);
		$this->display();
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
			$this->error('商品不存在','/index.php/home/brand',2);   
			die();
		 }
		 else
		 {
		   $item = $db->where("id = %d",$id)->find();
		   
		   $item['content'] = 
		   htmlspecialchars_decode($item['content'],ENT_QUOTES);   
		   //$items = htmldecode($instructions);           
		   $this->assign("item",$item);
		   //$this->assign("instructions",$items);
		   $this->display();  
		 }
	}
	public function deleteitem()
	{
		$id = I('get.id',0,'intval'); 
		if($id == 0)
		{
		   $this->error('ID不存在');   
			die(); 
		}
		else
		{
			$db = D($this->_table); 
			if(!$db->relation(true)->delete($id))
			{
				$this->error('操作失败');
			}
		}
	}
	
	public function oldsearchitem()
	{
		//根据内容识别搜索类型
		//判断是否数字
		//如果是数字，搜索barcode
		//如果是字符串，搜索名称、品牌和功效
		$db = D($this->_table);
		$key = I('post.key',0,'intval');
		$items = array();
		if($key != 0)
		{
			  $items=$db->where("barcode = %d",$key)->select();      
		}
		else
		{       
			 $key = I('post.key','','strip_tags');              
			 $key = '%'.stringCheck($key).'%';               
			 $map['name|alias'] = array('like','%'.$key.'%');
			 if($key != '')
			 {
			   $items =$db->where($map)->select();   
			 }   
			  
		}    
	   $this->assign("items",$items);
	 
	   $this->display();  
	}
/********************
* insert a new brand
* @author: Wilson Xu 
*/
  public function insertitem()
  {
   
	if(IS_POST || IS_AJAX)
	{
	//     $data=array(true);
	//$this->ajaxReturn($data);
		$db = D($this->_table);
		
		if($data = $db->create())
		{			
			 if(@$id = $db->add())
			 {
				 //插入成功
				 $this->success("插入数据成功",$this->_sucurl);
				 $this->updateCategory($id);
				 
			 }
			 else
			 {
				 $this->error($db->getError(),$this->_failurl);
			 }              
		}
		else
		{
		   $this->error($db->getError(),$this->_failurl);     
		}
	}
	else
	{
		//before post
		//$ctgr = new CategoryController();  
		//$items = $ctgr->getItems($this->itemLayer); 
		//$categories = $ctgr->getItems($this->categoryLayer); 
		//get selected ctgrs;
		$corp = D($this->_fathertable);
		$companies = $corp->select();
		$unselected = $selected = array();
		$this->getSelectedCtgrs($id,$selected,$unselected);
		$this->assign("selected",$selected);
		$this->assign("unselected",$unselected);
		
		$this->assign("category",$categories);//物品名称
		$this->assign("items",$items);//物品名称
		$this->assign("companies",$companies);
		$this->assign("action","insertitem");
		$this->display();
	}
  }
  public function updateCategory($id)
  {
	  //delete old ones;
	  $category = I("post.category");
	  $db = M($this->_ctgrTable);
	  $db->where("brand_id=$id")->delete();
	  if(is_array($category))
	  {
		  $data['brand_id'] = $id;
		  foreach($category as $t)
		  {
			  $data['category_id'] = $t;
			  $db->add($data);
		  }
	  }
	  else
	  {
		  $data['brand_id'] = $id;
		  $data['category_id'] = $category;
		  $db->add($data);
	  }	
	  
	  //add new ones;
  }
  public function getSelectedCtgrs($id,&$selected,&$unselected)
  {
		$ctgr = new CategoryController();  
		$items = $ctgr->getItems($this->itemLayer); 
		$categories = $ctgr->getItems($this->categoryLayer);
		//read the selected;
		$db = D($this->_table);
		$rs = $db->Relation(true)->find($id);
		
		$selectedCtgr = $rs['selectedCategory'];
		//find out which ones are selected
		if(!id or !$selectedCtgr)
		{
			//no category selected
			$unselected = $categories;
			return false;
		}
		foreach($categories as $t)
		{
			$flag = false;
			foreach($selectedCtgr as $s)
			{
				if($t['id'] === $s['category_id'])
				{
					//add this one to selected
					$selected[] = $t;
					$flag = true; 
					break;         
				}
			}
			if(!$flag)
			{
				//add this one to unselected
				$unselected[] = $t;
			}
			
		}
		/*var_dump($selected);
		var_dump($unselected);
		die();*/
		return true;
  }
  
  public function editItem()
  {
   
	if(IS_POST || IS_AJAX)
	{
	//     $data=array(true);
	//$this->ajaxReturn($data);
		$db = D($this->_table);
		
		if($data = $db->create())
		{
			 
			 $this->updateCategory(I('post.id'));
			 if(@$id = $db->save())
			 {
				 //插入成功
				 $this->success("插入数据成功",$this->_insertSucUrl+"$id");		 
				 
			 }
			 else
			 {
				 $this->error($db->getError());
			 }              
		}
		else
		{
		   $this->error($db->getError(),$this->_failurl);     
		}
	}
	else
	{

		//获取原始数据
		$id = I('get.id',0,'intval');
		$action = __FUNCTION__;
		$this->_initInsertTpl($id,$action);
		
		$this->display("insertitem");
	}
  }
  protected function _initInsertTpl($id = null,$action = null)
  {
		$corp = D($this->_fathertable);
		$db = D("BrandView");		
		$item = $db->find($id);
		//分配数据
		$this->assign("item",$item);		
		$companies = $corp->select();
		$unselected = $selected = array();
		$this->getSelectedCtgrs($id,$selected,$unselected);
		$this->assign("selected",$selected);
		$this->assign("unselected",$unselected);
		
		//$this->assign("category",$categories);//物品名称
		//$this->assign("items",$items);//物品名称
		$this->assign("companies",$companies);
		$this->assign("action",$action);
  }
  /**************
  * This is a test function
  */
  public function checkName()
  {
	 $db = M($this->_table);  
	 $key = I("post.fieldId");  
	 $map[$key] = I("post.fieldValue");     
	 $rs = $db->where($map)->find();
	 $data = array($key,$rs?false:true,$rs?"该名称已经存在":"验证通过");
	 $this->ajaxReturn($data);
  }
  public function searchitem()
  {
		 $db = D($this->_table);
		
		 $items;$page;  
		 $key = '%'.I('post.key','','strip_tags').'%';              
						
		 $map['name|cn_name'] = array('like',$key);
		 
		 $count = list_pages($db,$items,$page,
		 $this->_shownum,$map);
		 // =$db->where($map)->select();   
		 $this->assign("items",$items);
		$this->assign("page",$page);  
		$this->display("viewitems");           
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
			   
			   $thumb_savepath = createthumb($filepath,$savepath,
			   $this->_thumbwidth,$this->_thumbheight);//str_replace(".jpg","_thumb.jpg",$filepath);
			   //$image->thumb(150,150)->save($thumb_savepath);
			   echo "<script>window.opener.document.".$formname.".".$editname.".value='".$savepath."'</script>";//这一句改变了它的值;
			   echo "<script>window.opener.document.".$formname.".thumb_".$editname.".value='".$thumb_savepath."'</script>";//这一句改变了它的值;
			   echo "<script>alert('success');window.close();</script>";
			 }
  }

  public function oldeditItem()
  {       
   $db = D($this->_table);       
	if(IS_POST)
	{
		  $vo = $db->create();
		  trace($vo,'create vo');
		  if(!$rs = $db->save())
		  {
			  trace($rs,'save rs');
			  $this->error("操作失败",$this->_sucurl);
		  }
		  else
		  {
			  $this->success("修改成功","/index.php/home/brand/viewitem/id/".I('post.id',0,'intval'));
		  }
	 }
	 else
	 {
			   
	   $id = I('get.id',0,'intval');
	  
	   if($rs = $db->where("id=%d",$id)->find())
	   {         
	   $this->assign("item",$rs);
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
