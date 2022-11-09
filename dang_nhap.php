<?php
ob_start();
session_start();
include("confid.php");
 $p= new login();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
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
                        <h3 class="text-center mb-3"> <span class="font-italic">Đăng nhập để bắt đầu</span></h3>
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <label for="txtten"><b>Email</b> </label>
                                        <div class="input-group">
                                            <input type="text" name="txtuser" id="txtuser" class="form-control" placeholder="Nhập email" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <label for="txtuser"><b> Mật khẩu</b></label>
                                        <div class="input-group">
                                            <input type="password" name="txtpass" id="txtpass" class="form-control" placeholder=" Nhập mật khẩu" value="">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-12 mb-3">
                                    <div class="input-group mb-3 d-flex justify-content-center">
                                        <img src="captcha.php" title="" alt="" width="300px" ; height="auto" ; /></th>
                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="text" name="input" class="form-control" placeholder="Nhập lại những chữ số trên hình">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <span class="fas fa-image"></span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-md-6">
                                    <button type="submit" id="nut" name="nut" class="btn btn-info btn-block btn-lg" value="Sign in">Đăng nhập</button>
                                </div>
                                <div class="col-md-6">
                                    <button type="reset"  class="btn btn-secondary btn-block btn-lg">Hủy</button>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center pt-2">
                                <div class="col-md-12">
                                    <a href="hocsinh/login_gg.php" class="btn btn-block btn-danger">
                                        <i class="fab fa-google-plus mr-2"></i>
                                        Đăng nhập với Google+
                                    </a>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center pt-2">
                                <div class="col-md-9">
                                    <a href="dang_ky.php">Bạn chưa có tài khoản? Đăng ký ngay!</a>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center pt-2">
                                <div class="col-md-5">
                                    <a href="dang_ky.php">Bạn quên mật khẩu?</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
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
</body>

</html>