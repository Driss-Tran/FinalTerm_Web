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
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    die();
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
                        <a class="nav-link" href="./userInfo.php">Chào,admin
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
                    <th class="th" scope="col">Số điện thoại</th>
                    <th class="th" scope="col">Loại giao dịch</th>
                    <th class="th" scope="col">Trạng thái giao dịch</th>
                </tr>
            </thead>
            <tbody>
                <tr class="getUserTr">
                    <?php
                    if(isset($_GET['phone']))
                    {
                        $userSql = mysqli_query($conn,"select * from historytransfer where phone =".$_GET['phone']);
                        while($result = mysqli_fetch_assoc($userSql))
                        {
                            $id = $result['id'];
                            $MaGD = $result['MaGD'];
                            $username = $result['username'];
                            $dayTransfer = $result['dayTransfer'];
                            $moneyTransfer = $result['moneyTransfer'];
                            $phone = $result['phone'];
                            $type = $result['type'];
                            $status = $result['status'];

                            echo " 
                            <tr class='getUserTr'>
                            <th class='th' scope='row' id='idUser'>$id</th>
                            <td class='td' id='MaGD'>$MaGD</td>
                            <td class='td' id='username'>$username</td>
                            <td class='td' id='dayTransfer'>$dayTransfer</td>
                            <td class='td' id='moneyTransfer'>$moneyTransfer</td>
                            <td class='td' id='phone'>$phone</td>
                            <td class='td' id='type'>$type</td>
                            <td class='td' id='status'>$status</td>
                            </tr>";
                        }
                    }
                    ?>
            </tbody>
        </table>
        <div>
            <a href="./waitingConfirm.php" class="btn btn-primary">Danh sách các tài khoản chờ kích hoạt</a>
        </div>
        <div>
            <a href="./Confirmed.php" class="btn btn-primary">Danh sách các tài khoản đã kích hoạt</a>
        </div>
        <div>
            <a href="./Canceled.php" class="btn btn-primary">Danh sách các tài khoản hủy kích hoạt</a>
        </div>
        <div>
            <a href="./Locked.php" class="btn btn-primary">Danh sách các tài khoản khóa</a>
        </div>
</body>
<script src="./main.js"></script>

</html>