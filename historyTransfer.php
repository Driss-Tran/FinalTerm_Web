<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Poppins:wght@200;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7b78e77d77.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    <title>Lịch sử giao dịch</title>
</head>
<?php
include './connect.php';
if(!isset($_SESSION['usr']))
{
    header('Location: login.php');
    die();
}
$username = $_SESSION['usr'];
$sql = "select * from logup where email = (select email from login where username = '$username')";
$temp=mysqli_fetch_assoc(mysqli_query($conn,$sql));
$dataName = $temp['username'];

$historyTransferSql = "select * from historytransfer where username = ? ORDER BY dayTransfer DESC";
$stm = $conn->prepare($historyTransferSql);
$stm->bind_param('s',$dataName);
$stm->execute();

$phoneTemp = $temp['phone'];
$result = $stm->get_result();
$count = mysqli_num_rows($result);?>


<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="./homePage.php">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <ul class="navbar-nav menuItems mb-5">
                <li class="nav-item">
                    <a class="nav-link" href="#">Chào,
                        <?php
                            echo $temp['username'];
                        ?>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                        Xem Thêm
                    </a>
                    <div class="dropdown-menu ">
                      <a class="dropdown-item" href="./userInfo.php">Thông tin khách hàng</a>
                      <a class="dropdown-item" href="./changePass.php">Đổi mật khẩu</a>
                      <a class="dropdown-item" href="./moneyTransfer.php">Chuyển tiền</a>
                      <a class="dropdown-item" href="./historyTransfer.php">Lịch sử giao dịch</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="logout.php">Đăng xuất</a>
                </li>
            </ul>
            <i class='fa fa-bars text-white menu-icon' onclick='Handle()'></i>

    </nav>
    <div class="container">
        <h2 class="header_table">Lịch sử giao dịch</h2>
        <input type="hidden" id="phoneID" name="phoneID" value="<?=$phoneTemp;?>">
        <table class="table" id="billTbl">
            <thead>
                <tr class="tr">
                    <th class="th" scope="col">STT</th>
                    <th class="th" scope="col">Mã giao dịch</th>
                    <th class="th" scope="col">Tên khách hàng</th>
                    <th class="th" scope="col">Ngày giao dịch</th>
                    <th class="th" scope="col">Số tiền</th>
                    <th class="th" scope="col">Loại giao dịch</th>
                    <th class="th" scope="col">Tình trạng</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
       
        </table>
        <a href="./homePage.php" class="btn btn-success btn_home">Về trang chủ</a>
    </div>
    <div class="modal fade" id="ChuyenTien-Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    <input type="hidden" class="form-control" id="MaGD"  name='MaGD'>
                                </div>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button id="accept" class="btn btn-primary">Đồng ý</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</body>
<script src="./main.js"></script>
</html>