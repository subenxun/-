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
$sql="SELECT `dbo.cardinfo`.cardNum,`dbo.cardinfo`.Name,`dbo.cardinfo`.BankId,`dbo.billinfo`.DueDate,`dbo.billinfo`.RepayAmount,`dbo.billinfo`.MinAmount,`dbo.billinfo`.SurplusLimit,`dbo.billinfo`.Id  FROM `dbo.billinfo` left join `dbo.cardinfo` on `dbo.billinfo`.CardInfoId=`dbo.cardinfo`.Id ";

//echo $sql;exit();
$result=$conn->query($sql);//发送sql
if($result){
    $return_data = [];
    while($row=$result->fetch_array(MYSQLI_ASSOC))
    {
        $return_data[] = $row;
    }    
    $data['code'] = 0;
    $data['msg'] = 0; 
    $data['data'] = $return_data;  
    echo json_encode($data);      
}else{
    echo "数据获取失败";
}



