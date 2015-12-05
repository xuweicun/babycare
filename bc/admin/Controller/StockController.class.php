<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
//header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class StockController extends Controller {
    private $_itemTable = "bc_bestforbaby";
    private $_sucUrl    = "./viewStock";
    public function index(){
   
      $this->display();
     
    } 
    /*
    *查看所有 
    * 
    */
   
    public function viewitems()
    {
        $db = D('BestForBaby');
        $count=$db->count();       
        $page=new \Think\Page($count,5); 
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
         $db = D('BestForBaby');
         $id = I('get.id',0,'intval');
         if($id==0)
         {
            $this->error('商品不存在','/index.php/home/bestforbaby',2);   
            die();
         }
         else
         {
           $item = $db->where("id = %d",$id)->find();
           $instruction = M('Instruction');
           $instructions = $instruction->where("item_id=%d",$id)->select();      
           $item[0]['content'] = 
           htmlspecialchars_decode($item[0]['content'],ENT_QUOTES);   
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
           $this->error('商品不存在');   
            die(); 
        }
        else
        {
            $db = D('BestForBaby'); 
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
        $db = D('BestForBaby');
        $key = I('post.key',0,'intval');
        $items = array();
        if($key != 0)
        {
              $items=$db->where("barcode = %d",$key)->select();      
        }
        else
        {
               
              $key = I('post.key');//,'','strip_tags');              
              $key = '%'.stringCheck($key).'%';               
             $map['name|brand|corp'] = array('like','%DDR%');
             if($key != '')
              //$items =$db->where("name like '%$key%' or brand like '%$key%'")->select();      
              $items =$db->where($map)->select();      
              
        }    
       $this->assign("items",$items);
     
       $this->display();  
    }
  public function stockDec()
  {
      if(IS_POST || IS_AJAX)
      {
          //计算收益
          $gain = calcGain();
          //更新库存
          updateStock();
          //增加日志
          updateStockLog();
          if(IS_AJAX)
          {
              
          }
          
      }
      else
      {
          
          $this->display();
      }
  }
  public function stockInc()
  {
      if(IS_POST || IS_AJAX)
      {
          $db = D('stock');
          if($db->create())
          {
              if($db->add())
              {
                  $this->success("操作成功",1,$this->_sucUrl);
              }
              else
              $this->error($db->getError(),1);     
          }
          else
          {
              $this->error("数据提交失败",1);
          }  
      }
      else
      {
          $this->display();
      }
  }
  public function editSource()
  {
      if(IS_POST || IS_AJAX)
      {
          $db = D('stock');
          if($db->create())
          {
              if($db->add())
              {
                  $this->success("操作成功",1,$this->_sucUrl);
              }
              else
              $this->error($db->getError(),1);     
          }
          else
          {
              $this->error("数据提交失败",1);
          } 
      }
      else
      {
          $this->display();
      }
  }
  
  public function insertitem()
  {
    
    if(IS_POST || IS_AJAX)
    {
        $db = D('BestForBaby');
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
   $db = D('BestForBaby');       
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
              $this->success("修改成功","/index.php/home/bestforbaby/viewitem/id/".I('post.id',0,'intval'));
          }
     }
     else
     {
               
       $id = I('get.id',0,'intval');
      
       if($rs = $db->where("id=%d",$id)->select())
       {
           
       $instruction = M('Instruction');
       $instructions = $instruction->where("item_id=%d",$id)->select();      
       $this->assign("item",$item[0]);
       $this->assign("instructions",$instructions);
       $this->assign("item",$rs[0]);
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
