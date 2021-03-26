<?php
include "conn.php";
$table = $_POST['table_name'];
$option = $_POST['option'];
$query = 'delete from '.$table.'where    '.$option;
if (!mysqli_query($conn,$query))
{
    echo json(1,'SQL: '.$query.'<br><br> ERROR: '.mysqli_error($conn));
}else{
    echo json(0,'SQL: '.$query.'<br><br> '.mysqli_affected_rows($conn).'record(s) delete');
}
mysqli_close($conn);
?>