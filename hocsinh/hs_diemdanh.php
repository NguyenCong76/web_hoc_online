<?php
session_start();
ob_start();
$con=mysqli_connect("localhost","root","","hoc_online");
if(isset($_SESSION['user']) && isset($_SESSION['pass'])&& isset($_SESSION['id_user']) && isset($_SESSION['ss'])&& isset($_SESSION['hs']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_hs($_SESSION['id_user'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['ss']);
 }
 else if(isset($_SESSION['user_token']))
 {
   // header('location:../index.php');
 }else
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
        <title>Giao diện học sinh</title>
        <link rel="stylesheet" href="../css/style_course.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
          .clock {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: #17D4FE;
    font-size: 30px;
    font-family: Orbitron;
    letter-spacing: 5px;
    background-color: black;
}
        </style> 
</head>

<body>
    <div class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2>E-Learning</h2>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="danh_sach_khoa_hoc.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Danh sách khóa học</a>
                </li>
                <li>
                    <a href="all_khoahoc.php"><i class="fas fa-pencil-ruler    "></i> Kiểm tra</a>
                </li>
                <li>
                    <a href="hs_diemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
                </li>
                <li>
                    <a href="../payment/index.php"><i class="fas fa-dollar-sign"></i> Đóng học phí</a>
                </li>
                <li>
                    <a href="doi_pass.php"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thay đổi mật khẩu</a>
                </li>
                <li>
                    <a href="../logout.php"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Đăng xuất</a>
                </li>
            </ul>
        </nav>

        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fa fa-bars" aria-hidden="true"></i>
                        <span>Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto" style="width: 200px;">
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="../chat/users.php"><i class="fa fa-comment" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><i class="fas fa-user    "></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="course" class="container-fluid bg-light">
                <br>
               <div class="row">
               <div class="col-sm-6"><h3>Điểm danh hệ thống :</h3></div>
              <div class="col-sm-6"><div id="MyClockDisplay" class="clock" onload="showTime()"></div></div>
              </div>
                <hr>
               <form action="" method="post">
                <input type="password" name="pass" placeholder="Nhập mật khẩu">
                <button type="submit" class="btn-primary" name="nut" value="XÁC NHẬN">Xác nhận</button>
               </form>
               <?php

if(!isset($_SESSION['user_token']))
 {
     $id_hs=$_SESSION['id_user'];
 }else
 {
    //var_dump($_SESSION);exit();
    $sql="SELECT ID_User FROM `taikhoan` WHERE token=".$_SESSION['user_token']."";
     $id_hs=$q->laycot($con,$sql);
 }
if(isset($_POST['nut']))
switch($_POST['nut'])
{
    case'XÁC NHẬN';
    {
        $sqln='';
     if(isset($_COOKIE['Hung'])){
      $sqln="SELECT Password FROM `pass` WHERE ID_TK=".$_COOKIE['Hung'].""; // lấy biến  cookie để chạy 
     }
     $cof_pass= $q->laycot($con,$sqln);
     if($cof_pass!=$_REQUEST['pass'])
     {
        echo 'Mật khẩu điểm danh không đúng.';
     }
     else
     {
        if(isset($_COOKIE['Hung'])){
        header('location:xacnhan_dd.php');
        }else
        {
            echo 'Đã hết thời lượng điểm danh...';
            header("refresh:3;url=page_hocsinh.php");
        }
     }
    }break;

}
?>
            </div>
        </div>
    </div>
    </div>

    <script src="js/script.js"></script>
    <script src="../clock_js/dist/script.js"></script>
</body>
</html>

