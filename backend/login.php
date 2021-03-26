<?php
$hostname = "106.54.91.157";
$database = "mysql";
$username = "root";
$password = "07597321";
$conn = mysqli_connect($hostname,$username,$password,$database) or die(mysql_error());
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$user =  $_POST['user'];
$passwd =  $_POST['passwd'];
$query = 'SELECT * from mysql.user where user = "'.$user.'" and authentication_string=PASSWORD("'.$passwd.'")';
$result = $conn->query($query);
if($result->num_rows>0){
    echo json_encode(array(
        'code'=>1,
        'message'=>'success',
        'data'=>$user
    ));
}else{
    echo json_encode(array(
        'code'=>0,
        'message'=>'error',
        'data'=>''
    ));
}
?>