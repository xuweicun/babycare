<?php
namespace User\Model;
use Think\Model\RelationModel;
include_once(COMMON_PATH."Common/bc.common.php");

    class ImgModel extends RelationModel{
    protected $_link = array(
        'ItemImg' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name'   => 'ItemImg',
            'foreign_key'  => 'img_id',
            'mapping_name' => 'item'//,
            //'as_fields'    => 'id:view_id,name:view_name,cn_name:view_cn_name'            
        ),
        'BrandImg' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name'   => 'BrandImg',
            'foreign_key'  => 'img_id',
            'mapping_name' => 'brand'//,
            //'as_fields'    => 'id:view_id,name:view_name,cn_name:view_cn_name'            
        ),
        'CompanyImg' => array(
            'mapping_type' => self::HAS_ONE,
            'class_name'   => 'CompanyImg',
            'foreign_key'  => 'img_id',
            'mapping_name' => 'company'//,
           //'as_fields'    => 'id:view_id,name:view_name,cn_name:view_cn_name'            
       
       
        )
    );
    protected $_validate = array(
          //  array('newname','require','ID不能为空',1),
          //  array('img','require','IMGb',1),
       //    array('barcode',array(2,444),'超出范围',1,'between'),
         //  array('newname','name','unequal',1,'confirm','1')
           // array('storeid','require','请选择店铺',1)
     );
   //  protected $patchValidate = true;
    protected $_auto = array (
  // array('new_corp','getNewCorp',1,'callback')
   // array('endtime','getTime',3,'callback'),
     //   array('time','time',1,'function') ,
       // array('id','setID',3,'callback'),
       // array('img','',2,'ignore')
    );
    function gettoken(){
		return session('token');
	}
    function setID()
    {
        
    }
    function getNewCorp()
    {
        return string_check(I("post.new_corp"));
    }
	function getTime(){
		$date=$_POST['enddate'];
		if ($date){
		$dates=explode('-',$date);
		$time=mktime(23,59,59,$dates[1],$dates[2],$dates[0]);
		}else {
			$time=0;
		}
		return $time;
	}
}

?>