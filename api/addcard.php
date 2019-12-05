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
                $sql = "
                SELECT `CardNum`,`Id` FROM `dbo.cardinfo` WHERE `Name`='$Name'
            ";

            $result = $conn->query($sql);

            if($result->num_rows > 0) {
                echo '{"result":"已经添加过信息了"}';
                return;
            }

       //4.检测用户名是否存在
            $sql="
            INSERT INTO `dbo.cardinfo` (`Name`, `CardNum`, `BankId`, `FixedLimit`, `InterimLimit`,`ILimMaturityDay`, `BillDate`, `DueDate`, `CCVCode`, `EbankUname`, `CardMaturity`) VALUES ('$Name' , '$CardNum', '$BankId', '$FixedLimit', '$InterimLimit','$ILimMaturityDay', '$BillDate','$DueDate' ,  '$CCVCode', '$EbankUname' , '$CardMaturity');
            ";
            print_r($sql);
            $result=$conn->query($sql);
?>