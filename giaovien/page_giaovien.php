<?php
session_start();
ob_start();
if(isset($_SESSION['id'])&&isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['ss']) && isset($_SESSION['gv']))
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
    <title>GIÁO VIÊN</title>
</head>
<body>
    <h4> <a href="../logout.php">Đăng xuất</a></h4>
    <h4> <a href="taodiemdanh.php">Tạo điểm danh</a></h4>
    <h4> <a href="ql_khoahoc.php">Quản lí khóa học</a></h4>
    <h4> <a href="chamdiem_tl.php">Quản lí bài kiểm tra</a></h4>
    
</body>
</html>