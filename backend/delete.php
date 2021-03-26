<?php
include "conn.php";
$table = $_POST['table_name'];
array_pop($_POST);
$keys =  array_keys($_POST);
$values = array_values($_POST);
$str = '';
for($i=0;$i<count($keys);$i++){
    $str = $str.$keys[$i].'='.$values[$i];
    if($i<count($keys)-1){
        $str=$str.' and ';
    }
}
$query = 'delete from '.$table.'where    '.$str;
if (!mysqli_query($conn,$query))
{
    echo json(1,'SQL: '.$query.'<br><br> ERROR: '.mysqli_error($conn));
}else{
    echo json(0,'SQL: '.$query.'<br><br> 1 record delete');
}
mysqli_close($conn);
?>
