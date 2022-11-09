<?php
session_start();
ob_start();
if(isset($_SESSION['user']) && isset($_SESSION['pass'])&& isset($_SESSION['id_user']) && isset($_SESSION['ss'])&& isset($_SESSION['hs']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_hs($_SESSION['id_user'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['ss']);
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
    <title>HỌC SINH</title>
    <style>
        .main-nav>.nav-item>.dropdown-menu {
    border-radius: 0;
    padding: 0;
    margin:20px ;
    width: 250px;
    background: gray;
    display: none;
    visibility: hidden;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease 0s;
    text-decoration: none;
}
/*khi hover*/
.main-nav>.nav-item:hover>.dropdown-menu {
    display: block;
    margin-top: 0;
    z-index: 10;
    top: 100%;
    visibility: visible;
    opacity: 1;
    transform: translateY(0px);
    text-decoration: none;
}
    </style>
</head>
<body>
<a href="../logout.php"><h4>Đăng xuất</h4></a>
    <p>Chào hưng</p>

    <h4><a href="hs_diemdanh.php">Điểm danh</a></h4>
    <h4><a href="../chat/users.php">Chat trực tuyến</a></h4>
    <h4><ul class="main-nav">
            <li class="nav-item  has-dropdown">
                <a href="#"  class="nav-link">Khóa học<i class="fa fa-angle-down" data-toggle="dropdown"></i></a>			   
                <ul class="dropdown-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="dk_khoahoc.php">Đăng ký khóa học</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="all_khoahoc.php">Danh sách khóa học đã đăng kí</a>
                    </li>
                </ul>
            </li>
    </ul> </h4>
    <h4><a href="doi_pass.php">Đổi mật khẩu</a></h4>
    <h4><a href="../payment/index.php">Thanh toán khóa học</a></h4>
     <h4> <ul class="main-nav">
            <li class="nav-item  has-dropdown">
                <a href="#"  class="nav-link">Thực hiện kiểm tra<i class="fa fa-angle-down" data-toggle="dropdown"></i></a>			   
                <ul class="dropdown-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="test_tn.php">Trắc nghiệm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="test_tl.php">Tự luận</a>
                    </li>
                </ul>
            </li>
    </ul> </h4>
</body>
</html>