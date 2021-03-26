<?php
$hostname = "106.54.91.157";
$database = "yangcx";
$username = "yangcx";
$password = "07597321";
$conn = mysqli_connect($hostname,$username,$password,$database);
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

function json($code,$message="",$data=array()){
    $result=array(
        'code'=>$code,
        'message'=>$message,
        'data'=>$data
    );
    //输出json
    return json_encode($result);
}
?>