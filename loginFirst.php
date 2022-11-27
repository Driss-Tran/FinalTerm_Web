<?php
include './connect.php';
// echo "Tài khoản của bạn là: ".$_SESSION['tk']." Mật khẩu của bạn là: ".$_SESSION['mk'];
    if(!isset($_SESSION['email']))
    {
        header('Location: register.php');
        die();
    } 
    if(isset($_POST["usr"]))
    {
        $err=[];
        $username=$_POST["usr"];
        $password=$_POST["password"];
        $cpr_tk="Select * from login where username = '$username'";
        $cpr_pwd="Select * from login where password = '$password'";
        $query_tk=mysqli_query($conn,$cpr_tk);
        $query_mk=mysqli_query($conn,$cpr_pwd);
        $data=mysqli_fetch_assoc($query_tk);
        $check_tk=mysqli_num_rows($query_tk);
        $check_mk=mysqli_num_rows($query_mk);
        if($check_tk ==0)
        {
            $err['$username']="Tài khoản không đúng";
        }
        if($check_mk == 0)
        {
            $err['$password']="Mật khẩu không đúng";
        }
        if(empty($err))
        {
            $_SESSION['username']=$data['username'];
            header('location: confirmPass.php');
            unset($_SESSION['email']);
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
    <title>Đăng nhập lần đầu</title>
</head>
<body>

            
        <form action="loginFirst.php" method="POST" role="form">
            <div class="container w-100">
            <h2 class="text-center">Form đăng nhập lần đầu</h2>
            <div class="form-group input-items">
                <i class="fa fa-user"></i>
                <label for="usr" class="usr" style="cursor: pointer;">Tài khoản</label>
                <input name="usr" id="usr" type="text" class="form-control w-75" placeholder="Tài khoản" />
                <div class="has-error">
                    <span class="text-danger"><?php echo(isset($err['$username']))?$err['$username']:"" ?></span>
                </div>
            </div>
            
            <div class="form-group input-items">
                <i class="fa fa-lock"></i>
                <label for="pwd" class="usr" style="cursor: pointer;">Mật khẩu</label>
                <input name="password" id="pwd" type="password" class="form-control w-75" placeholder="Mật khẩu"/>
                <div class="has-error">
                    <span class="text-danger"><?php echo(isset($err['$password']))?$err['$password']:"" ?></span>
                </div>
            </div>

                <div class="input-items">
                    <button type='button' class="btn btn-secondary btn-sub mr-2" onclick="Redirect();">Tạo tài khoản</button>
                    <button type="submit" class="btn btn-primary" >Đăng ký ngay</button>
                </div>                       
            
        </div>
    </form>

    <footer class="footer bg-dark text-white"><h4 class="footer-font"> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>

</body>
<script src='./loginFirst.js'></script>
</html>