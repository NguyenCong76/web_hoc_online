<?php
session_start();
ob_start();
include("confid.php");
$p = new login();
include("mail/indexm.php");
$mail = new Mailer();
//var_dump($_SESSION);exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Xác nhận đăng ký</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    html,
    body {
      height: 100%;
    }
  </style>
</head>

<body>
  <div class="container-fluid w-100 p-5 h-100 bg-info">
    <div class="row justify-content-center align-items-center ">
      <div class="col-12 col-lg-9 col-xl-7">
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
          <div class="card-body p-4 p-md-3">

            <h3 class="text-center mb-3"> <span class="font-italic">Xác thực Email</span></h3>
            <hr>
            <form action="" method="POST">

              <div class=" row justify-content-center">
                <div class="col-md-5 mb-4">
                  <div class="form-outline">
                    <div class="input-group">
                      <input type="text" name="pass" class="form-control" placeholder="Nhập mã mà bạn nhận được">
                      <div class="input-group-append">
                        <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 mb-4">
                  <input type="submit" name="nut" id="nut" value="Xác nhận" class="btn btn-info">
                </div>
              </div>

              <div class="row justify-content-center">
                <div class="col-md-5">
                  <span class="text-danger "> <i>Mã xác thực chỉ hiệu lực trong 5 phút!</i></span>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  $code = $hoten = $user = $matkhau = $diachi = $gioitinh = $last_id = $namsinh = '';
  $code = $_SESSION['code'];
  if (!isset($_POST['pass'])) {

    $title = "Xác nhận email kích hoạt tài khoản.";
    $content = " Mã kích hoạt : " . $code . "";
    $email = $_SESSION['mail'];
    $mail->sendmail($title, $content, $email);
  }
  //// đoạn bấm nút xác nhận .
  if (isset($_POST['nut']))
    switch ($_POST['nut']) {
      case 'Xác nhận': {
          if (!isset($_COOKIE['xacnhan'])) {
            echo "<script>alert('Mã hiện không còn hiệu lực.')</script>";
            session_destroy();
            header("refresh:5;url=dang_ky.php");
          } else {
            if (isset($_POST['pass'])) {
              if ($_POST['pass'] != $_SESSION['code']) {

                echo "<script>alert('Mã xác kích hoạt không chính xác.')</script>";
              } else {

                $uni = rand(time(), 1000000000);
                $hoten = $_SESSION['hoten'];
                $user =  $_SESSION['mail'];
                $matkhau =  $_SESSION['mk'];
                $xnmatkhau = $_SESSION['rep'];
                $phone = $_SESSION['dt'];
                $diachi = $_SESSION['adr'];
                $gioitinh = $_SESSION['sex'];
                $namsinh = $_SESSION['ns'];
                $link = $p->connect();
                //INSERT INTO `hoc_sinh` (`ID_HS`, `Tên_HS`, `DC`, `Email`, `Giới tính`) VALUES
                // (NULL, 'hung', 'TX25', 'thaihung@gmail.com', 'Nam');
                $sql2 = "INSERT INTO `hoc_sinh` (`ID_HS`, `Tên_HS`, `DC`, `Email`,`dien_thoai`,`Giới tính`,`nam_sinh`) VALUES
                              (NULL, '$hoten', '$diachi', '$user','$phone', '$sex', '$namsinh')";
                //INSERT INTO `taikhoan` (`ID`, `ID_User`, `Email`, `Password`, `Dec`, `time_at`) VALUES 
                //(NULL, '4', 'thaihung@gmail.com', MD5('123'), '1', current_timestamp());

                if (mysqli_query($link, $sql2)) {
                  $last_id = mysqli_insert_id($link);
                  $sql1 = "INSERT INTO `taikhoan` (`ID`, `ID_User`, `Email`, `Password`, `Dec`, `time_at`,`unique_id`,`status`) VALUES 
                                (NULL, '$last_id', '$user', MD5('$matkhau'), '1', current_timestamp(),'$uni','Không hoạt động')";
                  if (mysqli_query($link, $sql1)) {
                    echo "<script>alert('kích hoạt tài khoản thành công.')</script>";
                    header("refresh:3;url=index.php");
                    setcookie('xacnhan', '123', time() - 300, "/");
                    session_destroy();
                  } else {
                    echo 'Đăng ký Thất bại!';
                    session_destroy();
                  }
                } else {
                  echo "<script>alert('kích hoạt tài khoản thất bại.')</script>";
                  exit();
                }
              }
            } else {
              echo "<script>alert('Bạn chưa điền mã kích hoạt tài khoản.')</script>";
            }
          }
        }
        break;
    }

  ?>
</body>

</html>