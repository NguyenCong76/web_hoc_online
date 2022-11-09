<?php
include("mail/quenpass.php");
$mail=new QUENPASS();
include("confid.php");
$q=new login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cấp lại mật khẩu</title>
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
<div class="container-fulid w-100 h-100 p-5 bg-info">
        <div class="row d-flex justify-content-center align-items-center">
                <div class="card shadow-2-strong card-registration bg-light " style="border-radius: 15px; width: 550px;">
                    <div class="card-body p-4 p-md-3">
                        <h1 class=" text-center font-italic text-info"><b>E-Learning</b></h1>
                        <hr>
                        <h3 class="text-center mb-3"> <span class="font-italic">Chúng tôi sẽ cấp mật khẩu mới cho bạn!</span></h3>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <div class="input-group">
                                            <input type="email" name="email"  class="form-control" placeholder="Nhập email mà bạn đã đăng ký tài khoản" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <button type="submit" id="nut" name="nut" class="btn btn-info btn-block btn-lg" value="Sign in">Xác nhận</button>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center pt-2">
                                <div class="col-md-3">
                                    <a href="dang_nhap.php">Đăng nhập</a>
                                </div>
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
                    </div>
                </div>
            </div>
        </div>
</body>
</html>