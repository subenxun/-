<?php
$domain = isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'*';
header("Access-Control-Allow-Origin:{$domain}");
header("Access-Control-Allow-Credentials:true");
header('Access-Control-Allow-Headers:*');
header('content-type:application/json');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}
$arr = file_get_contents("php://input");
$test = json_decode($arr,true);
$index=$test['index'];
$Lock_number=$test['Lock_number'];
print_r($index);
$serverAddr='localhost';
$dbmsUsername="root";
$dbmsPassword='';
$dbName='credit_card';
$conn=new mysqli($serverAddr,$dbmsUsername,$dbmsPassword,$dbName);
//3.验证数据库是否连接成功
if($conn->connect_error){
    echo "数据库连接失败".$conn->connect_error;
    return;
}
$sql="
SELECT `IsLocked` FROM `dbo.cardinfo` WHERE Id='$index'";
//echo $sql;exit();
$result=$conn->query($sql);//发送sql
if($result->num_rows > 0){
    echo "找到这条数据了";

   }else{
       echo "这条数据不存在或已经被删除了";
   }

$sql="
    UPDATE `dbo.cardinfo` SET `IsLocked`='$Lock_number' WHERE Id='$index'";
print_r($sql);
$result=$conn->query($sql);
if($result){
    echo "修改数据成功";
}else{
    echo "修改数据失败";
}

   
