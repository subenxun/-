<?php
$domain = isset($_SERVER['HTTP_ORIGIN'])?$_SERVER['HTTP_ORIGIN']:'*';
header("Access-Control-Allow-Origin:{$domain}");
header("Access-Control-Allow-Credentials:true");
header('Access-Control-Allow-Headers:*');
header('content-type:application/json');
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit;
}
    //1.取得页面发过来的POST数据
    $arr = file_get_contents("php://input"); 
    $test = json_decode($arr,true);
    $username = $test['username'];
    $password = $test['password'];
    //2,连接数据库
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
    //4.检测用户名是否存在
    $sql="
        SELECT username, password FROM login WHERE username='$username' and password='$password'
    ";
    
    //echo $sql;exit();
    $result=$conn->query($sql);//发送sql

    //解析结果集
    
   //print_r($result);die();
    if($result->num_rows > 0){
           $data['code'] = 0;
           $data['msg'] = 'success'; 
           $data['data'] = array(
                'token' => md5('123'),
           );
    }else{
        $data['code'] = 1;
        $data['msg'] = 'fail';
    }
    echo json_encode($data);
?>