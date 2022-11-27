<?php
include './connect.php';
if (!isset($_SESSION['usr'])) {
  header('Location: login.php');
  die();
}
  $username = $_SESSION['usr'];
  $sql = "select username from logup where email = (select email from login where username = '$username')";
  $temp = mysqli_fetch_assoc(mysqli_query($conn, $sql));
  $userName = $temp['username'];

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
  <title>Trang chủ</title>
</head>

<body>
  <nav class='navbar navbar-expand-sm bg-dark navbar-dark'>
    <a class='navbar-brand' href='#'>
      <h1 class='navbar-symbol'> <i class='fa fa-building mr-2'></i>PPS bank</h1>
    </a>

    <ul class='navbar-nav menuItems'>
      <li class='nav-item'>
        <a class='nav-link' href='./userInfo.php'>Chào,
          <?= $userName ?>
        </a>
      </li>
      <li class='nav-item dropdown'>
        <a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>
          Xem Thêm
        </a>
        <div class='dropdown-menu '>
          <?php
              $username1 = $_SESSION['usr'];
              $sql1 = "select confirm from logup where email = (select email from login where username = '$username1')";
              $data = mysqli_query($conn, $sql1);
              $print = mysqli_fetch_assoc($data);
              if($print['confirm'] === '-1')
              {
                header('locaton: ./login.php');
              }
              if ($print['confirm'] === '0') {
          ?>
            <a class='dropdown-item' href='./userInfo.php'>Thông tin khách hàng</a>
            <a class='dropdown-item' href='#'>Đổi mật khẩu</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#moneyTransfer'>Nạp tiền</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#moneyTransfer'>Chuyển tiền</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#moneyTransfer'>Rút tiền</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#moneyTransfer'>Lịch sử giao dịch</a>
          <?php
              }
          elseif($print['confirm'] === '2')
          {
          ?>
             <a class='dropdown-item' href='./userInfo.php'>Thông tin khách hàng</a>
            <a class='dropdown-item' href='#'>Đổi mật khẩu</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#updateInfo'>Nạp tiền</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#updateInfo'>Chuyển tiền</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#updateInfo'>Rút tiền</a>
            <a class='dropdown-item' href='#' data-toggle='modal' data-target='#updateInfo'>Lịch sử giao dịch</a>
          <?php
          }
          else if ($print['confirm'] === '1')
          {
            ?>
              <a class='dropdown-item' href='./userInfo.php'>Thông tin khách hàng</a>
              <a class='dropdown-item' href='./changePass.php'>Đổi mật khẩu</a>
              <a class='dropdown-item' href='./moneyTransfer.php'>Nạp tiền</a>
              <a class='dropdown-item' href='./withdrawMoney.php'>Rút tiền</a>
              <a class='dropdown-item' href='./ChuyenTien.php'>Chuyển tiền</a>
              <a class='dropdown-item' href='./historyTransfer.php'>Lịch sử giao dịch</a>
            <?php
              }
            ?>

        </div>
      </li>
      <li class='nav-item active'>
        <a class='nav-link' href='logout.php'>Đăng xuất</a>
      </li>
    </ul>
    <i class='fa fa-bars text-white menu-icon' onclick='Handle()'></i>

  </nav>
  <div class='container'>
    <div class='row'>
      <div class='card col-xl-4 col-lg-4 col-md-6 col-sm-12 border-0 mb-3'>
        <div class='card-header bg-white border-0'>
          <h1>
            Danh sách
          </h1>
        </div>

        <div class='card-footer text-primary border'>
          <a href='./userInfo.php' class='text-decoration-none'>Thông tin tài khoản</a>
        </div>
        <?php
        if ($print['confirm'] === '0') {
        ?>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none' data-toggle='modal' data-target='#moneyTransfer'>Nạp tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none' data-toggle='modal' data-target='#moneyTransfer'>Chuyển tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none' data-toggle='modal' data-target='#moneyTransfer'>Rút tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none ' data-toggle='modal' data-target='#moneyTransfer'>Lịch sử giao
              dịch</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none ' data-toggle='modal' data-target='#moneyTransfer'>Mua thẻ điện thoại</a>
          </div>
        <?php
        } else if ($print['confirm'] === '1') {

        ?>
          <div class='card-footer text-primary border'>
            <a href='moneyTransfer.php' class='text-decoration-none'>Nạp tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='./ChuyenTien.php' class='text-decoration-none'>Chuyển tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='./withdrawMoney.php' class='text-decoration-none'>Rút tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='./historyTransfer.php' class='text-decoration-none '>Lịch sử giao
              dịch</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='./buyPhoneCard.php' class='text-decoration-none '>Mua thẻ điện thoại</a>
          </div>
          <?php
        }
        if ($print['confirm'] === '2') {
          if (isset($_POST['img-id-first'])) {
            $CMNDbefore = $_POST['img-id-first'];
            $CMNDafter = $_POST['img-id-after'];
            $sql_CMNDbefore = "update logup  set CMNDbefore = '$CMNDbefore' where email = (select email from login where username = '$username')";
            $sql_CMNDafter = "update logup  set CMNDafter = '$CMNDafter' where email = (select email from login where username = '$username')";
            $confirm = "update logup  set confirm = 0 where email = (select email from login where username = '$username')";
            $query_CMNDbefore = mysqli_query($conn, $sql_CMNDbefore);
            $query_CMNDafter = mysqli_query($conn, $sql_CMNDafter);
            $query_confirm = mysqli_query($conn, $confirm);
            echo "<div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none' data-toggle='modal' data-target='#moneyTransfer'>Nạp tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none' data-toggle='modal' data-target='#moneyTransfer'>Chuyển tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none' data-toggle='modal' data-target='#moneyTransfer'>Rút tiền</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none ' data-toggle='modal' data-target='#moneyTransfer'>Lịch sử giao
              dịch</a>
          </div>
          <div class='card-footer text-primary border'>
            <a href='#' class='text-decoration-none ' data-toggle='modal' data-target='#moneyTransfer'>Mua thẻ điện thoại</a>
          </div>";
          } 
          else {

          ?>
            <div class='card-footer text-primary border'>
              <a href='./moneyTransfer.php' class='text-decoration-none' data-toggle='modal' data-target='#updateInfo'>Nạp tiền</a>
            </div>
            <div class='card-footer text-primary border'>
              <a href='./ChuyenTien.php' class='text-decoration-none' data-toggle='modal' data-target='#updateInfo'>Chuyển tiền</a>
            </div>
            <div class='card-footer text-primary border'>
              <a href='./ChuyenTien.php' class='text-decoration-none' data-toggle='modal' data-target='#updateInfo'>Rút tiền</a>
            </div>
            <div class='card-footer text-primary border'>
              <a href='#' class='text-decoration-none ' data-toggle='modal' data-target='#updateInfo'>Lịch sử giao
                dịch</a>
            </div>

            <div class='card-footer text-primary border'>
              <a href='#' class='text-decoration-none ' data-toggle='modal' data-target='#updateInfo'>Mua thẻ điện thoại</a>
            </div>
        <?php
          }
        }
        ?>

      </div>

      <div class='img container col-xl-8 col-lg-8 col-md-6 col-sm-12 '>
        <div class='row'>
          <div class='col-xl-12 col-lg-12 mt-5 mb-3'>
            <div id='demo' class='carousel slide' data-ride='carousel'>

              <ul class='carousel-indicators'>
                <li data-target='#demo' data-slide-to='0' class='active'></li>
                <li data-target='#demo' data-slide-to='1'></li>
                <li data-target='#demo' data-slide-to='2'></li>
              </ul>

              <div class='carousel-inner'>
                <div class='carousel-item active'>
                  <img src='./img/1.jpg' class='w-100'>
                </div>
                <div class='carousel-item'>
                  <img src='./img/2.jpg' class='w-100'>
                </div>
                <div class='carousel-item'>
                  <img src='./img/3.png' class='w-100'>
                </div>
              </div>
              <a class='carousel-control-prev' href='#demo' data-slide='prev'>
                <span class='carousel-control-prev-icon bg-dark'></span>
              </a>
              <a class='carousel-control-next' href='#demo' data-slide='next'>
                <span class='carousel-control-next-icon bg-dark'></span>
              </a>



            </div>

          </div>



          <div class=' col-xl-6 col-lg-6 col-sm-12 col-md-12 mb-3'>
            <div class='card text-center rounded card-info'>
              <div class='card-img-top bg-light'>
                <br>
                <br>
                <img src='./img/3.jpg' class='img-responsive w-100'>
                <br>
                <br>
              </div>
              <div class='card-body  text-left'>
                <h3 class='text-primary card-header bg-white border-0 px-0'>
                  Thông tin tài chính hôm nay</h3>
                <h5 class='card-title'>Từ : Ngân hàng thế giới </h5>
                <p class='card-text text-left '>Hôm nay, SSI research đánh giá việc các ngân hàng thương mại
                  tăng lãi suất huy động thời gian gần đây chỉ là xu hướng mang tính mùa vụ và mặt bằng lãi suất dự
                  báo sẽ hạ nhiệt sau đó. Song, các chuyên gia cho rằng áp lực lạm phát sẽ tăng mạnh trong nửa cuối năm
                  nay và kì vọng lãi suất sẽ chạm đáy trong năm nay.
                </p>
              </div>
            </div>
          </div>

          <div class=' col-xl-6 col-lg-6 col-sm-6 col-md-6 mb-3'>
            <div class='card text-center rounded card-info'>
              <div class='card-img-top bg-light'>
                <br>
                <br>
                <img src='./img/4.jpg' class='img-responsive w-100'>

                <br>
                <br>
              </div>
              <div class='card-body  text-left'>
                <h3 class='text-primary card-header bg-white border-0 px-0'>
                  Thị trường ngoại hối biến động</h3>
                <h5 class='card-title'>Từ : Cục chứng khoán quốc gia</h5>
                <p class='card-text text-left '>Trong tuần này, bộ tứ ngân hàng trung ương quyền lực nhất thế giới sẽ tổ chức cuộc
                  họp chính sách cuối cùng của năm 2021, trong bối cảnh lạm phát tăng vọt và biến chủng Omicron lan rộng.</p>
              </div>
            </div>
          </div>

          <div class=' col-xl-6 col-lg-6 col-sm-6 col-md-6 mb-3'>
            <div class='card text-center rounded card-info'>
              <div class='card-img-top bg-light'>
                <br>
                <br>
                <img src='./img/5.jpg' class='img-responsive w-100'>

                <br>
                <br>
              </div>
              <div class='card-body  text-left'>
                <h3 class='text-primary card-header bg-white border-0 px-0'>
                  Lãi suất ưu đãi khi gửi tiết kiệm</h3>
                <h5 class='card-title'>Từ : Ngân hàng PPS</h5>
                <p class='card-text text-left '>Thông tin về lãi suất tiền gửi không kỳ hạn, lãi suất tiền gửi tiết kiệm,
                  tiền gửi có kỳ hạn, lãi suất trực tuyến, lãi suất cho vay tại SCB.</p>
              </div>
            </div>
          </div>

          <div class=' col-xl-6 col-lg-6 col-sm-6 col-md-6'>
            <div class='card text-center rounded card-info'>
              <div class='card-img-top bg-light'>
                <br>
                <br>
                <img src='./img/6.jpg' class='img-responsive w-100'>

                <br>
                <br>
              </div>
              <div class='card-body  text-left'>
                <h3 class='text-primary card-header bg-white border-0 px-0'>
                  Thực hiện chuyển đổi số 2022</h3>
                <h5 class='card-title'>Từ : Ngân hàng PPS</h5>
                <p class='card-text text-left '>Chuyển đổi số là một trong những mục tiêu được quan tâm hàng đầu của các
                  doanh nghiệp công nghệ tại Việt Nam. Chính phủ Việt nam cũng đặc biệt quan tâm đến vấn để chuyển đổi số
                  trong cuộc cách mạng công nghiệp 4.0 và giao cho Bộ Thông tin &Truyền thông xây dựng Đề án Chuyển đổi số
                  quốc gia và trình Đề án cho Thủ tướng ngay trong năm.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
  <div class='modal fade' id='moneyTransfer' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title'>Thông báo</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>&times;</button>
        </div>

        <div class='modal-body'>
          <h3>Bạn đang chờ xác nhận để sử dụng chức năng này</h3>
          <div class='modal-footer'>
            <div class='form-group'>
              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>

  <div class='modal fade' id='updateInfo' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
    <div class='modal-dialog' role='document'>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title'>Thông báo</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>&times;</button>
        </div>

        <div class='modal-body'>
                    <form class ="updateForm" method = "POST">
                    <h4 class="text-center text-danger mt-5">Bạn cần upload lại CMND để tiếp tục</h4>
                    <div class="form-group">
                    <label for="file" style="cursor: pointer;">Upload CMND mặt trước</label> 
                    <input type="file"  class="form-control-file" id="file" name="img-id-first" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="file" style="cursor: pointer;">Upload CMND mặt sau</label>
                        <input type="file" class="form-control-file" id="file" name="img-id-after" accept="image/*">
                    </div>
                  
                  <div class='modal-footer'>
                    <div class='form-group'>
                          <button type="submit" class="btn btn-primary">Submit</button>
                          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                    </div>
                  </div>
          </form>
        </div>
      </div>
    </div>
  </div>



  <footer class='footer bg-dark text-white mt-3'>
    <h4 class='footer-font'> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4>
  </footer>
</body>
<script src="./main.js"></script>

</html>