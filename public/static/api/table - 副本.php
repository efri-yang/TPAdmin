<?php
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
header("Access-Control-Allow-Origin: *"); // 允许任意域名发起的跨域请求  
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); 
// $con = mysql_connect("localhost","haodianbangdan","jqgrid");

$con = mysql_connect("bdm300375458.my3w.com","bdm300375458","mysql3862749");
if (!$con){
  die('Could not connect: ' . mysql_error());
}
mysql_query("set names utf8");
mysql_select_db("bdm300375458_db",$con);

$sql="select count(*) as total from jqgrid";
$result=mysql_query($sql,$con);
$arr=[];
while ($row = mysql_fetch_assoc($result)) {
	$arr[]=$row;
}

  $data=$_REQUEST;
  echo json_encode($data);
?>