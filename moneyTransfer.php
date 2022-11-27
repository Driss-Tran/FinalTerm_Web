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
    include './connect.php';
    $message = '';
    $username = $_SESSION['usr'];
    $sql = "select * from logup where email = (select email from login where username = '$username')";
    $temp=mysqli_fetch_assoc(mysqli_query($conn,$sql));
    $dataName = $temp['username'];
    date_default_timezone_set("Asia/Bangkok");
    if(!isset($_SESSION['usr']))
    {
        header('Location: login.php');
        die();
    }
    if(isset($_POST['submit'])){
        $numberCard = $_POST['numberCard'];
        $expireDate = $_POST['expireDate'];
        $cvvCode = $_POST['cvvCode'];
        $moneyTransfer = $_POST['moneyTransfer'];
        $date1 = "2022-10-10";
        $date2 = "2022-11-11";
        $date3 = "2022-12-12";
        $dataMoney = changeFormatMoney($moneyTransfer);
        if(strlen($numberCard)!==6 ){
            $message = "Bạn đã nhập sai số thẻ vui lòng nhập lại";
        }
        else if(strlen($numberCard)===6 && $numberCard!=="111111" && $numberCard !=="222222" && $numberCard !=="333333"){
            $message = "Thẻ này không được hỗ trợ";
        }
        else if($expireDate !== $date1 && $expireDate !== $date2 && $expireDate !== $date3)
        {
            $message ="Ngày bạn nhập chưa hợp lệ vui lòng nhập lại";
        }
        else if($cvvCode !=="411" && $cvvCode!=="443" && $cvvCode!=="577"){
            $message = "Bạn đã nhập sai số mã CVV vui lòng nhập lại";
        }
        else{
            if($numberCard==='111111' && $expireDate === $date1 && $cvvCode ==='411'){
                $updateMoneySql = "update logup set moneyremaining = moneyremaining + ? where username = ?";
                $stm = $conn->prepare($updateMoneySql);
                $stm->bind_param("ss",$moneyTransfer,$dataName);
                $stm->execute();
                $confirm = 'Đã xác nhận';
                $type = "Nạp tiền";
                $MaGD = "GD".mt_rand(100000,999999);
                $dayTransfer = date("Y/m/d H:i:s A",time());
                $historyUpdateSql = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($historyUpdateSql);
                $stmt->bind_param("sssssss",$MaGD,$dataName,$temp['phone'],$dayTransfer,$moneyTransfer,$type,$confirm);
                $stmt->execute();
                echo "
                <div class='main'>
                    <div class='content'>
                        <h1 class='after_transfer'>Chúc mừng bạn đã nạp tiền thành công</h1>
                        <p class='after_transfer--name'>Tên người nạp : $dataName</p>
                        <p class='after_transfer--money'>Số tiền là : $dataMoney vnd</p>
                        <div class='button-groups'>
                            <a href='./homePage.php' class='btn btn-success mt-2'>Về trang chủ</a>
                            <a href='./userInfo.php' class='btn btn-primary text-decoration-none mt-2'>Kiểm tra thông tin cá nhân</a>
                        </div>
            
                    </div>
                </div>";
                return;
            }
            else if($numberCard==='222222' && $expireDate === $date2 && $cvvCode ==='443'){
                if((int)$moneyTransfer > 1000000){
                    $message = "Bạn chỉ có thể nạp tối đa 1000000 mỗi lần";
                }
                else
                {
                    $updateMoneySql = "update logup set moneyremaining = moneyremaining + ? where username = ?";
                    $stm = $conn->prepare($updateMoneySql);
                    $stm->bind_param("ss",$moneyTransfer,$dataName);
                    $stm->execute();
                    $confirm = 'Đã xác nhận';
                    $type = "Nạp tiền";
                    $MaGD = "GD".mt_rand(100000,999999);
                    $dayTransfer = date("Y/m/d H:i:s A",time());
                    $historyUpdateSql = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
                    $stmt = $conn->prepare($historyUpdateSql);
                    $stmt->bind_param("sssssss",$MaGD,$dataName,$temp['phone'],$dayTransfer,$moneyTransfer,$type,$confirm);
                    $stmt->execute();
                    echo "                              
                    <div class='main'>
                        <div class='content'>
                            <h1 class='after_transfer'>Chúc mừng bạn đã nạp tiền thành công</h1>
                            <p class='after_transfer--name'>Tên người nạp : $dataName</p>
                            <p class='after_transfer--money'>Số tiền là : $dataMoney vnd</p>
                            <div class='button-groups'>
                                <a href='./homePage.php' class='btn btn-success mt-2'>Về trang chủ</a>
                                <a href='./userInfo.php' class='btn btn-primary text-decoration-none mt-2'>Kiểm tra thông tin cá nhân</a>
                            </div>
            
                        </div>
                    </div>";
                return;
                }
            }
            else if($numberCard==='333333' && $expireDate === $date3 && $cvvCode ==='577'){
                $message = "Thẻ này hết tiền. Vui lòng thử thẻ khác";
            }
            else{
                $message = "Thông tin thẻ của bạn chưa khớp";
            }

        }
        
    }
    
    function changeFormatMoney($numb,$fractional=false){
        if($fractional){
            $numb = sprintf("%.2f",$numb);
        }
        while(true){
            $format = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2',$numb);
            if($format!=$numb){
                $numb = $format;
            }
            else{
                break;
            }
        }
        return $numb;
    }

?>


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
                      <a class="dropdown-item" href="#">Đổi mật khẩu</a>
                      <a class="dropdown-item" href="#">Chuyển tiền</a>
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
            <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3" >
                <h5 class="text-center mb-3">Nạp tiền vào tài khoản</h5>
                <form id="moneyForm" method="post">
                <div class="form-group">
                        <label for="numberCard">Số tài khoản (tên đăng nhập) </label>
                        <?php 
                            $userNumb = $_SESSION['usr'];
                            echo "<h4>$userNumb</h4>";
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="numberCard">Số thẻ</label>
                        <input type="text" id="numberCard" class="form-control" placeholder="Vui lòng nhập số thẻ" name="numberCard">
                    </div>
                    <div class="form-group">
                        <label for="expireDate">Ngày hết hạn (MM/DD/YYYY)</label>
                        <input type="date" id="expireDate" class="form-control" placeholder="Vui lòng nhập hạn sử dụng của thẻ" name="expireDate">
                    </div>
                    <div class="form-group">
                        <label for="cvvCode">Mã CVV</label>
                        <input type="text" id="cvvCode" class="form-control" placeholder="Vui lòng nhập mã CVV" name="cvvCode">
                    </div>
                    <div class="form-group">
                        <label for="moneyTransfer">Số tiền cần chuyển</label>
                        <input type="text" id="moneyTransfer" class="form-control" placeholder="Vui lòng nhập số tiền bạn cần chuyển" name="moneyTransfer">
                    </div>
                    <div class="has-error">
                    <span class="text-danger"><?php echo (isset($message)) ? $message : "" ?></span>
                    </div>
                    <button type="submit" name="submit" value="submit" class="transferBtn btn btn-success px-5 mr-2">Nạp tiền</button>
                    <a href="./homePage.php" class="transferBtn btn btn-outline-success px-5 mr-2">Quay về trang chủ</a>
                </form>
            </div>
        </div>
    </div>
<footer class="footer bg-dark text-white"><h4 class="footer-font"> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>

</body>
<script src="./main.js"></script>

</html>