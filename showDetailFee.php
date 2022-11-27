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
    <title>Phê duyệt chuyển hoặc rút tiền</title>
</head>
<?php


include './connect.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    die();
}

$userSql = mysqli_query($conn,"select * from detailtransfer where MaGD =".$_GET['MaGD']);
$result = mysqli_fetch_assoc($userSql);
$id = $result['id'];
$MaGD = $result['MaGD'];
$username = $result['username'];
$email_sender= $result['email_sender'];
$dayTransfer = $result['dayTransfer'];
$moneyTransfer = $result['moneyTransfer'];
$receiver = $result['receiver'];
$email_receiver = $result['email_receiver'];
$PhiGD = $result['PhiGD'];
$comment = $result['comment'];
$maDT = $result['maDT'];
$type = $result['type'];
$status = $result['status'];

$PhiChuyen = $moneyTransfer*5/100

?>
<?php
    if(isset($_POST['accepted']))
    {
        if($type == "Chuyển tiền")
        {
            $updateSql_detail = mysqli_query($conn,"update detailtransfer set status = 1 where MaGD =".$_GET['MaGD']);
            $updateSql_history = mysqli_query($conn,"update historytransfer set status = 1 where MaGD =".$_GET['MaGD']);
    
            $select_receiver = mysqli_query($conn,"select * from logup where email = '$email_receiver'");
            // $select_sender =  mysqli_query($conn,"select * from logup where email = '$email_sender'");
    
            // $data_dender = mysqli_fetch_assoc($select_sender);
            $data = mysqli_fetch_assoc($select_receiver);
    
            if($PhiGD == 0)
            {
                $updateSql_money_sender = mysqli_query($conn,"update logup set moneyremaining = moneyremaining - '$moneyTransfer' where email = '$email_sender'");
                $updateSql_money_receiver = mysqli_query($conn,"update logup set moneyremaining = moneyremaining + '$moneyTransfer' - '$PhiChuyen' where email = '$email_receiver'");
                $sum = $data['moneyremaining'] + $moneyTransfer - $PhiChuyen;
                send_money_receiver($email_receiver,$username,$moneyTransfer,$sum);
            }
            else{
                $updateSql_money_sender = mysqli_query($conn,"update logup set moneyremaining = moneyremaining - '$moneyTransfer' - '$PhiChuyen' where email = '$email_sender'");
                $updateSql_money_receiver = mysqli_query($conn,"update logup setmoneyremaining = moneyremaining + '$moneyTransfer' where email = '$email_receiver'");
                $sum = $data['moneyremaining'] + $moneyTransfer;
                send_money_receiver($email_receiver,$username,$moneyTransfer,$sum);
            }
        }
        else
        {
            $updateSql_detail = mysqli_query($conn,"update detailtransfer set status = 1 where MaGD =".$_GET['MaGD']);
            $updateSql_history = mysqli_query($conn,"update historytransfer set status = 1 where MaGD =".$_GET['MaGD']);
            $sum = $moneyTransfer + $PhiChuyen;
            $updateMoneySql = "update logup set moneyremaining = moneyremaining - ? where email = ?";
            $stm = $conn->prepare($updateMoneySql);
            $stm->bind_param("ss",$sum,$email_sender);
            $stm->execute();
        }
       
    }
    if(isset($_POST['canceled']))
    {
        $updateSql_detail = mysqli_query($conn,"update detailtransfer set status = -1 where MaGD =".$_GET['MaGD']);
        $updateSql_detail = mysqli_query($conn,"update historytransfer set status = -1 where MaGD =".$_GET['MaGD']);
    }
?>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container tableList">
            <a class="navbar-brand" href="./homePage.php">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./userInfo.php">Chào,Admin
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <h2 class="header_table">Danh sách khách hàng chi tiết</h2>
        <table class="table" id="detailedUsersTbl">
            <thead>
                <tr class="tr">
                    <th class="th" scope="col">ID</th>
                    <th class="th" scope="col">Mã giao dịch</th>
                    <th class="th" scope="col">Tên khách hàng</th>
                    <th class="th" scope="col">Email người gửi</th>
                    <th class="th" scope="col">Thời gian giao dịch</th>
                    <th class="th" scope="col">Số tiền giao dịch</th>
                    <th class="th" scope="col">Người nhận</th>
                    <th class="th" scope="col">Email người nhận</th>
                    <th class="th" scope="col">Phí giao dịch</th>
                    <th class="th" scope="col">Nội dung giao dịch</th>
                    <th class="th" scope="col">Mã điện thoại (nếu có)</th>
                    <th class="th" scope="col">Loại giao dịch</th>
                    <th class="th" scope="col">Trạng thái giao dịch</th>
                    <th class="th" scope="col">Chức năng</th>
                    <!-- <th class="th" scope="col">Thao tác</th> -->
                </tr>
            </thead>
            <tbody>
                <tr class="getUserTr">
                    <?php
                    echo " <td class='th' scope='row' id='idUser'>$id</th>
                    <td class='td' id='MaGD'>$MaGD</td>
                    <td class='td' id='username'>$username</td>
                    <td class='td' id='email_sender'>$email_sender</td>
                    <td class='td' id='dayTransfer'>$dayTransfer</td>
                    <td class='td' id='moneyTransfer'>$moneyTransfer</td>
                    <td class='td' id='receiver'>$receiver</td>
                    <td class='td' id='email_receiver'>$email_receiver</td>
                    <td class='td' id='PhiGD'>$PhiGD</td>
                    <td class='td' id='comment'>$comment</td>
                    <td class='td' id='maDT'>$maDT</td>
                    <td class='td' id='type'>$type</td>
                    <td class='td' id='status'>$status</td>
                    <td class='td' id='button'>
                    <form method='POST' class='w-25 h-25 p-1'>
                        <button type='submit' class='btn btn-success mb-2 px-3' name='accepted' value=1>Xac nhan</button>
                        <button type='submit' class='btn btn-danger px-3' name='canceled' value=0>Huy</button>
                    </form>
                    </td>";

                    ?>
                </tr>
            </tbody>
        </table>
        <a  href="./listTransfer.php" class='btn btn-primary px-3 float-right mr-5'>Quay về</a>
