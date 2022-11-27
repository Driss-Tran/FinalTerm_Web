<?php
$_SERVER["DOCUMENT_ROOT"]."/connect.php";

// include './connect.php';
    if(isset($_POST['user-name']))
    {
        $username=$_POST["user-name"];
        $email=$_POST["email"];
        $address=$_POST["address"];
        $birthday=$_POST["birthday"];
        $phone=$_POST["phone"];
        $CMNDbefore = $_POST["img-id-first"];
        $CMNDafter = $_POST["img-id-after"];
        $confirm = 0;
        $error=[];
        if($username === 'admin'){
            $error['username']="Bạn không thể tạo tài khoản này";
        }
        if(empty($username))
        {
            $error['username']="Bạn chưa nhập họ và tên";
        }
        if(empty($email))
        {
            $error['email']="Bạn chưa nhập email";
        }

        if(empty($address))
        {
            $error['address']="Bạn chưa nhập địa chỉ";
        }

        if(empty($phone))
        {
            $error['phone']="Bạn chưa nhập số đIện thoại";
        }

        if(empty($birthday))
        {
            $error['birthday']="Bạn chưa nhập ngày tháng năm sinh";
        }

        if(empty($CMNDbefore))
        {
            $error['CMNDbefore']="Vui lòng tải ảnh CMND mặt trước";
        }

        if(empty($CMNDafter))
        {
            $error['CMNDafter']="Vui lòng tải ảnh CMND mặt sau";
        }
        if(strlen($phone)!=10 ){
            $error['phone']='Số điện thoại này không hợp lệ'; 
        }
        $mail="Select * from logup where email='$email'";
        $query_email=mysqli_query($conn,$mail);
        $check_email=mysqli_num_rows($query_email);
        
        $phoneSql="Select * from logup where phone='$phone'";
        $query_phone=mysqli_query($conn,$phoneSql);
        $check_phone=mysqli_num_rows($query_phone);

        if($check_phone!=0){
            $error['phone']='Số điện thoại này đã được đăng ký'; 
        }
        if($check_email!=0)
        {
            $error['email']='Email này đã được đăng ký'; 
        }

        if(empty($error))
        {
            $sql = "Insert into logup(username,address,email,phone,Birthday,Cmndbefore,CmndAfter,confirm,moneyremaining) Values('$username','$address','$email','$phone','$birthday','$CMNDbefore','$CMNDafter','$confirm',0)";
            mysqli_query($conn,$sql);
            $mail="Select * from logup where email='$email'";
            $query_email=mysqli_query($conn,$mail);
            $data=mysqli_fetch_assoc($query_email);
            $_SESSION['email']=$data['email'];
            $tk=rand(0000000000,9999999999);
            $mk=substr(str_shuffle('abcdefgfhtytrfewdqwdafasfasfadfdafdasfds'), 0, 6);
            $cpr_tk="Select * from login where username = '$tk'";
            $query_tk=mysqli_query($conn,$cpr_tk);  
            $check_tk=mysqli_num_rows($query_tk);
            while($check_tk!=0)
            {
                if($check_tk == 1)
                {
                    $tk=rand(0000000000,9999999999);
                    
                }
            }   
            $sql1 = "Insert into login(username,password,email,timeOutTryLog) Values('$tk','$mk','$email',0)";
            mysqli_query($conn,$sql1); 
            $cpr="Select * from login where username=$tk";
            $query_users=mysqli_query($conn,$cpr);
            $data1=mysqli_fetch_assoc($query_users);
            send_account($_SESSION['email'],$data1['username'],$data1['password']);
            echo $_SESSION['tk'] ,  $_SESSION['mk'];
            header('location: loginFirst.php');    
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
    <title>Trang đăng kí</title>
</head>
<body>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
                <a class="navbar-brand" href="./index.php">
                    <i class="fa fa-building"></i>
                    <h1 class="navbar-symbol">PPS bank</h1>
                </a>             
                <ul class="navbar-nav menuItems mb-3">
                  <li class="nav-item">
                    <a class="nav-link login" href="./login.php">Đăng nhập</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link signup active" href="#">Đăng kí</a>
                  </li>
                </ul>
                <i class="fa fa-bars text-white menu-icon" onclick="Handle()"></i>
            </nav>
    
      <form class="formRegister" action="register.php" method="POST" role="form" onsubmit="sendMail();reset();return false;">
            <div class="container w-100">
            <h2 class="text-center">Đăng ký thành viên mới </h2>
            <div class="form-group">
                <i class="fa fa-user"></i>
                <label for="usr" style="cursor: pointer;">Họ và tên <span style="color:red;">(*)</span></label>
                <input name="user-name" id="usr" type="text" class="form-control w-100">
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['username']))?$error['username']:"" ?></span>
                </div>
            </div>

            <div class="form-group">
                <i class="fa fa-envelope"></i>
                <label for="email" style="cursor: pointer;">Email <span style="color:red;">(*)</span></label>
                <input name="email" id="email" type="email" class="form-control w-100">
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['email']))?$error['email']:"" ?></span>
                </div>
            </div>

            <div class="form-group">
                <i class="fa fa-city"></i>
                <label for="address" style="cursor: pointer;">Địa chỉ <span style="color:red;">(*)</span></label>
                <input name="address" id="address" type="text" class="form-control w-100">
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['address']))?$error['address']:"" ?></span>
                </div>
            </div>

            <div class="form-group">
                <i class="fa fa-calendar"></i>
                <label for="birthday" style="cursor: pointer;">Ngày tháng năm sinh <span style="color:red;">(*)</span></label>
                <input name="birthday" id="birthday" type="date" class="form-control w-100">
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['birthday']))?$error['birthday']:"" ?></span>
                </div>
            </div>

            <div class="form-group">
                <i class="fa fa-phone"></i>
                <label for="phone" style="cursor: pointer;">Số điện thoại <span style="color:red;">(*)</span></label>
                <input type="number" id="phone" name="phone" class="form-control w-100" required>
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['phone']))?$error['phone']:"" ?></span>
                </div>
            </div>

            <div class="form-group">
                <i class="fa fa-image"></i>
                <label for="file" style="cursor: pointer;">Upload CMND mặt trước</label>
                <input type="file" class="form-control-file" id="file" name="img-id-first" accept="image/*">
                </script>
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['CMNDbefore']))?$error['CMNDbefore']:"" ?></span>
                </div>
            </div>

            <div class="form-group">
                <i class="fa fa-image"></i>
                <label for="file" style="cursor: pointer;">Upload CMND mặt sau</label>
                <input type="file" class="form-control-file" id="file" name="img-id-after" accept="image/*">
                <div class="has-error">
                    <span class="text-danger"> <?php echo(isset($error['CMNDafter']))?$error['CMNDafter']:"" ?></span>
                </div>
            </div>
                <div class="form-group button-form">
                    <button type="submit" class="btn btn_custom" id="btn" >Đăng ký ngay</button>
                    <h4>Đã có tài khoản ? Hãy <a href="./login.php">Đăng nhập</a> </h4>
                </div>
                
        </div>
    </form>
    <footer class="footer bg-dark text-white"><h4 class="footer-font"> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>
</body>

<script src="./main.js"></script>

    
</html>