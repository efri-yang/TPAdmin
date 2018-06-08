<?php
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *  
header('Access-Control-Allow-Origin:*');    
// 响应类型    
header('Access-Control-Allow-Methods:POST');    
// 响应头设置    
header('Access-Control-Allow-Headers:x-requested-with,content-type');  



//
//	_search:false
//	nd:1521439548263
//	rows:10
//	page:1
//	sidx:id
//	sord:desc

$rows=$_POST["rows"];
$page=$_POST["page"];


$mysqli=new mysqli("bdm300375458.my3w.com","bdm300375458","mysql3862749","bdm300375458_db");
if($mysqli->connect_errno){
	printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
$mysqli->query("set names utf8");
$sql="select count(*) as total from jqgrid";
$result=$mysqli->query($sql);


$rowArr= $result->fetch_assoc();
$records=$rowArr["total"];



$total=ceil($records/$rows);
$start=($page-1)*$rows;
$end=$page*$rows;

$sql2="select  * from jqgrid limit ".$start.",".$end;

$result=$mysqli->query($sql2);
$arr=[];
$arr["page"]=$page;
$arr["total"]=$total;
$arr["records"]=$records;
$k=0;
while ($row = $result->fetch_assoc()) {
	$arr["rows"][$k]["id"]=$row["id"];
	foreach ($row as $key => $value) {
		$arr["rows"][$k]["cell"][]=$value;
	}
	$k++;
}




echo json_encode($arr);

?>