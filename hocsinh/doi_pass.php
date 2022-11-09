<?php
session_start();
ob_start();
if(isset($_SESSION['user']) && isset($_SESSION['pass'])&& isset($_SESSION['id_user']) && isset($_SESSION['ss'])&& isset($_SESSION['hs']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_hs($_SESSION['id_user'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['ss']);
 }
 //nếu là giáo viên 
 else if(isset($_SESSION['id'])&&isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['ss']) && isset($_SESSION['gv']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_gv($_SESSION['id'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['ss']);
 }
 else
 {
  header('location:../index.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Đổi mật khẩu người dùng</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<h3><a href="danh_sach_khoa_hoc.php">Trở về</a></h3>
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>Đổi mật khẩu</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Vui lòng điền mật khẩu hiện tại trước khi thay đổi mật khẩu mới!</p>
      <form action="" method="post">
      <div class="input-group mb-3">
          <input type="password"  name="oldpass" class="form-control" placeholder="Mật khẩu hiện tại">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password"  name="newpass" class="form-control" placeholder="Mật khẩu mới">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="cofpass" class="form-control" placeholder="Xác nhận mật khẩu mới">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" name="nut" value="Cập nhật" >Lưu</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <?php
    $old=$new=$conf='';
    $ten=$_SESSION['user'];
    //lấy pass trên db xuống để so sánh
    $pass=$p->laycot($p->connect(),"SELECT Password FROM `taikhoan` WHERE Email ='$ten'");
    //echo $pass;exit();
    if(isset($_POST['nut']))
    switch($_POST['nut'])
    {
        case'Cập nhật':
            {
              //print_r($_POST);
              $old=$_POST['oldpass'];
              $new=$_POST['newpass'];
              $conf=$_POST['cofpass'];
              if(empty($old)||empty($new)||empty($conf)){
                echo"<script>alert('Vui lòng không để trống.')</script>";
              }
              else
              {
                if(md5($old)!=$pass)
                {
                    echo"<script>alert('Mật khẩu cũ không đúng.')</script>";
                   
                }
                else 
                {      //Kiểm tra xem nhập pass cũ đúng ko ?
                        if($new!=$conf)
                    {
                        echo"<script>alert('Mật khẩu xác nhận không đúng với mật khẩu mới.')</script>";
                    }
                    else
                    { //Thực hiện thay đổi pass
                        $sql="UPDATE `taikhoan` SET `Password` = MD5('$new') WHERE Email ='$ten'";
                        if(mysqli_query($p->connect(),$sql))
                        {
                            
                            echo"<script>alert('Đã cập nhật mật khẩu thành công.')</script>";
                            session_destroy();
                        }
                        else
                         {
                            echo"<script>alert('Thay đổi mật khẩu thất bại.')</script>";
                         }
                    }
                }
              }
            }break;
    }
    ?>
      <p class="mt-3 mb-1">
        <a href="../login.php">Đăng nhập</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>