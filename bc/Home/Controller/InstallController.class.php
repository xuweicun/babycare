<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image; 
header('Content-type: text/html; charset=utf-8'); 

include_once(COMMON_PATH."Common/bc.common.php");
class InstallController extends Controller {
    private $_itemTable = "bc_bestforbaby";
    private $_sucUrl    = "./viewStock";
    public function index(){
      $file = "babycare.sql";
      $database = "babycare";
      $conn=mysql_connect("localhost","root","");//指定数据库连接参数
      if(!mysql_select_db($database,$conn))
      {
        if (mysql_query("CREATE DATABASE $database",$conn))
            {
            echo "Database created"."<br/>";
            }
            else
            {
            echo "Error creating database: " . mysql_error();
            }
            mysql_select_db($database,$conn);
      }
      if(file_exists($file))
      {
        $sql=file_get_contents($file); //把SQL语句以字符串读入$sql
        $a=explode(";",$sql); //用explode()函数把‍$sql字符串以“;”分割为数组

        foreach($a as $b){ //遍历数组
        $c=$b.";"; //分割后是没有“;”的，因为SQL语句以“;”结束，所以在执行SQL前把它加上
        mysql_query($c); //执行SQL语句 
        }
        
        echo "导入".$file."文件到".$database."数据库完毕";
      }
      else
      {
        echo "sql file not found";
      }
      mysql_close($conn);

     
    } 
    
 
}   
?>