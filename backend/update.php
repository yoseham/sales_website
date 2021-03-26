<?php
include "conn.php";
$table = $_POST['table_name'];
$option = $_POST['option'];
array_pop($_POST);
array_pop($_POST);
$keys =  array_keys($_POST);
$values = array_values($_POST);
$str = '';
for($i=0;$i<count($keys);$i++){
    $str = $str.$keys[$i].'='.$values[$i];
    if($i<count($keys)-1){
        $str=$str.',';
    }
}
$query = 'update '.$table.' set '.$str.' where '.$option;
if (!mysqli_query($conn,$query))
{
    echo json(1,'SQL: '.$query.'<br><br> ERROR: '.mysqli_error($conn));
}else{
    echo json(0,'SQL: '.$query.'<br><br> 1 record update');
}
mysqli_close($conn);
?>