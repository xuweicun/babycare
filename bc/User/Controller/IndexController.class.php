<?php
namespace User\Controller;
use Think\Controller;
use Think\Image; 
use Home\Model;
use Home\Controller\CategoryController;
use Home\Controller\InstructionController;
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class IndexController extends Controller {
	public $itemLayer = 0;
		private $_shownum = 10;
		public $_categoryLayer = 1;
		public $root_layer = 2;
		private $_model = "BestForBaby";
		public $brandModel = "Brand";
		public $corpModel = "Company";
		public $controller = "/index.php/user/index/";
    public function index(){
	  $db = M('Category');
	  $category = $db->where("layer=%d",$this->_categoryLayer)->select();
	  $this->assign("category",$category);
	  $db = M($this->_model);
	  //$items = $db->select();
	 
	  
								  
	 $map = "1=1";
	 $items;
	 $page;
	 $count = list_pages($db,$items,$page,$this->_shownum,$map);
	 $this->getCtgrs();
	 $this->assign("items",$items);  
	 $this->assign("page",$page); 
	 $this->display("wap-index");
	} 
	/*
	*查看所有 
	* 
	*/
	public function viewByCtgr($ctgr = 0)
	{
		$ctgr = $ctgr > 0 ? $ctgr : I("get.ctgr_id",0,intval);
		$ctgrDb = D('CategoryView');
		$db = M('Category');
		$category = $db->where("layer=%d",$this->categoryLayer)->select();
		$this->assign("category",$category);
		$items = $ctgrDb->where("father_id=$ctgr")->select();
		$this->assign("items",$items);
		//$map = "father_id=$ctgr";
		$map = "id=$ctgr";
		$items;
		$page;
		$count = list_pages($ctgrDb,$items,$page,$this->_shownum,$map);
		$this->getCtgrs();
		$this->assign("items",$items);  
		$this->assign("page",$page); 		
		$this->display("wap-index");
		
	}
	public function viewitems($map=null)
	{
		$this->index();
		die();
		$db = D('BestForBaby');
		$ctgr = I('get.ctgr_id',0,'intval');
		$company = I('get.company_id',0,'intval');
		$brand = I('get.brand_id',0,'intval');
		
		if($ctgr>0)
		{
			$this->viewByCtgr($ctgr);die();
		}
		$id = I('get.id',0,'intval'); 
		$key = I('get.key');    
		if($id > 0)
		{
		   $map[$key] = array('eq',$id); 
		}
		
		
		//$this->viewitems($map);
		 
		$count=$db->where($map)->count();       
		$page=new \Think\Page($count,5); 
		
		$items = $db->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		var_dump($page);
		$show = $page->show();
		$this->assign("page",$show);
		$this->assign("items",$items);
		$this->display();
	}
  
	public function getCtgrs()
	{
		 $categoryDB = M("Category");
		 $category = $categoryDB->where("layer=%d",$this->_categoryLayer)->select();
		 $this->assign("category",$category);
	}
	/*
	*查看某个
	* 
	*/
	public function viewItem()
	{
		 $db = D('BestForBaby');
		 $id = I('get.id',0,'intval');
		 if($id==0)
		 {
			$this->error('商品不存在','/index.php/index',2);   
			die();
		 }
		 else
		 {
		   $item = $db->relation(true)->find($id);
		   $categoryDB = M("Category");
		   $category = $categoryDB->where("layer=%d",$this->_categoryLayer)->select();
		   //get brand, corp and category
		   $brandDb = D("BrandView");
		   $brand = $brandDb->find($item['brand_id']);
		   //var_dump($brand);
		   $instruction = M('Instruction');
		   $instructions = $instruction->where("item_id=%d",$id)->select();      
		   $item['content'] = 
		   htmlspecialchars_decode($item['content'],ENT_QUOTES);   
		   $items = htmldecode($instructions);    
		   //get versions
		   $version = $item['brand_id'] ? $db->where("brand_id=%d",$item['brand_id'])->select():null;
		   //get the image set under each view&size option
		   $options;
		   //if view is not empty
		   if(!is_null($item['view']))
		   {
				//not null, to obtain the images of each view
				foreach($item['view'] as $t)
				{
					$view_id = $t['id'];
					$imgDB = D('ItemImgView');
					$img = $imgDB->where("item_id = $id and view_id = $view_id")->select();
					if($img)
					{
						$this->assign("itemViewImg",$img);
						$this->assign("selectedView",$view_id);
						break;
					}  
				}
		   }
		   
		   $Ins = new InstructionController();
		   $title = $Ins->listTitle($id);
		   //template assignments 
		   
		   $this->assign("title",$title); 
		   $this->assign("version",$version);          
		   $this->assign("item",$item);
		   $this->assign("brand",$brand);
		   $this->assign("imgs",$options);
		   $this->assign("itemView",$item['view']);
		   $this->assign("itemSize",$item['size']);
		   $this->assign("instructions",$items);		   
		   $this->initTpl(__FUNCTION__);
		   $this->assign("category",$category); 
		   $this->display();  
		 }
	}
	
	
	public function searchitem()
	{
		//根据内容识别搜索类型
		//判断是否数字
		//如果是数字，搜索barcode
		//如果是字符串，搜索名称、品牌和功效
		$db = D('BestForBaby');
		$key = I('post.key',0,'intval');
		$items = array(); 
		$items;
		$page;
		if($key != 0)
		{
			  $items=$db->where("barcode = %d",$key)->select();   
			   $this->assign("items",$items);   
		}
		else
		{
			   
			 $key = '%'.I('post.key','','strip_tags').'%';              
							
			 $map['name|barcode'] = array('like',$key);
			 
			 $count = list_pages($db,$items,$page,
			 $this->_shownum,$map);
			 // =$db->where($map)->select();   
					 $this->assign("items",$items);
		
			
		}    
		
		$this->assign("page",$page);  
		$this->display("search-result");           
			  
	}
  /********
  * put your comment there...
  * 
  * @param mixed $db
  */
  public function insertcategory(&$db)
  {
	 $model = "Category";
	 $rs = insertorselect($model,$db->category_id ,I('post.new_ctgr'));
	 if(!$rs)
	 {
		$this->error($model."数据插入出错");  
	   // die(); 
	 }
	 else
	 {
		$db->category = $rs['value'];
		$db->category_id = $rs['id'];
	 }                  
  }
  public function moreInfo()
  {
	  $this->display();
  }
  /*********
  * insert color options
  * 
  */


 
  public function  checkUnique($db)
  {
	  $map['brand_id'] = array("eq",I("post.brand_id",0,"intval"));
	  $map['version']  = array("eq",I("post.version",null));
	  $rs = $db->where($map)->select();
	  return !$rs;
  }
  public function checkItemName()
  {
	 $db = M($this->_model);
	 $key = I("post.fieldId");  
	 $map[$key] = I("post.fieldValue");     
	 $rs = $db->where($map)->find();
	 $data = array($key,$rs?false:true,$rs?"该名称已经存在":"验证通过");
	 $this->ajaxReturn($data);
	 
  }
 
  public function initTpl($action)
  {
	  $db = D('BestForBaby'); 
	  $categoryDb = M("Category");
	  $brandCtgrDb = D("BrandCategoryView");
	  $brand_db = D("Brand");
	  $item = array();
	  $actions = array("editItem","viewItem");
	  $brandID = I("post.brand_id",0,'intval');
	  if(in_array($action,$actions))
	  {
		  $id = I("get.id",0,"intval");		
		  
		  $item =  $db->relation(true)->find($id);
		  $brandID = $item['brand_id'] ? $item['brand_id'] : 0;
		  $itemName = $categoryDb->find($item['category_id']);
		  $this->assign("item",$item); 
		  $this->assign("itemName",$itemName['name']);              
	  }
	  //brand
	  
	  $brand = $brand_db->Relation(true)->find($brandID);
	  $this->assign("brand",$brand);
	  //get existing version
	  $existingVersion = $db->where("brand_id=%d",$brandID)->group("version")->select();
	  //category
	  $category = $brandCtgrDb->where("brand_id = %d",$brandID)->select();
	  if(!$category) 
	  {
		$category = $categoryDb->where("layer = %d",$this->_categoryLayer)->select();
	  }
	  $this->assign("category",$category);
	  $this->assign("existingVersion",$existingVersion);
	  $this->assign("ctgrURL","/index.php/home/category/listchildren/id/");
		
	  $this->assign("action",$action);
	  
	  
		//If no category for brand, select all
  }
  public function checkViewName()
  {
	  $db = M($this->_table);  
	 $key = I("post.fieldId");  
	 $map[$key] = I("post.fieldValue");     
	 $rs = $db->where($map)->find();
	 $data = array($key,$rs?false:true,$rs?"该名称已经存在":"验证通过");
	 $this->ajaxReturn($data);
  }
  /****************
  * function:listBrands
  * Todo: 显示可选品牌
  * author: Weicun
  */
  public function listBrands()
  {
	
		$db = M("Brand");
		
		$corp_id = I("get.corp_id",0,"intval");
		$map["corp_id"] = array("eq",$corp_id);
		$count = $db->where($map)->count();   
		$page  = new \Think\Page($count,$this->_shownum); 
		$items = $db->where($map)->limit($page->firstRow.','.$page->listRows)->select();
		//var_dump($page);
		$show = $page->show();
		$this->assign("items",$items);
		$this->display();
	
  }
  
  /*******************
   * getImgs
   * @function: get images
   * @parameter: the key of item,size and view; 
   */
  public function getImg($item_id = 0,$view_id = 0,$isJsonReturn = false) 
  {
	  
	  if(IS_AJAX)
	  {
		  
		  //ajax处理
		  $item_id = I("post.item_id",0,"intval");
		  $view_id = I("post.view_id",0,"intval");
	  }
	  $itemImg = D("ItemImgView"); 
	  if(!$map)
	  {
		//  $map['size_id'] = $size_id;
		  $map['view_id'] = array('eq',$view_id);//$view_id;
		  $map['item_id'] = array('eq',$item_id);//$item_id; 
	  }
	 
	  
	  if(IS_AJAX)
	  {
		  //ajax处理   
		  $imgs = $itemImg->where($map)->select();// $itemImg->join("LEFT JOIN bc_img on bc_item_img.img_id = bc_img.id")->where($map)->select();
		  if($isJsonReturn)
		  {
			 $this->ajaxReturn($imgs); 
		  }
		  $this->assign("imgs",$imgs);
		  $data['view'] = $this->fetch("imgBlock");
		  
		  $this->ajaxReturn($data);
	  }
	  else
	  {
		  
		 $imgs = $itemImg->where($map)->select();// $itemImg->join("LEFT JOIN bc_img on bc_item_img.img_id = bc_img.id")->where($map)->select();
		  return $imgs;
	  }
	  
  }
 
 
   PUBLIC function myDisplay($action,$tpl=null)
   {
	   $this->assign("action",$action); 
	   $tpl ? $this->display($tpl):$this->display();
   }
  
  public function innerupload()
  {
	  $this->display();
  }
 
 
 
}