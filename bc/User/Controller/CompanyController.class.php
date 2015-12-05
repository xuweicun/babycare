<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class CompanyController extends Controller {
	
	protected $_table = "company"; 
	protected $_fathertable = "company";
	protected $_shownum = 10;
	protected $_sucurl = "/index.php/home/company/viewitems";
	protected $_thumbwidth = 100;
	protected $_thumbheight = 100; 
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
		$items;$page;
		$count = list_pages($db,$items,$page,
		 $this->_shownum,$map);
		 // =$db->where($map)->select();   
		 $this->assign("items",$items);
		$this->assign("page",$page);  
		$this->display("Public/viewitems");
	}
	/*
	*查看某个
	* 
	*/
	public function viewitem()
	{
		 $db = M($this->_table);
		 $id = I('get.id',0,'intval');
		 if($id==0)
		 {
			$this->error('商品不存在','/index.php/home/company',2);   
			die();
		 }
		 else
		 {
		   $item = $db->where("id = %d",$id)->find();
		   //$instruction = M('Instruction');
		   //$instructions = $instruction->where("item_id=%d",$id)->select();      
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
			if(!$db->where('id=%d',$id)->delete())
			{
				$this->error('操作失败');
			}
		}
	}
	
	public function searchitem()
	{
		//根据内容识别搜索类型
		//判断是否数字
		//如果是数字，搜索barcode
		//如果是字符串，搜索名称、品牌和功效
		 $db = D($this->_table);
		
		 $items;$page;  
		 $key = '%'.I('post.key','','strip_tags').'%';              
						
		 $map['name|cn_name'] = array('like',$key);
		 
		 $count = list_pages($db,$items,$page,
		 $this->_shownum,$map);
		 // =$db->where($map)->select();   
		 $this->assign("items",$items);
		$this->assign("page",$page);  
		$this->display("Public/viewitems");           
	}
  
  public function listChildren()
  {
	  
	  if(IS_AJAX)
	  {
		   $id = I('get.id',0,'intval');
		   if($id > 0)
		   {
			   $db = M('Brand');
			   $rs = $db->where("corp_id=%d",$id)->field("cn_name,id")->select();
			   
			   if($rs)
			   {
				   $idName = "brand_id";
				   $this->assign("items",$rs);     
				   $this->assign("set_name",$idName);     
				   $this->assign("option_name",$idName);     
				   $data['view'] = $this->fetch();                      
				   $this->ajaxReturn($data);
			   }
			   else
			   {
				   $err['err'] = $db->getDbError();
				   $this->ajaxReturn($err);                   
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
  public function insertitem()
  {
	
	if(IS_POST)
	{
		$db = D($this->_table);
			if($data = $db->create())
			{
				
				 if(@$id = $db->add($data))
				 {
					 //插入成功
					 $this->success("插入数据成功",$this->_sucurl);
					 
				 }
				 else
				 {
					 $this->error($db->getError(),$this->_sucurl);
				 }              
			}
			else
			{
			   $this->error($db->getError(),$this->_sucurl);     
			}
	}
	else
	{
		$this->display();
	}
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

  public function editItem()
  {       
   $db = D($this->_table);       
	if(IS_POST)
	{
		  $vo = $db->create();
		  trace($vo,'create vo');
		  if(!$rs = $db->save())
		  {
			  
			  $this->error("操作失败","/index.php/home/company/edititem/id/".I('post.id',0,'intval'));
		  }
		  else
		  {
			  $this->success("修改成功","/index.php/home/company/edititem/id/".I('post.id',0,'intval'));
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
