<?php
include "conn.php";
$table = $_GET['table_name'];
$query = 'SELECT * from '.$table;
$result = $conn->query($query);
$data = array();
while($row = $result->fetch_assoc()){
	$data[] = $row;
}
echo json(1,'数据返回成功',$data);
$conn->close();
?> 
