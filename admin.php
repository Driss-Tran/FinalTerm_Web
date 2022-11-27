
<?php
// include './connect.php';
$_SERVER["DOCUMENT_ROOT"]."/connect.php";

if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    die();
}

?>
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
    <title>Trang chủ</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
        <a class="navbar-brand" href="./index.php">
            <i class="fa fa-building"></i>
            <h1 class="navbar-symbol">PPS bank</h1>
        </a>
        <ul class="navbar-nav menuItems mb-3">
            <li class="nav-item">
                <a class="nav-link login" href="./admin.php">Chào, admin</a>
            </li>
            <li class="nav-item">
                <a class="nav-link signup" href="./logout.php">Đăng xuất</a>
            </li>
        </ul>
        <i class="fa fa-bars text-white menu-icon" onclick="Handle()"></i>
    </nav>
        
    <h1 class="adminActionListHeader">Danh sách của người dùng</h1>
    <ul class="adminActionList">
        <li>
            <a href="./Confirmed.php" class="btn btn-success">Danh sách đã xác nhận</a>
        </li>
        <li>
            <a href="./waitingConfirm.php" class="btn btn-success">Danh sách đang xác nhận</a>
        </li>
        <li>
            <a href="./Canceled.php" class="btn btn-success">Danh sách không được kích hoạt</a>
        </li>
        <li>
            <a href="./Locked.php" class="btn btn-success">Danh sách khóa vô thời hạn</a>
        </li>
        <li>
            <a href="./listTransfer.php" class="btn btn-success">Danh sách giao dịch trên 5,000,000đ</a>
        </li>
    </ul>


      <footer class='footer bg-dark text-white mt-3'><h4 class='footer-font'> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>
      

</body>
<script src="./main.js"></script>

</html>


    