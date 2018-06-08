<?php
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *
header('Access-Control-Allow-Origin:*');
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');

//draw length start
//

$draw = $_POST["draw"];
$start = $_POST["start"];
$length = $_POST["length"];

$mysqli = new mysqli("bdm300375458.my3w.com", "bdm300375458", "mysql3862749", "bdm300375458_db");
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}
$mysqli->query("set names utf8");
$sql = "select count(*) as total from jqgrid";
$result = $mysqli->query($sql);

$rowArr = $result->fetch_assoc();
$recordsTotal = $rowArr["total"]; //返回总页数
$recordsFiltered = $recordsTotal;

$sql2 = "select  * from jqgrid limit " . $start . "," . $length;

$result = $mysqli->query($sql2);
$arr = [];
$arr["draw"] = $draw;
$arr["recordsTotal"] = $recordsTotal;
$arr["recordsFiltered"] = $recordsFiltered;
$arr["error"] = 0;
$k = 0;
while ($row = $result->fetch_assoc()) {
    $arr["data"][] = $row;

}

echo json_encode($arr);

?>