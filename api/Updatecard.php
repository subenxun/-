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
$Index=$test['Index'];
$Name=$test['Name'];
$CardNum=$test['CardNum'];
$BankId=$test['BankId']; 
$FixedLimit=$test['FixedLimit'];
$InterimLimit=$test['InterimLimit'];
$ILimMaturityDay=$test['ILimMaturityDay'];
$BillDate=$test['BillDate'];
$DueDate=$test['DueDate'];
$CCVCode=$test['CCVCode'];
$EbankUname=$test['EbankUname'];
$CardMaturity=$test['CardMaturity'];
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
    UPDATE `dbo.cardinfo` SET `Name`='$Name',`CardNum`='$CardNum',`BankId`='$BankId',`FixedLimit`='$FixedLimit',`InterimLimit`='$InterimLimit',`ILimMaturityDay`='$ILimMaturityDay',`BillDate`='$BillDate',`DueDate`='$DueDate',`CCVCode`='$CCVCode',`EbankUname`='$EbankUname',`CardMaturity`='$CardMaturity' WHERE Id='$Index'";
print_r($sql);
$result=$conn->query($sql);
if($result){
    echo "修改数据成功";
}else{
    echo "修改数据失败";
}


