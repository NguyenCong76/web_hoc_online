<?php
session_start();
ob_start();
if(isset($_SESSION['id'])&&isset($_SESSION['user']) && isset($_SESSION['pass'])&& isset($_SESSION['id_user']) && isset($_SESSION['ss']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_admin($_SESSION['id'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['id_user'],$_SESSION['ss']);
 }
 else
 {
  header('location:../index.php');
 }
 include("../includes/sql.php");
 $q=new sql();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấp tài khoản giáo viên</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body>
<div class="card-body">
      <p class="login-box-msg">Cấp tài khoản:</p>
    <form method="POST" action="" enctype="multipart/form-data">
    <div class="input-group mb-3">
          <input type="text" name="txtten" id="txtten" class="form-control" placeholder="Họ và tên">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email"  name="txtuser" id="txtuser" class="form-control" placeholder="Tên đăng nhập // ví dụ : abc@gmail.com">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email"  name="txtemail" id="txtuser" class="form-control" placeholder="Địa chỉ email liên lạc">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
            <input type="text" name="txtphone" id="txtphone" class="form-control" placeholder=" Số điện thoại">
            <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-phone"></span>
            </div>
          </div>
          </div>
        <div class="input-group mb-3">
          <input type="password" name="txtpass" id="txtpass" class="form-control" placeholder="Mật khẩu">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="txtconfpass" id="txtconfpass"  class="form-control" placeholder="Nhập lại mật khẩu">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="txtadr" id="txtadr" class="form-control" placeholder="Địa chỉ hiện tại">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-plane"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
                    <select class="custom-select" name="sex" id="">
                        <option value="">Chọn giới tính</option>
                        <option value="Nam">NAM</option>
                        <option value="Nu">NỮ</option>
                    </select>     
                    <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="file" name="file" class="form-control" placeholder="Ảnh đại diện">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-image"></span>
            </div>
          </div>
        </div>
        <div class="row">
        <div class="col-4">
            <button type="submit" id="dk" name="dk" class="btn btn-primary btn-block">Đăng ký</button>
        </div>
            <div class="col-4">
            <button type="reset" class="btn btn-danger btn-block">Hủy</button>
        </div>
        </div>
    <?php
    
    if(isset($_POST['dk']))
    {
      $name=$_FILES['file']['name'];
      $type=$_FILES['file']['type'];
      $size=$_FILES['file']['size'];
      $tmp_name=$_FILES['file']['tmp_name'];
      $q->upload($name,$tmp_name,'hinh');

      $hinh=$name;    
      $user=$_POST['txtuser'];
      $pass=$_POST['txtpass'];
      $email=$_POST['txtemail'];
      $ten=$_POST['txtten'];
      $dc=$_POST['txtadr'];
      $phone=$_POST['txtphone'];
      $sex=$_POST['sex'];
          if((empty($email)||empty($ten)||empty($sex)||empty($user)||empty($dc)||empty($pass)|| $pass!=$_POST['txtconfpass']))
          {
  
            echo"<script>alert('Vui lòng kiểm tra lại thông tin nhập chính xác.')</script>";
              
          }else{
            $ll=Base64_encode(serialize($email));
            $sql="INSERT INTO `giao_vien` (`ID_GV`, `Ten_GV`, `DC`, `Phone`, `Email`, `Giới tính`, `lienhe`) 
            VALUES (NULL, '$ten', '$dc', '$phone', '$user', '$sex','$ll')";
            $link=$p->connect();
            //var_dump($_POST);exit();
            if(mysqli_query($link,$sql))
            {
                $last_id = mysqli_insert_id($link);
                $sql1="INSERT INTO `taikhoan` (`ID`, `ID_User`, `Email`, `Password`, `Dec`, `time_at`, `image`, `status`, `unique_id`, `token`) 
                VALUES (NULL, '$last_id', '$user',md5($pass), '2', current_timestamp(), '$name', 'Không hoạt động', '', '')";
                if(mysqli_query($link,$sql1))
                {
                    include("../mail/cap_tk_gv.php");
                    $mail=new Mailer();
                    $title="Cung cấp tài khoản cho khách hàng :$ten.";
                    $content="Tên đăng nhập: $user <br> Mật khẩu: $pass";
                    $mail->sendmail_gv($title,$content,$email); 
                     header("refresh:3;url=page_admin.php");
                }else{
                    mysqli_query($link,"DELETE FROM `giao_vien` WHERE `giao_vien`.`ID_GV` ='$last_id'");
                }
            }else{
                echo"<script>alert('Tạo tài khoản thất bại.')</script>";
            }

          }
  }
  //INSERT INTO `giao_vien` (`ID_GV`, `Ten_GV`, `DC`, `Phone`, `Email`, `Giới tính`, `lienhe`) 
  //VALUES (NULL, 'Giáo viên 5', 'Phú Nhuận', '0821304747', 'giaovien5@gmail.com', 'Nam', md5('lfdsadf@gmail.com'));
    //INSERT INTO `taikhoan` (`ID`, `ID_User`, `Email`, `Password`, `Dec`, `time_at`, `image`, `status`, `unique_id`, `token`) 
    //VALUES (NULL, '5', 'giaovien5@gmail.com', MD5('2222'), '2', current_timestamp(), '', 'Không hoạt động', '', '');

    ?>
    <script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>