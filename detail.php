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

$userSql = mysqli_query($conn,"select * from logup where id = ".$_GET['id']);
$result = mysqli_fetch_assoc($userSql);
$idUser = $result['id'];
$userName = $result['username'];
$email = $result['email'];
$address = $result['address'];
$phone = $result['phone'];
$birthday = $result['birthday'];
$confirm = $result['confirm'];
$CMNDBefore = $result['CMNDbefore'];
$CMNDAfter = $result['CMNDafter'];


?>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <div class="collapse navbar-collapse justify-content-end">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./userInfo.php">Chào,
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
        <h2 class="header_table">Danh sách khách hàng chi tiết</h2>
        <input type="hidden" name="history_transfer" id="history_transfer" value="<?= $phone ?>" />
        <table class="table" id="detailedUsersTbl">
            <thead>
                <tr class="tr">
                    <th class="th" scope="col">ID</th>
                    <th class="th" scope="col">Tên khách hàng</th>
                    <th class="th" scope="col">Email</th>
                    <th class="th" scope="col">Địa chỉ</th>
                    <th class="th" scope="col">Số điện thoại</th>
                    <th class="th" scope="col">Ngày tháng năm sinh</th>
                    <th class="th" scope="col">Xác minh tài khoản</th>
                    <th class="th" scope="col">CMND mặt trước</th>
                    <th class="th" scope="col">CMND mặt sau</th>
                    <th class="th" scope="col">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <tr class="getUserTr">
                    <?php
                    echo " <th class='th' scope='row' id='idUser'>$idUser</th>
                    <td class='td' id='customerName'>$userName</td>
                    <td class='td' id='emailUser'>$email</td>
                    <td class='td' id='Address'>$address</td>
                    <td class='td' id='phoneNumber'>$phone</td>
                    <td class='td' id='birthday'>$birthday</td>
                    <td class='td' id='confirmUser'>$confirm</td>
                    <td class='td' id='CMNDBefore'>$CMNDBefore</td>
                    <td class='td' id='CMNDAfter'>$CMNDAfter</td>";
                    if($confirm === "3"){
                        echo "<td class='td'><span class='edit-btn btn btn-success' data-index='$idUser' data-toggle='modal' data-target='#edit-Modal'>Mở khóa</span>
                        <p></p><span class='update-btn btn btn-primary' data-index='$idUser' data-toggle='modal' data-target='#update-Modal'>Cần cập nhật</span>
                        </td>";
                    }
                    else if($confirm === '-1'){
                        echo "<td class='td'><span class='edit-btn btn btn-success' data-index='$idUser' data-toggle='modal' data-target='#edit-Modal'>Mở khóa</span>";
                    }
                    else
                    {
                        echo "<td class='td'><span class='edit-btn btn btn-success' data-index='$idUser' data-toggle='modal' data-target='#edit-Modal'>Xác nhận</span>
                        <p></p><span class='del-btn btn btn-danger' data-index='$idUser' data-toggle='modal' data-target='#del-Modal'>Hủy</span>
                        <p></p><span class='update-btn btn btn-primary' data-index='$idUser' data-toggle='modal' data-target='#update-Modal'>Cần cập nhật</span>
                        <p></p><span class='update-btn btn btn-primary' id='history' data-index='$idUser' data-toggle='modal' data-target='#history-Modal' value='$phone'>Xem lịch sử giao dịch</span>
                        </td>";
                    }
                    
                   
                    ?>
                </tr>
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
    </div>

    <div class="modal fade" id="edit-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role='document'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xác nhận tài khoản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <h3>Bạn muốn xác nhận tài khoản này ?</h3>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="edit-ID" placeholder="Enter name" name='id'>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" id="editBtn" class="btn btn-primary">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="del-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role='document'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hủy tài khoản</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <h3>Bạn muốn hủy tài khoản này?</h3>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="del-ID" placeholder="Enter name" name='id'>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" id="deleteBtn" class="btn btn-primary">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="update-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role='document'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Yêu cầu cập nhật</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <h3>Bạn muốn yêu cầu cập nhật cho tài khoản này</h3>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="update-ID" placeholder="Enter name" name='id'>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" id="updateBtn" class="btn btn-primary">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="history-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role='document'>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Xem lịch sử giao dịch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                    </div>

                    <div class="modal-body">
                        <h3>Bạn có muốn xem lịch sử giao dịch của tài khoản này?</h3>
                        <div class="modal-footer">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="edit-ID" placeholder="Enter name" name='id'>
                            </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="button" id="historyBtn" class="btn btn-primary">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>
<script src="./main.js"></script>

</html>