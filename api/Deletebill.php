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
// $sql="
// SELECT `Id`, `Name`, `CardNum`, `BankId`, `FixedLimit`, `InterimLimit`, `ILimMaturityDay`, `BillDate`, `DueDate`, `CCVCode`, `EbankUname`, `CardMaturity`, `IsLocked` FROM `dbo.billinfo` WHERE Id='$index'";
// //echo $sql;exit();
// $result=$conn->query($sql);//发送sql

// //解析结果集

// //print_r($result);die();
// if($result->num_rows > 0){
//  echo "找到这条要被删除的数据了";
// }else{
//     echo "这条数据不存在或已经被删除了";
// }
$sql="
    DELETE FROM `dbo.billinfo` WHERE Id='$index'
";
$result=$conn->query($sql);//发送sql
if($result){
    echo "这条数据已经被删除了";
   }else{
       echo "删除失败";
   }
   

