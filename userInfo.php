<?php
include './connect.php';
if(!isset($_SESSION['usr']))
{
    header('Location: login.php');
    die();
}
    $usrs=$_SESSION['usr'];
    $sql = "Select * from login where username='$usrs'";
    $look=mysqli_query($conn,$sql);
    $data_user=mysqli_fetch_assoc($look);
    $email=$data_user['email'];
    $sql_email = "Select * from logup where email='$email'";
    $find=mysqli_query($conn,$sql_email);
    $data=mysqli_fetch_assoc($find);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/7b78e77d77.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./style.css">
    

    <title>Thông tin khách hàng</title>
</head>
<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="./homePage.php">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <ul class="navbar-nav menuItems mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="#">Chào,
                        <?php
                            $username = $_SESSION['usr'];
                            $sql = "select username from logup where email = (select email from login where username = '$username')";
                            $temp=mysqli_fetch_assoc(mysqli_query($conn,$sql));
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
                      <a class="dropdown-item" href="#">Đổi mật khẩu</a>
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
        <div class="row">
            <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3">
                <h5 class="text-center mb-3 text-success">Thông tin khách hàng</h5>
                <form action="Exercise4.php" method="post">
                    <div class="form-group">
                        <label for="name">Họ tên khách hàng: </label>
                        <br>
                        <h6 class="text-success"><?=$data['username']?></h6>
                    </div>
                    <div class="form-group">
                        <label for="email">Email : </label>
                        <br>
                        <h6 class="text-success"><?=$data['email']?></h6>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Ngày sinh (YY/MM/DD)</label>
                        <h6 class="text-success"><?= $data['birthday']?></h6>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Địa chỉ</label>
                        <h6 class="text-success"><?= $data['address']?></h6>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Số điện thoại</label>
                        <h6 class="text-success"><?=$data['phone']?></h6>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Số dư</label>
                        <h6 class="text-success"><?=number_format($data['moneyremaining'])."đ"?></h6>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Trạng thái tài khoản</label>
                        <h6 class="text-success">
                        <?php
                            if(isset($data['confirm'])){
                                if($data['confirm']==="0"){
                                    echo 'Chưa xác nhận';
                                }else if($data['confirm']==="1"){
                                    echo 'Đã xác nhận';
                                }
                                else
                                {
                                    echo 'Cần cập nhật thông tin';
                                }
                            }
                        
                        ?>

                        </h6>
                    </div>
                     <a href="./homePage.php" class=" btn btn-success px-5 mr-2 fake-btn">Trở về trang chủ</a>
                </form>
            </div>
        </div>
    </div>
</body>
<footer class="footer bg-dark text-white"><h4 class="footer-font"> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>
<script src="./main.js">
</script>
</html>