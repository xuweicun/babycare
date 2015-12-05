<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
//require_once(THINK_PATH."FirePHPCore/FirePHP.class.php");  
//ob_start();
//$firephp = FirePHP::getInstance(true);
class OptionController extends Controller {
    private $_table = "Color";
    public $numPerPage = 10;
    public function index(){
        
        die();
  
    } 
        /*
    *查看所有 
    * 
    */
    public function editColorOptions()
    {
        $db = D("Color");
       
        $item_id = I('get.item_id',0,'intval');
        //input
        $color_options = $this->getColorOptions($item_id);
        $this->assign("item_id",$item_id);
        $this->assign("color_options",$color_options);
        $this->display();                        
    }
    public function editSizeOptions()
    {
        $db = D("ItemSize");
       
        $item_id = I('get.item_id',0,'intval'); 
        //input
        $options = $this->getSizeOptions($item_id);
        $this->assign("item_id",$item_id);
        $this->assign("options",$options);
        $this->display();
    }
    public function getColorOptions($id = 0)
    {
        $db = D("Color");
        if(IS_AJAX)
        $item_id = I('get.item_id',0,'intval');
        else
        {
            $item_id = $id;
        }
        $items=$db->select();
        
      
        $new_items = array();
        if($item_id > 0)
        foreach($items as $t)
        {
            $id = $t['id'];
            $where = "item_id = $item_id and color_id=$id";
            $rs = $db->table("bc_item_color")->where($where)->find();
            if($rs)
            {
                $t['selected'] = 1;
            }
            else
             $t['selected'] = 0;
           $new_items[]  = $t;      
        }
        $this->assign("item_id",$item_id);
        $this->assign("items",$new_items);              
        if(IS_AJAX)
        {
            $view = $this->fetch();
            $this->ajaxReturn($view);
        }
        else
        return $new_items;
    }
    /******
    * 查看物品的规格选型
    * 
    */
    public function getSizeOptions($id = 0)
    {
        $model = "item_size";
        $db = D("ItemSize");
        if(IS_AJAX)
        $item_id = I('get.item_id',0,'intval');
        else
        $item_id = $id;
        $where = "item_id = $item_id";
        $items = $db->where($where)->select();
       
        if(IS_AJAX)
        {  
            $this->assign("items",$items);              
            $view = $this->fetch();
            $this->ajaxReturn($view);
        }
        else
        return $items;
    }
    public function modifyColorOption()
    {
        
        $item_id = I('post.item_id',0,'intval');
        $option_id = I('post.option_id',0,'intval');      
        $model = "ItemColor";
        $action = I('post.action','');
        $db = M($model);
        $where = "item_id = $item_id and color_id = $option_id"; 
        
        switch($action)
        {
            case "insert":   
            
            if(!$db->where($where)->find())
            {
                
                $data['item_id'] = $item_id;
                $data['color_id'] = $option_id;   
               
                if($db->add($data))
                {
                    $rs['result'] = "success";  
                 }
                else
                {
                    $rs['result'] = "fail";  
                }      
                    $this->ajaxReturn($rs);
               
             
            }
            else
            {
                $rs['result'] = "fail";
                $rs['error']  = "data exist";    
                $this->ajaxReturn($rs);  
            }      
           
            break;
            case "delete":
            if($db->where($where)->delete())
            {
               $this->_ajaxReturn(true);  
            }
            else
               $this->_ajaxReturn(false);  
            break;
        }                                   
    }
    private function _ajaxReturn($success=true)
    {
        $rs;
       if($success)
        {
            $rs['result'] = "success";
           
        }
        else
        {
            $rs['result'] = "fail";  
        }      
        $this->ajaxReturn($rs); 
    }
    public function addSizeOption()
    {
        if(IS_POST)
        {
            $db = D("ItemSize");    
            if($db->create())
            {
                $map['item_id'] = I('get.item_id',0,'intval');
                $map['size'] = $db->size;
                $map['unit'] = $db->unit;
                
                 
                if(!$db->where($map)->find())
                {
                    $db->item_id = $map['item_id'];
                    $db->add();
                    $this->success("成功");
                }
                else
                {
                    $this->error("重复数据");      
                }
            }
            else
            {
                 $this->error($db->getError(),1);  
            }
        }
        if(IS_AJAX)
        {
            $map['item_id'] = I('get.item_id',0,'intval');
            $map['size'] = I('post.size',''); 
            $map['unit'] = I('post.unit','');    
            $db = M("ItemSize");
            if(!$db->where($map)->find)  
            {
                $data['item_id'] = $item_id;
                $data['size'] = $size;
                $data['unit'] = $unit;
                if($db->create($data))
                {
                    $db->add();
                }
            }
            else
            {
                $this->_ajaxReturn(false);
            }      
        }
       
    }
    public function removeSizeOption()
    {  
        $model = "ItemSize";
        $db = M($model);
        if(IS_AJAX)
        {
            $id = I('get.id',0,'intval');
          
            if($db->where("id=$id")->delete())
            {
                $data['success'] = 1;  
                $this->ajaxReturn($data);           
            }
            
        }
        else
        {
            $id = I('get.id',0,'intval'); 
            if($db->where("id=$id")->delete())
            {
                $this->success("删除成功");
            } 
        }
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
