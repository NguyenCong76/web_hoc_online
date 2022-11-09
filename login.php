<?php
ob_start();
session_start();
include("confid.php");
 $p= new login();

?>

 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ĐĂNG NHẬP HỆ THỐNG</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>E_learning</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Đăng nhập để bắt đầu </p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="txtuser" class="form-control" placeholder="Địa chỉ Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="txtpass" class="form-control" placeholder="Mật khẩu">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <img src="captcha.php" title="" alt="" width="300px"; height="auto"; /></th>
        </div>
        <div class="input-group mb-3">
        <input type="text" name="input" class="form-control" placeholder="Nhập lại những chữ số trên hình">
        <div class="input-group-append">
            <div class="input-group-text">
            <span class="fas fa-image"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-7">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Ghi nhớ tôi
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-5">
            <button type="submit" name="nut" id="nut" class="btn btn-primary btn-block" value="Sign in">Đăng nhập</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="hocsinh/login_gg.php" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot.php">Tôi quên mật khẩu ?</a>
      </p>
      <p class="mb-0">
        <a href="dang_ky.php" class="text-center">Đăng ký thành viên</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->
<?php
    if(isset($_POST['nut']))
    switch($_POST['nut'])
    {
        case'Sign in':
            {
                $user=$_REQUEST['txtuser'];
                $pass=$_REQUEST['txtpass'];
                $input = $_REQUEST['input'];
               if($user!=''&& $pass!=''&& $input!='')
                {
                    if($p->login_user($user,$pass)==1 && $input == $_SESSION['captcha'])
                    {
                        $_SESSION['hs']=1;
                       // echo 'học sinh';
                       //UPDATE `taikhoan` SET `status` = 'Đang hoạt động' WHERE `taikhoan`.`ID` = 22;
                       $sql="UPDATE `taikhoan` SET `status` = 'Đang hoạt động' WHERE `taikhoan`.`Email` ='$user'";
                       if(mysqli_query($p->connect(),$sql)){
                       header("location:hocsinh/index.php");
                       }
                    }
                    elseif($p->login_user($user,$pass)==2 && $input == $_SESSION['captcha'])
                    {
                        $_SESSION['gv']=2;
                        //echo 'giáo viên';
                        $sql="UPDATE `taikhoan` SET `status` = 'Đang hoạt động' WHERE `taikhoan`.`Email` ='$user'";
                       if(mysqli_query($p->connect(),$sql)){
                        header("location:giaovien/index.php");
                       }
                    }
                    elseif($p->login_user($user,$pass)==3 && $input == $_SESSION['captcha'])
                    {
                        //echo' Admin';
                        $sql="UPDATE `taikhoan` SET `status` = 'Đang hoạt động' WHERE `taikhoan`.`Email` ='$user'";
                       if(mysqli_query($p->connect(),$sql)){
                        header("location:admin/index.php");
                       }
                    }else
                    {
                        echo"<script>alert('Nhập chưa đúng thông tin.')</script>";
                    }

                }
                else{
                    echo"<script>alert('Thông tin nhập chưa đầy đủ.')</script>";
                }
            }break;

    }
?>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
