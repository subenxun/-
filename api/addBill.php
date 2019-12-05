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
        print_r($arr);
        // $CardNum=$test['CardNum'];
        // $Name=$test['Name'];
        // $BankId=$test['BankId']; 
        $CardInfoId=$test['CardInfoId'];
        $DueDate=$test['DueDate'];
        $RepayAmount=$test['RepayAmount'];
        $MinAmount=$test['MinAmount'];
        $SurplusLimit=$test['SurplusLimit'];
    //连接数据库
        $serverAddr='localhost';
        $dbmsUsername="root";
        $dbmsPassword='';
        $dbName='credit_card';
        $conn=new mysqli($serverAddr,$dbmsUsername,$dbmsPassword,$dbName);
    if($conn->connect_error){
        echo "数据库连接失败".$conn->connect_error;
        return;
    }
            //     $sql = "
            //     SELECT `Id` FROM `dbo.cardinfo` WHERE `Name`='$Name'
            // ";

            // $result = $conn->query($sql);

            // if($result->num_rows > 0) {
            //     echo '{"result":"已经添加过信息了"}';
            //     return;
            // }

       //4.检测用户名是否存在
            $sql="
            INSERT INTO `dbo.BillInfo` (`CardInfoId`,`DueDate`,`RepayAmount`,`MinAmount`, `SurplusLimit`) VALUES ('$CardInfoId','$DueDate','$RepayAmount','$MinAmount','$SurplusLimit');
            ";
            print_r($sql);
            $result=$conn->query($sql);
            if($result){
                echo "添加账单信息成功";
         }else{
                echo "添加账单信息失败";
         }
     
?>