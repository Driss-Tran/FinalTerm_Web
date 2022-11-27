<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7b78e77d77.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Chức năng chuyển tiền</title>
</head>
<?php
    include 'connect.php';  
    $err='';
    date_default_timezone_set("Asia/Bangkok");
    if(isset($_POST['phone']))
    {
        $phone = $_POST['phone'];
        $money = $_POST['moneyTransfer'];
        $fee = $_POST['fee'];
        $desc = $_POST['desc'];
        if(empty($phone))
        {
            $err = "Bạn chưa nhập số điện thoại";
        }
        elseif(strlen($phone) !== 10)
        {
            $err= "Số điện thoại bạn nhập không hợp lệ";
        }
        elseif(empty($money))
        {
            $err = "Bạn chưa nhập số tiền cần chuyển";
        }
        elseif((int) $money < 1)
        {
            $err = "Số tiền bạn nhập không hợp lệ";
        }
        else
        {
            $SQL = "Select * from logup where phone = '$phone'";
            $query_phone=mysqli_query($conn,$SQL);
            $check_phone=mysqli_num_rows($query_phone);
            if($check_phone == 0)
            {
                $err = "Số điện thoại này không tồn tại";
            }
            else
            {
                $data = mysqli_fetch_assoc($query_phone);
                $username = $data['username'];
                $_SESSION['name_receiver'] = $username;
                $email = $data['email'];
                $phone =  $data['phone'];
                $SQL_logup = "Select * from login where email = '$email'";
                $query_account=mysqli_query($conn,$SQL_logup);
                $data_logup = mysqli_fetch_assoc($query_account);
                $id_account = $data_logup['username'];
                echo "
                <div class='container'>
                <div class='row'>
                    <div class='col-md-8 col-lg- my-5 mx-auto mx-sm-auto border rounded px-3 py-3'>
                        <form method='post'> 
                            <div class='form-group mx-5'>
                                <label for='name'><b>Tên người nhận</b></label>
                                <p>$username</p>
                            </div>
                            <div class='form-group mx-5'>
                                <label for='name_account'><b>Số tài khoản người nhận</b></label>
                                <input type='hidden' id='name_account' class='form-control'  name='name_account' value='$id_account'>
                                <p>$id_account</p>
                            </div>
                            <div class='form-group mx-5'>
                                <input type='hidden' id='email' class='form-control'  name='email' value='$email'>
                            </div>
                            <div class='form-group mx-5'>
                                <input type='hidden' id='fee' class='form-control'  name='fee' value='$fee'>
                            </div>
                            <div class='form-group mx-5'>
                                <label for='money'><b>Số tiền chuyển</b></label>
                                <input type='hidden' id='money' class='form-control'  name='money' value='$money'>
                                <p>".number_format($money)."đ</p>
                            </div>
                            <div class='form-group mx-5'>
                                <label for='money'><b>Ghi chú</b></label>
                                <input type='hidden' id='description' class='form-control'  name='description' value='$desc'>
                                <p>$desc</p>
                            </div>
                            <div class='text-center'>
                                <button type='submit' name='submit' class='transferBtn btn btn-success px-5 mr-2'>Xác nhận chuyển tiền</button>
                                <a href='./ChuyenTien.php' class='transferBtn btn btn-outline-success px-5 mr-2'>Quay về</a>
                            </div>
                        </form>
                    </div>
                </div>
                </div>";
                return;
            }
        }
    }
?>
<?php
    if(isset($_POST['money']))
    {
        $msg='';
        $username_host = $_SESSION['usr'];
        $money_Transfer = $_POST['money'];
        $_SESSION['money'] = $money_Transfer;
        $name_account = $_POST['name_account'];
        $emailReceiver = $_POST['email'];
        $_SESSION['emailReceiver'] =  $emailReceiver;
        $fee1 = $_POST['fee'];
        $_SESSION['fee']=$fee1;
        $_SESSION['desc'] = $_POST['description'];
        $sql = "Select * from logup where email = (select email from login where username = '$username_host')";
        $check_money = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        $emailSender = $check_money['email'];
        $moneyReceiver = $money_Transfer - 5/100*(int)$money_Transfer;
        $moneySender = $money_Transfer + 5/100*(int)$money_Transfer;
        if($check_money['moneyremaining'] < $money_Transfer)
        {
            $msg = "Tài khoản của bạn không đủ để thực hiện thao tác này";
            echo "<script type='text/javascript'>alert('$msg');</script>";
        }
        else
        {
            $otp = mt_rand(100000,999999);
            $_SESSION['otp'] = $otp;
            send_OTP($emailSender,$otp);
            header('location: verify_otp.php');
        }
       
    }
?>
<?php
    if(isset($_SESSION['verify']))
    {
        $username_host = $_SESSION['usr'];
        $PhiGD = 0;
        $sql = "Select * from logup where email = (select email from login where username = '$username_host')";
        $check_money = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        $emailSender = $check_money['email'];
        $moneyReceiver = $_SESSION['money'] - 5/100*(int) $_SESSION['money'];
        $moneySender =  $_SESSION['money'] + 5/100*(int) $_SESSION['money'];
        $comment = $_SESSION['desc'];
        $MaGD = "GD".mt_rand(100000,999999);
        $MaDT = "";
        $emailReceiver = $_SESSION['emailReceiver'];
        $confirm = 1;
        $type = "Chuyển tiền";
        $moneyTransfer = 0;
        if($_SESSION['money'] > 5000000)
        {
            $confirm = 0;
            $type = "Chuyển tiền";
            $dayTransfer = date("Y/m/d H:i:s A",time());
            $historyUpdateSql = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
            $waiting = $conn->prepare($historyUpdateSql);
            $waiting->bind_param("sssssss",$MaGD,$check_money['username'],$check_money['phone'],$dayTransfer,$_SESSION['money'],$type,$confirm);
            $waiting->execute();

            $DetailSql = "insert into detailtransfer(MaGD,username,email_sender,dayTransfer,moneyTransfer,receiver,email_receiver,PhiGD,comment,MaDT,type,status) values(?,?,?,?,?,?,?,?,?,?,?,?)";
            $detail = $conn->prepare($DetailSql);
            $comment = $_SESSION['desc'];
            $detail->bind_param("ssssssssssss",$MaGD,$check_money['username'],$emailSender,$dayTransfer,$_SESSION['money'],$_SESSION['name_receiver'],$_SESSION['emailReceiver'],$PhiGD,$comment,$MaDT,$type,$confirm);
            $detail->execute();

            $comment_waiting = "Số tiền bạn gửi quá lớn. Chờ Server xử lí một xíu nhé";
        }
        else 
        {
            $updateMoneyReceiver = "update logup set moneyremaining = moneyremaining + ? where email = ?";
            $updateMoneySender = "update logup set moneyremaining = moneyremaining - ? where email = ?";

            $check_stk = "Select * from logup where email ='$emailReceiver'";
            $query =mysqli_fetch_assoc(mysqli_query($conn,$check_stk));
            $stm = $conn->prepare($updateMoneyReceiver);
            $stmp = $conn->prepare($updateMoneySender);

            if($_SESSION['fee']=="receiver")
                {
                    $query['moneyremaining'] = $query['moneyremaining'] + $moneyReceiver;
                    $moneyTransfer = $moneyReceiver;
                    $stm->bind_param("ss", $moneyReceiver,$emailReceiver);
                    $stm->execute();
                }
            else{
                $query['moneyremaining'] = $query['moneyremaining'] +  $_SESSION['money'];
                $stm->bind_param("ss", $_SESSION['money'],$emailReceiver);
                $stm->execute();
            }
            if($_SESSION['fee']=="sender")
            {
                $moneyTransfer = $_SESSION['money'];
                $PhiGD = 5/100*(int) $_SESSION['money'];
                $stmp->bind_param("ss",$moneySender,$emailSender);
                $stmp->execute();
            }
            else{
                $PhiGD = 0;
                $stmp->bind_param("ss", $_SESSION['money'],$emailSender);
                $stmp->execute();
            }
            send_money_receiver($emailReceiver,$username_host,$moneyTransfer,$query['moneyremaining']);
            $dayTransfer = date("Y/m/d H:i:s A",time());
            $historyUpdateSql = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
            $success = $conn->prepare($historyUpdateSql);
            $success->bind_param("sssssss",$MaGD,$check_money['username'],$check_money['phone'],$dayTransfer,$_SESSION['money'],$type,$confirm);
            $success->execute();
    
            $DetailSql = "insert into detailtransfer(MaGD,username,email_sender,dayTransfer,moneyTransfer,receiver,email_receiver,PhiGD,comment,MaDT,type,status) values(?,?,?,?,?,?,?,?,?,?,?,?)";
            $detail = $conn->prepare($DetailSql);
            $detail->bind_param("ssssssssssss",$MaGD,$check_money['username'],$emailSender,$dayTransfer,$_SESSION['money'],$_SESSION['name_receiver'],$_SESSION['emailReceiver'],$PhiGD,$comment,$MaDT,$type,$confirm);
            $detail->execute();
    
        }
        unset($_SESSION['name_receiver']);
        unset($_SESSION['desc']);
        unset($_SESSION['verify']);
        unset($_SESSION['emailReceiver']);
        unset($_SESSION['fee']);
        unset($_SESSION['money']);
    }
?>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3" >
                <h5 class="text-center mb-3">Chuyển tiền</h5>
                <form id="moneyForm" method="post">
                <div class="form-group">
                        <label for="numberCard">Số tài khoản (tên đăng nhập) </label>
                        <?php 
                            $userNumb = $_SESSION['usr'];
                            echo "<h4>$userNumb</h4>";
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="phone">Số điện thoại của người cần chuyển</label>
                        <input type="text" id="phone" class="form-control" placeholder="Số điện thoại của người cần chuyển" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="moneyTransfer">Số tiền cần chuyển</label>
                        <input type="text" id="moneyTransfer" class="form-control" placeholder="Vui lòng nhập số tiền bạn cần chuyển" name="moneyTransfer">
                    </div>
                    <div class="form-group">
                        <label for="desc">Ghi chú</label>
                        <textarea id="desc" name="desc" rows="4" class="form-control" placeholder="Mô tả"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="fee">Phí chuyển: 5%</label>
                        <small>(Bạn muốn bên nào chịu phí này ?)</small>
                        <div class="form-check">
                            <label class="form-check-label" for="radio1">
                                <input type="radio" class="form-check-input" id="radio1" name="fee" value="sender" checked>Người Gửi
                            </label>
                            </div>
                        <div class="form-check">
                            <label class="form-check-label" for="radio2">
                                <input type="radio" class="form-check-input" id="radio2" name="fee" value="receiver">Người Nhận
                            </label>
                        </div>
                    </div>
                    <div class="has-error">
                    <span class="text-danger"><?php echo (isset($err)) ? $err : "" ?></span>
                    <?php echo (isset($comment_waiting)) ? "<script type='text/javascript'>alert('$comment_waiting');</script>" : "" ?>
                    </div>
                    <div class='text-center'>
                        <button type="submit" name="submit" value="submit" class="transferBtn btn btn-success px-5 mr-2">Chuyển tiền</button>
                        <a href="./homePage.php" class="transferBtn btn btn-outline-success px-5 mr-2">Quay về trang chủ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>