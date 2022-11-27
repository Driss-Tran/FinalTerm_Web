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
    <title> Nạp thẻ điện thoại</title>
</head>

<?php
    include './connect.php';
    $message = '';
    $username = $_SESSION['usr'];
    $sql = "select * from logup where email = (select email from login where username = '".$username."')";
    $temp=mysqli_fetch_assoc(mysqli_query($conn,$sql));
    $dataName = $temp['username'];
    $moneyResult = $temp['moneyremaining'];
    date_default_timezone_set("Asia/Bangkok");
    if(!isset($_SESSION['usr']))
    {
        header('Location: login.php');
        die();
    }
    if(isset($_POST['submit'])){
        $cardName = $_POST['nameCardList'];
        $cardAmount = $_POST['cardAmount'];
        $cardPrice = $_POST['cardPriceList'];
        $sum = 0;
        $moneyFormat = 0;
        $moneyFormat1 = changeFormatMoney((int)$cardPrice);
        if($cardAmount <0 || $cardAmount === ''){
            $message = "Vui lòng nhập số lượng thẻ.";
        }
        else if($cardAmount>5){
            $message = "Bạn đã nhập quá số lượng thẻ tối đa.";
        }
        else {
            $cardListNumb = array();
            $sum = $cardAmount * $cardPrice;
            $moneyFormat = changeFormatMoney($sum);
            if(($moneyResult - $sum)< 0){
                $message = 'Bạn không đủ tiền để thực hiện giao dịch này';
            }
            else
            {
                $dayBought = date("Y/m/d H:i:s A",time());
                if($cardName === 'Viettel'){
                    while(count($cardListNumb)<$cardAmount)
                    {
                        $randNumb = randomNumb(10000,99999,1);
                        $infoCardNumber = "11111".$randNumb[0];
                        array_push($cardListNumb,$infoCardNumber);
                        
                        $MaGD = "GD".mt_rand(100000,999999);
                        $confirm = 'Đã xác nhận';
                        $type = "Mua card điện thoại";
                        $historyBoughtCard = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
                        $stmt = $conn->prepare($historyBoughtCard);

                        $stmt->bind_param("sssssss",$MaGD,$dataName,$temp['phone'],$dayBought,$cardPrice,$type,$confirm);
                        $stmt->execute();
                        
                        $DetailSql = "insert into detailtransfer(MaGD,username,dayTransfer,moneyTransfer,PhiGD,comment,MaDT,type,status) values(?,?,?,?,?,?,?,?,?)";
                        $detail = $conn->prepare($DetailSql);
                        $comment = 'Mua thẻ cào';
                        $phiGD = '0';
                        $detail->bind_param("sssssssss",$MaGD,$temp['username'],$dayBought,$cardPrice,$phiGD,$comment,$infoCardNumber,$type,$confirm);
                        $detail->execute();

                        $updateMoneySql = "update logup set moneyremaining = moneyremaining - ? where email = (select email from login where username = '".$username."')";
                        $stm = $conn->prepare($updateMoneySql);
                        $stm->bind_param("s",$sum);
                        $stm->execute();
                    }
                }
                else if($cardName === 'Mobifone'){
                    while(count($cardListNumb)<$cardAmount)
                    {
                        $randNumb = randomNumb(10000,99999,1);
                        $infoCardNumber = "22222".$randNumb[0];
                        array_push($cardListNumb,$infoCardNumber);
                        $MaGD = "GD".mt_rand(100000,999999);
                        $confirm = 'Đã xác nhận';
                        $type = "Mua card điện thoại";
                        $historyBoughtCard = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
                        $stmt = $conn->prepare($historyBoughtCard);
 
                        $stmt->bind_param("sssssss",$MaGD,$dataName,$temp['phone'],$dayBought,$cardPrice,$type,$confirm);
                        $stmt->execute();

                        $DetailSql = "insert into detailtransfer(MaGD,username,dayTransfer,moneyTransfer,PhiGD,comment,MaDT,type,status) values(?,?,?,?,?,?,?,?,?)";
                        $detail = $conn->prepare($DetailSql);
                        $comment = 'Mua thẻ cào';
                        $phiGD = '0';
                        $detail->bind_param("sssssssss",$MaGD,$temp['username'],$dayBought,$cardPrice,$phiGD,$comment,$infoCardNumber,$type,$confirm);
                        $detail->execute();

                        $updateMoneySql = "update logup set moneyremaining = moneyremaining - ? where email = (select email from login where username = '".$username."')";
                        $stm = $conn->prepare($updateMoneySql);
                        $stm->bind_param("s",$sum);
                        $stm->execute();
                    }
                }
                else if($cardName === 'Vinaphone'){
                    while(count($cardListNumb)<$cardAmount)
                    {
                        $randNumb = randomNumb(10000,99999,1);
                        $infoCardNumber = "33333".$randNumb[0];
                        array_push($cardListNumb,$infoCardNumber);
                        $MaGD = "GD".mt_rand(100000,999999);
                        $confirm = 'Đã xác nhận';
                        $type = "Mua card điện thoại";
                        $historyBoughtCard = "insert into historytransfer(MaGD,username,phone,dayTransfer,moneyTransfer,type,status) values(?,?,?,?,?,?,?)";
                        $stmt = $conn->prepare($historyBoughtCard);

                        $stmt->bind_param("sssssss",$MaGD,$dataName,$temp['phone'],$dayBought,$cardPrice,$type,$confirm);
                        $stmt->execute();
                        
                        $DetailSql = "insert into detailtransfer(MaGD,username,dayTransfer,moneyTransfer,PhiGD,comment,MaDT,type,status) values(?,?,?,?,?,?,?,?,?)";
                        $detail = $conn->prepare($DetailSql);
                        $comment = 'Mua thẻ cào';
                        $phiGD ='0';
                        $detail->bind_param("sssssssss",$MaGD,$temp['username'],$dayBought,$cardPrice,$phiGD,$comment,$infoCardNumber,$type,$confirm);
                        $detail->execute();

                        $updateMoneySql = "update logup set moneyremaining = moneyremaining - ? where username email = (select email from login where username = '".$username."')";
                        $stm = $conn->prepare($updateMoneySql);
                        $stm->bind_param("s",$sum);
                        $stm->execute();
                    }
                
                    
                }?>
                
                <div class='main'>
                <div class='content_buy'>
                    <h1 class='after_transfer'>Chúc mừng bạn đã mua thẻ thành công  </h1>
                    <p class='after_transfer--name'>Tên người nạp : <?=$dataName?></p>
                    <p class='after_transfer--money'>Số tiền là : <?=$moneyFormat?>đ</p>
                    <table class='table'> 
                        <tr class='tr'>
                            <th class='th'>STT</th>
                            <th class='th'>Tên loại thẻ</th>
                            <th class='th'>Thông tin thẻ</th>
                            <th class='th'>Mệnh giá thẻ</th>
                        </tr>
                        <?php
                            
                            for($i = 0; $i < count($cardListNumb);$i++){
                                echo "<tr class='tr'>
                                    <td class='td'>$i</td>
                                    <td class='td'>$cardName</td>
                                    <td class='td'>".$cardListNumb[$i]."</td>
                                    <td class='td'>".$moneyFormat1."đ</td>
                                </tr>";
                            }
                        ?>
                    </table>
                    <div class='button-groups'>
                        <a href='./homePage.php' class='btn btn-success mt-2'>Về trang chủ</a>
                        <a href='./historyTransfer.php' class='btn btn-primary text-decoration-none mt-2'>Kiểm tra thông tin giao dịch</a>
                        <a href='./buyPhoneCard.php' class='btn btn-danger text-decoration-none mt-2'>Mua thẻ điện thoại</a>
                    </div>
        
                </div>
            </div> <?php ;
                return;
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
    function randomNumb($min, $max, $quantity) {
        $numbers = range($min, $max);
        shuffle($numbers);
        return array_slice($numbers, 0, $quantity);
    }
?>

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
                  <a class="dropdown-item" href="./ChuyenTien.php">Chuyển tiền</a>
                  <a class="dropdown-item" href="./moneyTransfer.php">Nạp tiền</a>
                  <a class="dropdown-item" href="./HistoryTransfer.php">Lịch sử giao dịch</a>
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
            <h5 class="text-center mb-3">Mua thẻ điện thoại</h5>
            <form id="moneyForm" method="post">
            <div class="form-group">
                    <label for="numberCard">Số tài khoản (tên đăng nhập) </label>
                    <?php 
                        $userNumb = $_SESSION['usr'];
                        echo "<h4>$userNumb</h4>";
                    ?>
                </div>
                <div class="form-group nameCards">
                    <label for="nameCard">Chọn loại thẻ:</label>
                    <select name="nameCardList" id="nameCardList">
                        <option value="Viettel">Viettel</option>
                        <option value="Mobifone">Mobifone</option>
                        <option value="Vinaphone">Vinaphone</option>
                      </select>
                </div>
                <div class="form-group">
                    <label for="cardAmount">Số lượng thẻ <b>(Tối đa 5 thẻ một lần mua)</b></label>
                    <input type="number" id="cardAmount" class="form-control" placeholder="Vui lòng nhập số lượng thẻ bạn muốn mua" name="cardAmount">
                </div>
                <div class="form-group nameCards">
                    <label for="cardPriceList">Chọn mệnh giá:</label>
                    <select name="cardPriceList" id="cardPriceList">
                        <option value="10000">10,000đ</option>
                        <option value="20000">20,000đ</option>
                        <option value="50000">50,000đ</option>
                        <option value="100000">100,000đ</option>
                      </select>
                </div>
                <div class="has-error mb-2">
                <span class="text-danger"><?php echo (isset($message)) ? $message : "" ?></span>
                </div>
                <button type="submit" name="submit" value="submit" class="transferBtn btn btn-success px-5 mr-2">Thanh toán</button>
                <a href="./homePage.php" class="transferBtn btn btn-outline-success px-5 mr-2">Quay về trang chủ</a>
            </form>
        </div>
    </div>
</div>
<footer class="footer bg-dark text-white"><h4 class="footer-font"> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>
</body>
<script src="./main.js"></script>
</html>