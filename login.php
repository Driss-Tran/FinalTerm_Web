<?php
include './connect.php';
$message = '';

if(isset($_POST["usr"]) && $_POST["usr"]==='admin') {
    $adminSql = "select username from login where username ='admin'";
    $result = mysqli_query($conn,$adminSql);
    if(!($result->fetch_assoc())){
        $admin_login = "insert into login(username,password,email,timeOutTryLog) values('admin','admin','admin@gmail.com',0)";
        mysqli_query($conn,$admin_login);
    }
    $_SESSION['admin'] = $_POST["usr"];
    $passAdmin = "select password from login where username = 'admin'";

    $result = mysqli_fetch_assoc(mysqli_query($conn,$passAdmin));
    if($result["password"] == $_POST["password"]) {
        header("location: ./admin.php");
    }
    else {
        $message = 'Vui lòng nhập lại';
    }
}
if (isset($_POST["usr"]) && $_POST["usr"]!=='admin') {
    $err = [];
    
    $username = $_POST["usr"];
    $password = $_POST["password"];
    
    $cpr_tk = "Select * from login where username = ?";

    $query = $conn ->prepare($cpr_tk);
    $query->bind_param("s",$username);
    $query->execute();
    $result = $query -> get_result();
    $data = $result -> fetch_assoc();

    if(!empty($data['password']))
    {
        $hashPassword=password_verify($password,$data['password']);
    }

    $time = time() - 60;
    $ip_address= getIP();
    $check_login = mysqli_fetch_assoc(mysqli_query($conn, "select count(*) as timeOut from login_tryLog where tryLog > $time"));
    $total = $check_login['timeOut'];

    $count_sql = "select timeOutTryLog from login where username = ?";
    $query_sql = $conn ->prepare($count_sql);
    $query_sql->bind_param("s",$username);
    $query_sql->execute();
    $result_count = $query_sql -> get_result();
    $count = $result_count -> fetch_assoc();

    $countTotal = '';
    
    if(isset($count['timeOutTryLog']))
    {
        $countTotal = $count['timeOutTryLog'];
    }
    if($result->num_rows == 0) {
            $message = 'Tài khoản của bạn chưa chính xác';
            $err["username"] = '-1';        
    }
    else if($total==3 && $countTotal==0){
        $message = 'Bạn đăng nhập sai quá nhiều lần vui lòng thử lại sau 1 phút.';
        mysqli_query($conn, "update login set timeOutTryLog = 1 where username = '$username'");
    }
    else if($total==3 && $countTotal==1){
        $message = 'Bạn đăng nhập sai quá nhiều lần vui lòng liên hệ quản trị viên để biết thêm chi tiết.';
        mysqli_query($conn, "update login set timeOutTryLog = 1 where username = '$username'");
        mysqli_query($conn, "update logup set confirm = 3 where id = '$idResult'");
    }
    else
    {
        $idSql = "select id from logup where email = (select email from login where username = '$username')";
        $id = mysqli_fetch_assoc(mysqli_query($conn, $idSql));
        $idResult = $id['id'];
        $sql = "select * from login where username = '$username'";
        $result = mysqli_query($conn,$sql);
        if(mysqli_num_rows($result) && $hashPassword){
            $message = ''; 
            mysqli_query($conn,"delete from login_tryLog where ipAddress = '$ip_address'");
            if(empty($err))
            {
                $_SESSION['usr']=$data['username'];
                $username = $_SESSION['usr'];
                $sql1 = "select confirm from logup where email = (select email from login where username = '$username')";
                $data=mysqli_query($conn,$sql1);
                $print=mysqli_fetch_assoc($data);
                mysqli_query($conn, "update login set timeOutTryLog = 0 where username = '$username'");
                if($print['confirm'] === "-1")
                {
                    $errorMessage = '<h3 class="text-danger text-center pt-5"> Tài khoản này đã bị vô hiệu hóa, vui lòng liên hệ tổng đài 18001008 </h3>';
                }
                else if($print['confirm'] === "3"){
                    $message = 'Bạn đăng nhập sai quá nhiều lần vui lòng liên hệ quản trị viên để biết thêm chi tiết';
                }
                else{
                    header('location: homePage.php');
                }
            }
        }
        else{
            $total++;
            $tryLogin = 3 - $total;
                if($tryLogin == 0 && $countTotal == 0){
                    $message = 'Bạn đăng nhập sai quá nhiều lần vui lòng thử lại sau 1 phút.';
                }
                else if($tryLogin==0 && $countTotal==1){
                    $message = 'Bạn đăng nhập sai quá nhiều lần vui lòng liên hệ quản trị viên để biết thêm chi tiết.';
                    mysqli_query($conn, "update login set timeOutTryLog = 1 where username = '$username'");
                    mysqli_query($conn, "update logup set confirm = 3 where id = $idResult");
                }
                else if($tryLogin>0){
                    $message = "Bạn đã đăng nhập sai. Còn lại $tryLogin lần. Vui lòng nhập lại";
                }
           
            
            $tryLog = time();
            mysqli_query($conn,"insert into login_tryLog(ipAddress,tryLog) values('$ip_address','$tryLog')");
            
            
        }
        
        
    }

}
function getIP(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
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
    <title>Trang đăng nhập</title>
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark ">
        <a class="navbar-brand" href="./index.php">
            <i class="fa fa-building"></i>
            <h1 class="navbar-symbol">PPS bank</h1>
        </a>
        <ul class="navbar-nav menuItems mb-3">
            <li class="nav-item">
                <a class="nav-link login active" href="./login.php">Đăng nhập</a>
            </li>
            <li class="nav-item">
                <a class="nav-link signup" href="./register.php">Đăng kí</a>
            </li>
        </ul>
        <i class="fa fa-bars text-white menu-icon" onclick="Handle()"></i>
    </nav>
    <form action="login.php" method="POST" role="form">

        <div class="container w-100">
            <h4 class="text-center mt-5">Form đăng nhập</h4>

            <div class="form-group input-items">
                <label for="usr" class="usr" style="cursor: pointer;">UserName</label>
                <input name="usr" id="usr" type="text" class="form-control w-100" placeholder="User-name" />
                <!-- <div class="has-error">
                    <span class="text-danger"><?php // echo(isset($err['$username']))?$err['$username']:"" 
                                                ?></span>
                </div> -->
            </div>

            <div class="form-group input-items">
                <label for="pwd" class="usr" style="cursor: pointer;">Password</label>
                <input name="password" id="pwd" type="password" class="form-control w-100" placeholder="Password" />

            </div>

            <div class="custom-control custom-checkbox mb-3 ">
                <input type="checkbox" class="custom-control-input" id="customCheck" name="rmr-me">
                <label class="custom-control-label" for="customCheck">Remember me</label>
            </div>
            <div class="has-error">
                <span class="text-danger"><?php echo (isset($message)) ? $message : "" ?></span>
                <span class="text-danger"><?php echo (isset($errorMessage)) ? $errorMessage : "" ?></span>
            </div>
            <div class="form-group input-items">
                <button type="submit" name="login" class="btn btn-primary mr-4">Đăng nhập</button>
                <button type="button" class="btn btn-secondary"><a href="./register.php" class="text-white text-decoration-none">Tạo tài khoản</a></button>
            </div>
        </div>
    </form>
    <footer class="footer bg-dark text-white mt-5">
        <h4 class="footer-font"> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4>
    </footer>
</body>
    <script src="./main.js"></script>
</html>


