<?php 
    require_once('./connect.php');
    if(isset($_POST['otp']))
    {
        $otp = $_POST['otp'];
        $err = '';
        if($otp != $_SESSION['otp'])
        {
            $err =  "Bạn nhập không đúng mã OTP";
        }
        else
        {
            $_SESSION['verify'] = 1;
            unset($_SESSION['otp']);
            header('location: ChuyenTien.php');
        }
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
    <title>Xác nhận mã OTP</title>
</head>
<body>
    <div class="container">
        <div class="row">
        <div class="col-md-8 col-lg-5 my-5 mx-2 mx-sm-auto border rounded px-3 py-3" >
            <form id="moneyForm" method="post">
                <div class="form-group">
                    <label for="OTP">Mã xác nhận OTP</label>
                        <input type="text" id="OTP" class="form-control" placeholder="Mã OTP" name="otp">
                </div>
                <div class="has-error">
                    <span class="text-danger"><?php echo (isset($err)) ? $err : "" ?></span>
                    </div>
                <div class='text-center'>
                        <button type="submit" name="submit" value="submit" class="transferBtn btn btn-success px-5 mr-2">Xác Nhận</button>
                        <a href="./ChuyenTien.php" class="transferBtn btn btn-outline-success px-5 mr-2">Quay về</a>
                </div>
            </form>
        </div>
        </div>
    </div>
</body>