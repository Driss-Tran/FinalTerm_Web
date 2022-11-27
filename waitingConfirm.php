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
    <title>Trang quản lí người dùng</title>
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
            <a class="navbar-brand" href="./admin.php">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./admin.php">Chào,
                            admin
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
        <h2 class="header_table">Danh sách khách hàng chờ xác nhận</h2>
        <table class="table" id="usersTbl">
            <thead>
                <tr class="tr">
                    <th class="th" scope="col">ID</th>
                    <th class="th" scope="col">Tên khách hàng</th>
                    <th class="th" scope="col">Email</th>
                    <th class="th" scope="col">Địa chỉ</th>
                    <th class="th" scope="col">Xác minh tài khoản</th>
                    <th class="th" scope="col">CMND mặt trước</th>
                    <th class="th" scope="col">CMND mặt sau</th>
                </tr>
            </thead>
            <tbody>

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


        <div class="modal fade" id="detail-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role='document'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận tài khoản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <h3>Bạn có muốn xem chi tiết tài khoản này</h3>
                        <div class="modal-footer">
                            <div class="form-group">
                                    <input type="hidden" class="form-control" id="detail-ID" placeholder="Enter name" name='id'>
                                </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button id="getDetails" class="btn btn-primary">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


</body>
<script src="./main.js"></script>

</html>