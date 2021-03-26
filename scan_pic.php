<?php
$filename = $_POST['filename'];
//获取当前文件所在的绝对目录
$dir = dirname('../sale/assets/images/*');
//扫描文件夹
$file = scandir($dir);
$data = array();
for($i=0;$i<count($file);$i++){
    if(strpos($file[$i], $filename) === 0){
        $data[] = $file[$i];
    }
}
echo json_encode(array('data'=>$data));
?>