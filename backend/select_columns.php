<?php

include "conn.php";
$keyWord = $_GET['table_name'];
$query = "select c.column_name,c.data_type,c.column_type,c.column_key,c.column_default,u.referenced_table_name,u.referenced_column_name from 
(select * from information_schema.columns where table_name = '".$keyWord."') c left outer join 
(select * from information_schema.key_column_usage where table_name = '".$keyWord."') u using(column_name)";
$result = $conn->query($query);
$data = array();
if($result->num_rows>0){
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
}
else{
//		echo "0结果";
}
echo json(1,'数据返回成功',$data);
$conn->close();

?>