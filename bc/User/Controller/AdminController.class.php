<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class AdminController extends Controller {
    public $modelName;
    public $numPerPage;
    public function index(){
       
        die();
  
    } 
    /*
    *查看所有 
    * 
    */
   
    public function viewitems()
    {
        $db = D($this->$modelName);
        $count=$db->count();       
        $page=new \Think\Page($count,$this->numPerPage); 
        $items=$db->limit($page->firstRow.','.$page->listRows)->select();
        //var_dump($page);
        $show = $page->show();
        $this->assign("items",$items);
        $this->display();
    }
    /*
    *查看某个
    * 
    */
    public function viewitem()
    {
         $db = D($this->modelName);
         $id = I('get.id',0,'intval');
         if($id==0)
         {
            $this->error('商品不存在','/index.php/home/bestforbaby',2);   
            die();
         }
         else
         {
           $item=$db->where("id = %d",$id)->select();      
           $this->assign("item",$item[0]);
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
            $db = D($this->modelName); 
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
        $db = D($this->modelName);
        $key = I('post.key',0,'intval');
        $items = array();
        if($key != 0)
        {
              $items=$db->where("barcode = %d",$key)->select();      
        }
        else
        {
               
              $key = I('post.key','','strip_tags');
                          
              $key = stringCheck($key);   
             var_dump($key); 
             if($key != '')
              $items =$db->where("name like '%$key%' or function like '%$key%'")->select();      
              
        }    
       $this->assign("items",$items);
     
       $this->display();  
    }
 
  public function insertitem()
  {
    
    if(IS_POST)
    {
        $db = D($this->modelName);
            if($data = $db->create())
            {
                 if(@$id = $db->add($data))
                 {
                     //插入成功
                    // $this->success("插入数据成功");
                     echo("<img src = '{$db->img}'></img>");
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
               
               $thumb_savepath = createthumb($filepath,$savepath,100,100);//str_replace(".jpg","_thumb.jpg",$filepath);
               //$image->thumb(150,150)->save($thumb_savepath);
               echo "<script>window.opener.document.".$formname.".".$editname.".value='".$savepath."'</script>";//这一句改变了它的值;
               echo "<script>window.opener.document.".$formname.".thumb_".$editname.".value='".$thumb_savepath."'</script>";//这一句改变了它的值;
               echo "<script>alert('success');window.close();</script>";
             }
  }

  public function editItem()
  {       
   $db = D($this->modelName);       
    if(IS_POST)
    {
          $vo = $db->create();
          trace($vo,'create vo');
          if(!$rs = $db->save())
          {
              trace($rs,'save rs');
              $this->error("操作失败");
          }
          else
          {
               
          }
     }
     else
     {
               
       $id = I('get.id',0,'intval');
      
       if($rs = $db->where("id=%d",$id)->select())
       {
           
       
       $this->assign("item",$rs[0]);
       $this->display();  
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
     $upload->thumb = true; 
        // 设置引用图片类库包路径 
        $upload->imageClassPath = '@.ORG.Image'; 
        //设置需要生成缩略图的文件后缀 
        $upload->thumbPrefix = 'm_,s_';  //生产2张缩略图 
        //设置缩略图最大宽度 
        $upload->thumbMaxWidth = '400,100'; 
        //设置缩略图最大高度 
        $upload->thumbMaxHeight = '400,100'; 
        //设置上传文件规则 
        $upload->saveRule = uniqid; 
        //删除原图 
        $upload->thumbRemoveOrigin = true; 
     $info = $upload->upload();

     return $info;
   
  }
 
}   
