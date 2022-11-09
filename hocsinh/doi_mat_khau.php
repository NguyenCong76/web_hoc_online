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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
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
            <div class="card shadow-2-strong card-registration bg-light " style="border-radius: 15px; width: 450px;">
                <div class="card-body p-4 p-md-3">
                    <h1 class=" text-center font-italic text-info"><b>E-Learning</b></h1>
                    <hr>
                    <h3 class="text-center mb-3"> <span class="font-italic">Điền các thông tin bên dưới để đổi mật khẩu</span></h3>
                    <form action="" method="POST">
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-outline">
                                    <div class="input-group">
                                    <input type="password"  name="oldpass" class="form-control" placeholder="Mật khẩu hiện tại">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-outline">
                                    <div class="input-group">
                                    <input type="password"  name="newpass" class="form-control" placeholder="Mật khẩu mới">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="form-outline">
                                    <div class="input-group">
                                    <input type="password" name="cofpass" class="form-control" placeholder="Xác nhận mật khẩu mới">
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6">
                            <button type="submit" class="btn btn-info btn-block" name="nut" value="Cập nhật" >Xác nhận</button>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center pt-2">
                                <div class="col-md-3">
                                    <a href="../dang_ky.php">Đăng nhập</a>
                                </div>
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
                </div>
            </div>
        </div>
    </div>
</body>

</html>