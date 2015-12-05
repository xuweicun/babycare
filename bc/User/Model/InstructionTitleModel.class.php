<?php
namespace Home\Model;
use Think\Model\RelationModel;
	class InstructionTitleModel extends RelationModel{
	protected $_link = array(
		'Instruction' => array(
			'mapping_type' => self::HAS_MANY,
			'class_name'   => 'Instruction',
			'foreign_key'  => 'title_id',
			'mapping_name' => 'instruction'//,
			//'as_fields'    => 'id:size_id,name:size_name,cn_name:size_cn_name'           
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
   // array('token','gettoken',1,'callback'),
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
		return 23233;
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