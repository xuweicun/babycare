<?php
namespace User\Model;
use Think\Model\RelationModel;
include_once(COMMON_PATH."Common/bc.common.php");

	class BrandModel extends RelationModel{
	protected $_link = array(
		'BrandCategory' => array(
		'mapping_type'  => self::HAS_MANY,
		'foreign_key'   => 'brand_id',
		'mapping_name'  => 'selectedCategory'
		
		),
		'Company' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name'   => 'Company',
			'foreign_key'  => 'corp_id',
			'mapping_name' => 'company',
			'as_fields'    => 'id:corp_id,name:corp_name,cn_name:corp_cn_name'        
		),
		'Item'  => array(
			'mapping_type' => self::HAS_MANY,
			'class_name'   => 'BestForBaby',
			'foreign_key'  => 'brand_id',
			'mapping_name' => 'bestforbaby'        
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