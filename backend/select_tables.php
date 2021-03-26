<?php 
	include "conn.php";
	$query="select table_name from information_schema.TABLES where TABLE_SCHEMA='yangcx'";
	$result = $conn->query($query);
	$table_name = array();
	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
			$table_name[] = $row;
		}
		$table_name = json(1,'数据返回成功',$table_name);
		echo $table_name;
	}
	else{
		echo json(0,'数据返回失败',[]);
	}
	$conn->close();
?>
