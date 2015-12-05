<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class ImageController extends Controller {
    
    protected $_table = "Img"; 
    protected $_shownum = 10;
    protected $_sucurl = "/index.php/home";
    protected $_failurl = "/index.php/home";       
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
            $item = $db->find($id);
            if(!$item)
            {
                $this->error('数据不存在');
            }
            unlink($item['img']);
            @unlink($item['thumb_img']);
            if(!$db->relation("item")->delete($id))
            {
                $this->error('操作失败');
            }
            else
            $this->success('操作成功');
        }
    }
    
    public function searchitem()
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
 
  public function insertitem()
  {
    
    if(IS_POST || IS_AJAX)
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
        $corp = D($this->_fathertable);
        $companies = $corp->select();
        $this->assign("companies",$companies);
        $this->assign("action","insertitem");
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
