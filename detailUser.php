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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Admin</title>
</head>
<?php


include './connect.php';
if (!isset($_SESSION['usr'])) {
    header('Location: login.php');
    die();
}
if(isset($_GET['MaGD']))
{
    $userSql = mysqli_query($conn,"select * from detailtransfer where MaGD =".$_GET['MaGD']);
    $result = mysqli_fetch_assoc($userSql);
    $id = $result['id'];
    $MaGD = $result['MaGD'];
    $username = $result['username'];
    $dayTransfer = $result['dayTransfer'];
    $moneyTransfer = $result['moneyTransfer'];
    $receiver = $result['receiver'];
    $PhiGD = $result['PhiGD'];
    $comment = $result['comment'];
    $maDT = $result['maDT'];
    $type = $result['type'];
    $status = $result['status'];
}
?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="./homePage.php">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./userInfo.php">Chào,
                            <?= $username?>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container tableList">
        <h2 class="header_table">Danh sách khách hàng chi tiết</h2>
        <table class="table" id="detailedUsersTbl">
            <thead>
                <tr class="tr">
                    <th class="th" scope="col">ID</th>
                    <th class="th" scope="col">Mã giao dịch</th>
                    <th class="th" scope="col">Tên khách hàng</th>
                    <th class="th" scope="col">Thời gian giao dịch</th>
                    <th class="th" scope="col">Số tiền giao dịch</th>
                    <th class="th" scope="col">Người nhận</th>
                    <th class="th" scope="col">Phí giao dịch</th>
                    <th class="th" scope="col">Nội dung giao dịch</th>
                    <th class="th" scope="col">Mã điện thoại (nếu có)</th>
                    <th class="th" scope="col">Loại giao dịch</th>
                    <th class="th" scope="col">Trạng thái giao dịch</th>
                    <!-- <th class="th" scope="col">Thao tác</th> -->
                </tr>
            </thead>
            <tbody>
                <tr class="getUserTr">
                    <?php
                    if(isset($_GET['MaGD']))
                    {
                        if($status == 1)
                        {
                            $status = "Đã xác nhận";
                        }
                        else if($status == 0)
                        {
                            $status = "Đang chờ xác nhận";
                        }
                        else
                        {
                            $status = "Giao dịch này đã bị huỷ. Vui lòng liên hệ tổng đài 18001008";
                        }
                        echo " <th class='th' scope='row' id='idUser'>$id</th>
                        <td class='td' id='MaGD'>$MaGD</td>
                        <td class='td' id='username'>$username</td>
                        <td class='td' id='dayTransfer'>$dayTransfer</td>
                        <td class='td' id='moneyTransfer'>$moneyTransfer</td>
                        <td class='td' id='receiver'>$receiver</td>
                        <td class='td' id='PhiGD'>$PhiGD</td>
                        <td class='td' id='comment'>$comment</td>
                        <td class='td' id='maDT'>$maDT</td>
                        <td class='td' id='type'>$type</td>
                        <td class='td' id='status'>$status</td>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>

</body>
<script src="./main.js"></script>

</html>