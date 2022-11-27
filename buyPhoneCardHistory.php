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
    <link rel="stylesheet" href="./style.css">
    <title>Lịch sử nạp tiền</title>
</head>
<?php
include './connect.php';
if(!isset($_SESSION['usr']))
{
    header('Location: login.php');
    die();
}

$username = $_SESSION['usr'];
$sql = "select username from logup where email = (select email from login where username = '$username')";
$temp=mysqli_fetch_assoc(mysqli_query($conn,$sql));
$dataName = $temp['username'];

$historyBoughtCardSql = "select * from historbuycardphone where username = ?";
$stm = $conn->prepare($historyBoughtCardSql);
$stm->bind_param('s',$dataName);
$stm->execute();

$result = $stm->get_result();
$count = mysqli_num_rows($result);?>



<body>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <a class="navbar-brand" href="./homePage.php">
                <h1 class="navbar-symbol"> <i class="fa fa-building mr-2"></i>PPS bank</h1>
            </a>
            <ul class="navbar-nav menuItems mb-3">
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
                      <a class="dropdown-item" href="#">Đổi mật khẩu</a>
                      <a class="dropdown-item" href="./buyPhoneCard.php">Mua thẻ điện thoại</a>
                      <a class="dropdown-item" href="./historyTransfer.php">Thông tin giao dịch</a>
                    </div>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="logout.php">Đăng xuất</a>
                </li>
            </ul>
            <i class='fa fa-bars text-white menu-icon' onclick='Handle()'></i>

    </nav>
    <div class="container">
        <h2 class="header_table">Thông tin giao dịch mua thẻ điện thoại</h2>
        <table class="table">
            <tr class="tr">
              <th class="th">STT</th>
              <th class="th">Tên khách hàng</th>
              <th class="th">Tên thẻ</th>
              <th class="th">Mã số thẻ</th>
              <th class="th">Ngày giao dịch</th>
              <th class="th">Mệnh giá</th>
            </tr>
            <?php if($count>0){
                $ID = 0;
            while($row = $result->fetch_assoc()){
                $ID++;
                $userName = $row['username'];
                $nameCard = $row['nameCard'];
                $seriCard = $row['seriCard'];
                $dayBought = $row['dayBought'];
                $moneyBought = $row['moneyBought'];
                echo "
                    <tr class='tr'>
                    <td class='td'>$ID</td>
                    <td class='td'>$userName</td>
                    <td class='td'>$nameCard</td>
                    <td class='td'>$seriCard</td>
                    <td class='td'>$dayBought</td>
                    <td class='td'>$moneyBought</td>
              </tr>
                ";
            }
        }
        ?>
        </table>
        <a href="./homePage.php" class="btn btn-success btn_home">Về trang chủ</a>
    </div>


</body>
</html>