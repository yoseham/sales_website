<?php
include "conn.php";
$table = $_POST['table_name'];
array_pop($_POST);
$keys =  implode(',',array_keys($_POST));
$values = implode(',',array_values($_POST));
$query = 'insert into '.$table.'('.$keys.') values ( '.$values.' )';
if (!mysqli_query($conn,$query))
{
    echo json(1,'SQL: '.$query.'<br><br> ERROR: '.mysqli_error($conn));
}else{
    echo json(0,'SQL: '.$query.'<br><br> 1 record added');
}
mysqli_close($conn);
?>

