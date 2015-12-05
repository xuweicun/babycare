<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
use Home\Controller\CategoryController;
use Home\Controller\InstructionController;
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class BestForBabyController extends Controller {
	public $itemLayer = 0;
	private $_shownum = 10;
	public $_categoryLayer = 1;
	public $root_layer = 2;
	private $_model = "BestForBaby";
	public $brandModel = "Brand";
	public $corpModel = "Company";
	public $controller = "/index.php/home/bestforbaby/";
	
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
			$this->error('商品不存在','/index.php/home/bestforbaby',2);   
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
	public function deleteitem()
	{
		$id = I('get.id',0,'intval'); 
		if($id == 0)
		{
		   $this->error('商品不存在');   
			die(); 
		}
		else
		{
			$db = D('BestForBaby'); 
			if(!$db->relation(true)->delete($id))
			{
				$this->error('操作失败');
			}
			else
			{
				$this->redirect("/home/bestforbaby/viewitems");
			}
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


  /*********
  * put your comment there...
  * 
  * @param mixed $db
  */
  public function insertcompany(&$db)
  {
	 $model = "Company";
	 //dump(I('post.new_corp'));
	 //dump(string_check(I('post.new_corp')));
	 $rs = insertorselect($model,$db->company_id,I('post.new_corp'));
	 if(!$rs)
	 {
		$this->error($model."数据插入出错");  
		die(); 
	 }
	 else
	 {
		$db->corp = $rs['value'];
		$db->company_id = $rs['id'];
	 }                  
  }
  
  public function editcompany()
  {}
  public function editcategory()
  {}
  /*********
  * 插入品牌
  */
  public function  insertBrand(&$db)
  {

	$model = "Brand";
	 //dump(I('post.new_corp'));
	 //dump(string_check(I('post.new_corp')));
	 $rs = insertorselect($model,$db->brand_id,I('post.new_brand'));
	 if(!$rs)
	 {
		$this->error($model."数据插入出错");  
		die(); 
	 }
	 else
	 {
		$db->brand = $rs['value'];
		$db->brand_id = $rs['id'];
	 }                  
  }
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
  public function insertitem()
  {
	
	if(IS_POST && is_null(I("get.action",null)))
	{
		$db = D('BestForBaby');
			if($data = $db->create())
			{
				 //category
				// $this->insertcategory($db);
				// $this->insertcompany($db);
				// $this->insertBrand($db);
			  //  $db->buyLink=I("post.buyLink",null,"htmlspecialchars");
				$db->video  =I("post.video",null,"htmlspecialchars");
				 if(@$id = $db->add())
				 {
					 //插入成功
					// $this->success("插入数据成功");
					$this->success("成功","/index.php/home/bestforbaby/viewitem/id/$id");
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
		//判断是否已经选择品牌
	   
		$action = __FUNCTION__;
	   // $ctgr = new CategoryController();
		$db = M('Category');
		$corp_db = M('Company');
		$items = M('BestForBaby');

		$companies   = $corp_db->select();         
		$brand_id = I("post.brand_id",0,'intval');
		if($brand_id == 0)
		{
			$brandDB = M("Brand");
			$brands = $brandDB->select();
			$this->assign("brands",$brands);
			$this->assign("companies",$companies);  
			$this->assign("action",$action);  
			$this->display("selectBrand");
			die();
		}
		
		//查询品牌名称、厂商名称
		$brand_db = D("Brand");
		
		$categoryDb = M("Category");
		$brand = $brand_db->Relation(true)->find($brand_id);
		$db = M("BrandCategory");
		$brandCtgrDb = D("BrandCategoryView");
		//If no category for brand, select all
				   

		$this->assign("ctgrURL","/index.php/home/category/listchildren/id/");
		
	
		$this->initTpl($action);
		$this->display();   
	}
  }
  public function initTpl($action)
  {
	  $db = D($this->_model); 
	  $categoryDb = M("Category");
	  $brandCtgrDb = D("BrandCategoryView");
	  $brand_db = D("Brand");
	  $item = array();
	  $actions = array("editItem","viewItem");
	  $brandID = I("post.brand_id",0,'intval');
	  if(in_array($action,$actions))
	  {
		  $id = I("get.id",0,"intval");		
		  
		  $item =  $db->Relation(true)->find($id);
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
 
 /*******************
   * insertImage
   * @function: 增加图像
   * @parameter: ID;
   */
   public function insertImg()
   {
	   $this->assign("action",__FUNCTION__);
		if(IS_POST || IS_AJAX)
	   {
		   //上传图片到图片库
	   	  
		   $db = M("Img");
		   $db->create();
		   $w  = I('post.w',0,'intval');
		   $h  = I('post.h',0,'intval');
		   if($w > 0 && $h > 0)
		   {
		   	  $savepath = I('post.img');
		   	  $filepath =  legalize_path($_SERVER['DOCUMENT_ROOT'].$savepath);
		   	  $savepath = cropImg($filepath,$savepath);
		   	  $thumb_savepath = createthumb($filepath,$savepath);
		   	  $db->img = $savepath;
		   	  $db->thumb_img = $thumb_savepath;

		   }	   
		 
		   $id = $db->add();
		   $itemImg = M("ItemImg");
		   $item_id = I('post.item_id',0,'intval');           
//		   $size_id = I('post.size_id',0,'intval');
		   $view_id = I('post.view_id',0,'intval');
		   if($id)
		   {    
			   //插入图片到物品图片关联库   
			   
			   $data = array(
			   "item_id" => $item_id,
			   "img_id"  => $id,
			   "size_id" => I('post.size_id',0,'intval'),
			   "view_id" => I('post.view_id',0,'intval')
			   );
			   $itemImg->add($data);
			   
		   }
				
		   //获取图片
//		   $map['size_id'] = $size_id;
		   $map['view_id'] = $view_id;
		   $map['item_id'] = $item_id;
		   $db = D($this->_model);
		   $item = $db->find($item_id);
		   $size = $db->table("bc_item_size")->find($size_id);
		   $view = $db->table("bc_item_view")->find($view_id);           
					 
		   $imgs = $this->getImg($item_id,$size_id,$view_id);
		   //模版操作
		   $this->assign("item",$item);
		   $this->assign("size",$size);
		   $this->assign("view",$view);
		   
		   $this->assign("imgs",$imgs);
		   $this->redirect("insertImg",array("item_id"=>$item_id),1,"插入成功，正在跳转..");
		   $this->display("viewImg");
		   //显示图片
			 
	   }
	   else
	   {
			 $db = D('BestForBaby');
			 $item_id = I('get.item_id',0,'intval');
			 if($item_id==0)
			 {
				$this->error('商品不存在','/index.php/home/bestforbaby',2);   
				die();
			 }
			 else
			 {
			   $item = $db->relation(true)->find($item_id); 
			   $viewImgs = $this->getImg($item_id,$item['view'][0]['id']);
			   $this->assign("item",$item);                            
			   $this->assign("viewImgs",$viewImgs);
			   $this->assign("itemView",$item['view']);
			   $this->assign("itemSize",$item['size']);         
			   $this->display();                      
			 }

					   
		  
	   }  
   }
   public function deleteImg()
   {
	   //Delete the img
	   $imgDB = D("Img");//Use the relation model, to delete the relationship meanwhile;
	   $id = I("get.id",0,'intval');
	   $rs = $imgDB->find($id);
	   if($rs)
	   {
	   		if(file_exists($rs['img']))
	   		{
	   			unlink($rs['img']);
	   		}
	   		if(file_exists($rs['thumb_img']))
	   		{
	   			unlink($rs['thumb_img']);
	   		}
	   		$imgDB->delete($id);

	   }
	   if(1)
	   {
	   		$imgDB = M("ItemImg");
	   		$rs = $imgDB->where("img_id = %d",$id)->delete();
	   }

	   if($rs)
	   {
			self::success("操作成功");
	   }
	   else
	   		self::error("操作失败");
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
			   $prevname = trim(I('post.prevname',''));
			   $savepath = str_replace("./","/",$info['img']['savepath']);       
			   $savepath =  "/".pathconvert($_SERVER['DOCUMENT_ROOT'],THINK_PATH).$savepath.$info['img']['savename'];
			   //表单数据获取验证
			   $savepath = str_replace("//","/",$savepath); 			  
			   $filepath = $config['rootPath'].str_replace("./","/",$info['img']['savepath']);
			   $filepath = $filepath.$info['img']['savename'];
			   // $image = new \Think\Image();   
			   // $image->open($filepath);
			   
			   $thumb_savepath = createthumb($filepath,$savepath,300,300);//str_replace(".jpg","_thumb.jpg",$filepath);
			   //$image->thumb(150,150)->save($thumb_savepath);
			   echo "<script>window.opener.document.".$formname.".".$editname.".value='".$savepath."'</script>";//这一句改变了它的值;
			   echo "<script>window.opener.document.".$formname.".thumb_".$editname.".value='".$thumb_savepath."'</script>";//这一句改变了它的值;
				echo "<script>window.opener.document.".$formname.".".$prevname.".src='".$savepath."'</script>";//这一句改变了它的值;
			   echo "<script>window.close();</script>";
			 }
  }
  public function editBrand()
  {
	  $db = M($this->_model);
	  if(IS_POST)
	  {
		  //修改          
		  $db->create();
		 
		  $db->save();
		  $id = I("post.id",0,"intval");
		  
		  $this->success('操作完成',U("/Home/Bestforbaby/edititem/id/$id"),1);
		//  $item = $db->find($id);
		//  $this->assign("item",$item);
		//  $this->display("viewItem");
	  }
	  else
	  {
		  $id = I("get.id",0,"intval");
		  $item = $db->find($id);
		  $brandDb = D("BrandView");         
		  
		  //get companies
		  $corp_db = M('Company');       
		  $companies   = $corp_db->select();         
		  $this->assign("companies",$companies);
		
		  $brand = $brandDb->find($item->brand_id);
		  $this->assign("brand",$brand);
		  $this->assign("item",$item);
		  $this->assign("action",__FUNCTION__);
		  $brandDb = M("Brand");
		  $brands = $brandDb->select();
		  $this->assign("brands",$brands);
		  $this->display("selectBrand");
	  }
  }
  public function editItem()
  {       
   $db = M('BestForBaby');       
	if(IS_POST)
	{
		  if($db->create())
		 { 
			  $this->insertcategory($db);
			  $this->insertcompany($db);
			  $this->insertBrand($db);
			  var_dump($db->id);
			  $db->video  =I("post.video",null,"htmlspecialchars");
			  if(!$db->save())
			  {      
						 
				  $this->error($db->getError());
			  }
			  else
			  {
				  $this->success("修改成功","/index.php/home/bestforbaby/viewitem/id/".I('post.id',0,'intval'));
			  }
		  }
	 }
	 else
	 {
			   
	   $id = I('get.id',0,'intval');
	  
	   if($item = $db->find($id))
	   {
		$db = M('Category');
		$corp_db = M('Company');
		$items = D('BestForBaby');
		$brandDb = D("BrandView");
		$brand = $brandDb->find($item['brand_id']);  
		
		//$categories  = $db->where("layer=%d",$this->product_layer)->select();
		//$companies   = $corp_db->select();
		
		//var_dump($brand);
	   $instruction = M('Instruction');
	   $instructions = $instruction->where("item_id=%d",$id)->select();      
	   //$this->assign("item",$item);
	   //$this->assign("instructions",$instructions);
	  // $this->assign("item",$rs[0]);
	  // $this->assign("action",__FUNCTION__);
	   //$this->assign("brand",$brand);
	   $this->initTpl(__FUNCTION__);
	   $this->display();  
	   }
	   else
	   {
		   $this->error($db->getError());
	   }
	 }
  }
  public function insertbrands()
  {
	  $db = M("BestForBaby");
	  $brand_db = M("Brand");
	  $rs = $db->select();
	  foreach($rs as $r)
	  {
		  $brand = $r['brand'];
		  $checker = $brand_db->where("cn_name like '%$brand%' or name like '%$brand%'")->find();
		  if($checker)
		  {
			  $r['brand_id'] = $checker['id'];
			  $db->save($r);
		  }
		  else
		  {
			  $data['name'] = $brand;
			  $data['cn_name'] = $brand;
			  $data['corp_id'] = $r['company_id'];
			  $id = $brand_db->add($data);
			  $r['brand_id'] = $checker['id'];
			  $db->save($r);
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
   public function insertView()
   {
	   $db = M("ItemView"); 
	   if(IS_POST || IS_AJAX)
	   {              
		   if($db->create())
		   {                 
			   if($db->add())
			   $this->success("插入成功");
			   else
			   $this->error("插入失败");   
		   }
	   }
	   else
	   {
		   $id = I("get.id",0,'intval');
		   $db = D($this->_model);
		   $item = $db->relation(true,"view")->find($id);//where("item_id = $id")->select();
		  
		   $this->assign("viewOption",$item['view']); 
		   $this->assign("item",$item);
		   $this->assign("action",__FUNCTION__);
		   $this->display();
	   }
   }
   public function deleteView()
   { 
	   $model = "ItemColor";
	   $id = I("get.id",0,"intval");
	   if($id > 0)
	   {                              
		   if(deleteItem($model,$id))
		   {
			$this->success("删除成功");    
		   }
		   else
		   {
			   $this->error("删除失败");
		   }
	   }
	   else
	   {
		   $this->error("参数有误");
	   }
   }
   /***************
   * 编辑View选项
   * 作者：Wilson
   * 输入：viewID,itemID
   * 输出：编辑结果
   */
   public function editView()
   {
		$viewDB = M("ItemView");
	   if(IS_POST)
	   {
		   $data = $viewDB->create();
		   
		   $rs = $viewDB->save($data);
		   if($rs)
		   {
			   $id = I('post.item_id');
			   $this->success("操作成功",U("Home/Bestforbaby/viewitem/id/$id"));
		   }
		   else
		   {
			   $this->error("操作失败",U("Home/Bestforbaby/viewitem/id/$id"));

		   }
	   }
	   else
	   {
		   //view-id,item-id
		   $viewID = I('get.viewID',0,'intval');
		   $itemID = I('get.itemID',0,'intval');
		   $db = D($this->_model);
		   
		   $item = $db->relation(true,"view")->find($itemID);
		   $view = $viewDB->find($viewID);
		   $this->assign("item",$item);
		   $this->assign("viewOption",$item['view']);
		   $this->assign("view",$view);
		   $this->assign("action",__FUNCTION__);
		   $this->display("insertView");
		   
	   }
   }
   /***************
   * 编辑Size选项
   * 作者：Wilson
   * 输入：sizeID,itemID
   * 输出：编辑结果
   */
   public function editSize()
   {
		$sizeDB = M("ItemSize");
	   if(IS_POST)
	   {
		   $data = $sizeDB->create();
		   
		   $rs = $sizeDB->save($data);
		   if($rs)
		   {
			   $id = I('post.item_id');
			   $this->success("操作成功",U("Home/Bestforbaby/sizeitem/id/$id"));
		   }
		   else
		   {
			   $this->error("操作失败",U("Home/Bestforbaby/viewitem/id/$id"));

		   }
	   }
	   else
	   {
		   //size-id,item-id
		   $sizeID = I('get.sizeID',0,'intval');
		   $itemID = I('get.itemID',0,'intval');
		   $db = D($this->_model);
		   
		   $item = $db->relation(true,"size")->find($itemID);
		   $size = $sizeDB->find($sizeID);
		   $this->assign("item",$item);
		   $this->assign("sizeOption",$item['size']);
		   $this->assign("size",$size);
		   $this->assign("action",__FUNCTION__);
		   $this->display("insertSize");
		   
	   }
   }
   public function deleteSize()
   {
	   $db = M("ItemSize"); 
	   $model = "ItemSize";
	   $id = I("get.id",0,"intval");
	   if($id > 0)
	   {                              
		   if(deleteItem($model,$id))
		   {
			$this->success("删除成功");    
		   }
		   else
		   {
			   $this->error("删除失败");
		   }
	   }
	   else
	   {
		   $this->error("参数有误");
	   }
   }
   public function insertSize()
   {
	   $db = M("ItemSize"); 
	   if(IS_POST || IS_AJAX)
	   {
		   
		   if($db->create())
		   {
			  
			   if($db->add())
			   {
				   $itemID = I("post.item_id");
				   $this->success("修改成功",U("viewitem?id=$itemID"));
			   }
			   else
			   $this->error("插入失败");   
		   }
	   }
	   else
	   {
		   $id = I("get.id",0,'intval');
		   $db = D($this->_model);
		   $item = $db->relation(true,"size")->find($id);//where("item_id = $id")->select();
		   
		   $this->assign("sizeOption",$item['size']); 
		   $this->assign("item",$item);
		   $this->assign("action",__FUNCTION__);
		   $this->display();
	   }
   }
   /****
   * 增加实例
   */     
   public function insertInstance()
   {
	   if(IS_POST || IS_AJAX)
	   {
		   
		   if($db->create())
		   {
			   
			   if($db->add())
			   $this->success("插入成功");
			   else
			   $this->error("插入失败");   
		   }
	   }
	   else
	   {
		   $id = I("get.id",0,'intval');
		   $items = $db->where("item_id = $id")->select();
		   $this->assign("items",$items); 
		   $this->assign("item_id",$id);
		   $this->display();
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
