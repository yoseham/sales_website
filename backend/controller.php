<?php
include "conn.php";
$func = $_POST['req'];
if($func=="report"){

    $pid = $_POST['pid'];
    echo report_monthly_sale($conn,$pid);
}
else if($func=='add_purchase'){
    array_pop($_POST);
    echo add_purchase($conn);
}else if($func=='add_log'){
    $key_value = $_POST['key_value'];
    $tables_name = $_POST['tables_name'];
    $operation = $_POST['operation'];
    add_log($conn,$tables_name,$key_value,$operation);
}else if($func=='more_operation'){
    $query = $_POST['query'];
    $result = $conn->query($query);
    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    echo json(1,'SQL: '.$query,$data);
}
function report_monthly_sale($conn,$pid){
    $query = 'select a.pid, a.pname, b.* from products a, purchases b where a.pid=b.pid and a.pid="'.$pid.'"';
    $result = $conn->query($query);

    $data = array();
    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }
    return json(1,'数据返回成功',$data);
}
function add_log($conn,$tables_name,$key_value,$operation){
    $time = date('Y-m-d H:i:s',time());
    $jquery = 'insert into logs(logid,who,time,tables_name,operation,key_value) values (null ,"'.$GLOBALS['username'].'","'.$time.'","'.$tables_name.'","'.$operation.'",'.$key_value.')';
    $conn->query($jquery);
}
function add_purchase($conn){
    $pid = $_POST['pid'];
    $keys =  array_keys($_POST);
    $values = array_values($_POST);
    $query1 = 'select original_price, discnt_rate,qoh,qoh_threshold from  products where pid='.$pid;
    $result = $conn->query($query1);
    $row = $result->fetch_assoc();
    if($row['qoh']<$_POST['qty']){
        return json(1,'库存不足'.$row['qoh'].'______'.$_POST['qty']);
    }else{
        $price = $row['original_price']*(1-$row['discnt_rate']);

        $conn->query('update products set qoh = '.($row['qoh']-$_POST['qty']).' where pid='.$pid);
        add_log($conn,'products',$_POST['pid'],'update');

        $time = '"'.date('Y-m-d H:i:s',time()).'"';
        $conn->query('update customers set visits_made = visits_made+1, last_visit_time='.$time.' where cid='.$_POST['cid']);
        add_log($conn,'customers',$_POST['cid'],'update');

        $total_price = $price*$_POST['qty'];
        $keys[]='total_price';
        $keys[]='ptime';
        $values[] = $total_price;
        $values[] = $time;
        $query2 = 'insert into purchases ('.implode(',',$keys).') values ( '.implode(',',$values).' )';
        add_log($conn,'purchases',$_POST['pur'],'insert');

        if (!mysqli_query($conn,$query2))
        {
            return json(1,'SQL: '.$query2.'<br><br> ERROR: '.mysqli_error($conn));
        }else{
            $str = '';
            if($row['qoh']-$_POST['qty']<$row['qoh_threshold']){
                $str='warn: 当前库存量'.($row['qoh']-$_POST['qty']).'低于最少库存量要求 ';
                $conn->query('update products set qoh = '.(2*$row['qoh']).' where pid='.$pid);
                $str = $str.'tips: 产品编号为'.$pid.'的现存量已增加到'.($row['qoh']+$_POST['qty']);
            }

            return json(0,'result: 购买成功 '.$str);
        }
    }
}

mysqli_close($conn);
?>