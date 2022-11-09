<?php
include("mail/quenpass.php");
$mail=new QUENPASS();
include("confid.php");
$q=new login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cấp lại mật khẩu</title>

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
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="#" class="h1"><b>E_learning</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Bạn không nhớ mật khẩu? Chúng tôi sẽ giúp đỡ bạn.</p>
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Nhập vào email tài khoản!">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" name="nut" class="btn btn-primary btn-block">Hỗ trợ</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <?php
    $t=$t1=$email='';
    if(isset($_POST['nut']))
    {  
        $email=$_POST['email'];
        $email_mh= Base64_encode(serialize($email));
        if(empty($email))
      {
        echo"<script>alert('Bạn chưa nhập Email.')</script>";
     }
     else{
        
      $sql1="SELECT ID_HS FROM `hoc_sinh` WHERE Email='$email'"; 
      $sql2="SELECT ID_GV FROM `giao_vien` WHERE lienhe='$email_mh'";
      $t=$q->laycot($q->connect(),$sql1);//học sinh
      $t1=$q->laycot($q->connect(),$sql2);//giáo viên 
             if(!empty($t))//dành cho học sinh
            {
                $code=rand(1,999999);
                $sql="UPDATE `taikhoan` SET `Password` = MD5($code) WHERE Email ='$email'";
                if(mysqli_query($q->connect(),$sql)){
                $title="Email cung cấp mật khẩu đăng nhập hệ thống. ";
                $content=" Mật khẩu đăng nhập : ".$code."";
                $mail->quenmk($title,$content,$email);
                }else{
                  echo"<script>alert('Cấp mật khẩu thất bại.')</script>";
                }
            }
           else if(!empty($t1))//dành cho giáo viên
            {
                $code1=rand(1,999999);
                $sql="UPDATE `taikhoan` SET `Password` = MD5($code1) WHERE ID_User ='$t1' AND `Dec`='2'";
                if(mysqli_query($q->connect(),$sql)){
                $title1="Email cung cấp mật khẩu đăng nhập hệ thống. ";
                $content1=" Mật khẩu đăng nhập : ".$code1."";
                $mail->quenmk($title1,$content1,$email);
                }else{
                  echo"<script>alert('Cấp mật khẩu thất bại.')</script>";
                }
            }
            else{
              echo"<script>alert('Email chưa được đăng ký tài khoản.')</script>";
            }
     }
    }
    ?>
      <p class="mt-3 mb-1">
        <a href="login.php">Đăng nhập</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>

