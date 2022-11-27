<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require 'vendor/autoload.php';
    $host = 'localhost';
    $dbName = 'admin';
    $username = 'root';
    $password = '';
    $conn= mysqli_connect("localhost","root","");
    $dbCon = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    $db = "Create database if not exists admin";
    if(!$conn -> query($db))
    {
        die("Cannot create database: ".$conn->error);
    }
    $conn= mysqli_connect("localhost","root","","admin");
    $table_logup="Create table if not exists logup(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,username varchar(255), email varchar(40), address varchar(50), phone varchar(10), birthday date, CMNDbefore varbinary(255), CMNDafter varbinary(255), confirm int(11),moneyremaining bigint)";
    $table_login="Create table if not exists login(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,username varchar(255),password varchar(255), email varchar(255), timeOutTryLog int)";
    $table_countLogin = "Create table if not exists login_tryLog(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,ipAddress varchar(30),tryLog bigint)";
    $table_historytransfer = "Create table if not exists historytransfer(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,MaGD varchar(255),username varchar(255),phone varchar(10) ,dayTransfer datetime, moneyTransfer bigint, type varchar(255), status varchar(40))";
    $table_detailTransfer = "Create table if not exists detailTransfer(id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, MaGD varchar(255), username varchar(255),email_sender varchar(255), dayTransfer datetime, moneyTransfer bigint,receiver varchar(255), email_receiver varchar(255), PhiGD bigint,comment varchar(255), maDT varchar(10), type varchar(255), status varchar(40))";
    
    if(!$conn -> query($table_login))
    {
        die("Cannot create table: ".$conn->error);
    }
    if(!$conn -> query($table_logup))
    {
        die("Cannot create table: ".$conn->error);
    }
    if(!$conn -> query($table_countLogin))
    {
        die("Cannot create table: ".$conn->error);
    }
    if(!$conn -> query($table_historytransfer))
    {
        die("Cannot create table: ".$conn->error);
    }
    if(!$conn -> query($table_detailTransfer))
    {
        die("Cannot create table: ".$conn->error);
    }
    function getUsers($conn){
        $sql = "select * from logup";
        $result = $conn->query($sql);
        $data = array();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
               $data[] = $row;
            }
            return array('code'=>0,'data'=>$data);
            
        }
        return array('code'=>1,'message'=>"Dữ liệu rỗng");
    }
    function get_bill($conn)
    {
        $sql = "Select * from historytransfer";
        $query = $conn ->query($sql);
        if(!$query)
        {
            return array('code' => -1, 'error' => 'Can not execute command');
        }
        if($query ->num_rows==0)
        {
            return array('code' => -1, 'error' => 'No Data');
        }
        $data = array();
        while($row = $query->fetch_assoc())
        {
            
            $data[] = $row;
        }
        return array('code'=>0,'data'=>$data);
    }
    function get_all_detail($conn)
    {
        $sql = "Select * from detailtransfer";
        $query = $conn ->query($sql);
        if(!$query)
        {
            return array('code' => -1, 'error' => 'Can not execute command');
        }
        if($query ->num_rows==0)
        {
            return array('code' => -1, 'error' => 'No Data');
        }
        $data = array();
        while($row = $query->fetch_assoc())
        {
            $data[] = $row;
        }
        return array('code'=>0,'data'=>$data);
    }
    function get_bill_greater($conn)
    {
        $sql = "Select * from historytransfer";
        $query = $conn ->query($sql);
        if(!$query)
        {
            return array('code' => -1, 'error' => 'Can not execute command');
        }
        if($query ->num_rows==0)
        {
            return array('code' => -1, 'error' => 'No Data');
        }
        $data = array();
        while($row = $query->fetch_assoc())
        {
            if($row['moneyTransfer'] > 5000000)
            {
                $data[] = $row;
            }
        }
        return array('code'=>0,'data'=>$data);
    }


    function confirmUsers($conn, $input,$confirmNumber){
        $id = $input->id;
        $sql = "update logup set confirm = ? where id = ?";
        $stm = $conn->prepare($sql);
        $stm->bind_param('ss',$confirmNumber,$id);
        if(!$stm->execute()){
            return array('code'=>1,'message'=>'Không thể cập nhật dữ liệu');
        }
        return array('code'=>0,'message'=>'Đã cập nhật dữ liệu thành công');
    }

    function send_account($email,$tk,$mk)
    {    
             //Create an instance; passing `true` enables exceptions
             $mail = new PHPMailer(true);

             try {
                 //Server settings
                 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'phucvo04102002@gmail.com';                     //SMTP username
                 $mail->Password   = 'nicmckhkizbyktze';                               //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     
                 //Recipients
                 $mail->setFrom('phucvo04102002@gmail.com', 'Admin');
                 $mail->addAddress($email, 'User');     //Add a recipient
                 /*$mail->addAddress('ellen@example.com');               //Name is optional
                 $mail->addReplyTo('info@example.com', 'Information');
                 $mail->addCC('cc@example.com');
                 $mail->addBCC('bcc@example.com');*/
     
                 //Attachments
                 //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                 //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
     
                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'This is your account';
                 $mail->Body    = "Tài khoản:".$tk." và mật khẩu:".$mk;
                 //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
     
                 $mail->send();
                 return true;
             } catch (Exception $e) {
                 return false;
             }
    }

    
    function send_OTP($email,$otp)
    {    
             //Create an instance; passing `true` enables exceptions
             $mail = new PHPMailer(true);

             try {
                 //Server settings
                 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'phucvo04102002@gmail.com';                     //SMTP username
                 $mail->Password   = 'nicmckhkizbyktze';                               //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     
                 //Recipients
                 $mail->setFrom('phucvo04102002@gmail.com', 'Admin');
                 $mail->addAddress($email, 'User');     //Add a recipient
                 /*$mail->addAddress('ellen@example.com');               //Name is optional
                 $mail->addReplyTo('info@example.com', 'Information');
                 $mail->addCC('cc@example.com');
                 $mail->addBCC('bcc@example.com');*/
     
                 //Attachments
                 //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                 //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
     
                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'Confirm your account';
                 $mail->Body    = "Đây là mã OTP của bạn: ".$otp;
                 //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
     
                 $mail->send();
                 return true;
             } catch (Exception $e) {
                 return false;
             }
    }
    function send_money_receiver($email,$taikhoan,$money,$money_du)
    {    
             //Create an instance; passing `true` enables exceptions
             $mail = new PHPMailer(true);

             try {
                 //Server settings
                 //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                 $mail->isSMTP();                                            //Send using SMTP
                 $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                 $mail->Username   = 'phucvo04102002@gmail.com';                     //SMTP username
                 $mail->Password   = 'nicmckhkizbyktze';                               //SMTP password
                 $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                 $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
     
                 //Recipients
                 $mail->setFrom('phucvo04102002@gmail.com', 'Admin');
                 $mail->addAddress($email, 'User');     //Add a recipient
                 /*$mail->addAddress('ellen@example.com');               //Name is optional
                 $mail->addReplyTo('info@example.com', 'Information');
                 $mail->addCC('cc@example.com');
                 $mail->addBCC('bcc@example.com');*/
     
                 //Attachments
                 //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                 //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
     
                 //Content
                 $mail->isHTML(true);                                  //Set email format to HTML
                 $mail->Subject = 'PPS Bank xin thông báo';
                 $mail->Body    = "Tài khoản ".$taikhoan." vừa gửi cho bạn số tiền là: ".number_format($money)."đ Đây là số dư trong tài khoản của bạn: ".number_format($money_du).'đ';
                 //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
     
                 $mail->send();
                 return true;
             } catch (Exception $e) {
                 return false;
             }
    }
    mysqli_set_charset($conn,"utf8");
    session_start();
?>