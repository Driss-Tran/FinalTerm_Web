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
                <a class="nav-link signup" href="./register.php">Đăng kí</a>
            </li>
        </ul>
        <i class="fa fa-bars text-white menu-icon" onclick="Handle()"></i>
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
              <a href='./userInfo.php' class='text-decoration-none' data-toggle='modal' data-target='#info'>Thông tin tài khoản</a>
            </div>
            <div class='card-footer text-primary border'>
              <a href='./moneyTransfer.php' class='text-decoration-none' data-toggle='modal' data-target='#info'>Chuyển tiền</a>
            </div>
            <div class='card-footer text-primary border'>
              <a href='./historyTransfer.php' class='text-decoration-none' data-toggle='modal' data-target='#info'>Lịch sử giao dịch</a>
            </div>
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

      <div class='modal fade' id='info' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
              <div class='modal-dialog' role='document'>
                <div class='modal-content'>
                  <div class='modal-header'>
                    <h5 class='modal-title'>Thông báo</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>&times;</button>
                  </div>
        
                  <div class='modal-body'>
                    <h3>Bạn cần phải đăng nhập để sử dụng chức năng này</h3>
                    <div class='modal-footer'>
                      <div class='form-group'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Đóng</button>
                      </div>
        
                    </div>
        
                  </div>
        
                </div>
              </div>
        </div>
      <footer class='footer bg-dark text-white mt-3'><h4 class='footer-font'> ©Bản quyền thuộc về Phát - Phúc - Sơn</h4></footer>
      

</body>
<script src="./main.js"></script>

</html>