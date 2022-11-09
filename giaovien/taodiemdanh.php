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
 include("../includes/sql.php");
 $q=new sql();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIÁO VIÊN</title>
    <link rel="stylesheet" href="../css/style_course.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../JS/jquery.js"> </script>
</head>
<body>
<div class="wrapper">
    <nav id="sidebar">
      <div class="sidebar-header">
        <h2>E-Learning</h2>
      </div>
      <ul class="list-unstyled components">
        <li>
          <a href="ql_khoahoc.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Danh sách khóa học</a>
        </li>
        <li>
          <a href="ql_hocsinh.php"><i class="fas fa-user-graduate"></i>Quản lí Học sinh</a>
        </li>
        <li>
          <a href="ql_kiemtra.php"><i class="fas fa-pencil-ruler"></i>Quản lí Kiểm tra</a>
        </li>
        <li>
          <a href="taodiemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
        </li>
        <li>
        <a href="xuat_diem.php"><i class="fas fa-chart-bar"></i>Xuất điểm</a>
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
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
              </li>
              <li class="nav-item ">
                                <a class="nav-link" href="../chat/users.php"><i class="fas fa-comment" aria-hidden="true"></i></a>
                            </li>
              <li class="dropdown" style="width: auto;">
                                <a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown"><span><?php $email=$_SESSION['user']; echo $q->laycot($p->connect(),"SELECT Ten_GV FROM `giao_vien` WHERE Email ='$email'");?> </span><i class="fas fa-user ml-2" aria-hidden="true"></i></a>
                                <div class="dropdown-menu ">
                                  <a href="../hocsinh/doi_pass.php" class="dropdown-item"><i class="fa fa-lock" aria-hidden="true"></i> Đổi mật khẩu</a>
                                  <a href="../logout.php" class="dropdown-item"><i class="fa fa-arrow-right" aria-hidden="true"></i></i> Đăng xuất</a>
                                </div>
                              </li>
            </ul>
          </div>
        </div>
      </nav>
      <div id="course" class="container-fluid bg-light">
      <form action="" method="POST">
        <div class="row">
          <div class="col-sm-6"><h2>Khởi tạo điểm danh:</h2></div>
          <div class="col-sm-6"><button type="submit" class="btn btn-primary" name="danhsach" >Xem danh sách điểm danh</button></div>
        </div>
        <div class="col-sm-6">  
        <form action="" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6">
              <label for=""></label>
              <input type="password" class="form-control" name="pass" id="" placeholder="tạo chuỗi bất kì ...">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="">Nhập thời lượng điểm danh:</label>
              <input type="int" class="form-control" name="so" id="" placeholder="Nhập vào số phút ..." >
            </div>
          </div>
          <button type="submit" class="btn btn-info" name="nut" value="CREATE">Tạo</button>
          <button type="reset" class="btn btn-danger" >Cancel</button>
        </form>
  </div>
   <?php
   $so=0;
   $id_tk=$_SESSION['id'];
   if(isset($_POST['nut']))
   switch($_POST['nut'])
   {
    case'CREATE':
        {
          if(isset($_POST['so']))
          {
            $so=$_POST['so'];
            if($so==0){
              echo 'Vui lòng nhập số lớn hơn 0.';
              header("refresh:2;url=taodiemdanh.php");exit();
            }else{
            setcookie("Hung", "$id_tk", time()+$so*60, "/");
          }
        }
        if($_REQUEST['pass']=='')
        {
          echo "<script>alert('Chưa điền mật khẩu khởi tạo.')</script>";exit();
        } 
          $pass=$_REQUEST['pass'];
          //echo $q->laycot($p->connect(),"SELECT ID FROM `taikhoan` WHERE ID='1' ");exit();
         // echo $pass;
         $id_t=0;
         //echo $q->laycot($p->connect(),"SELECT ID_TK FROM  `pass` WHERE ID_TK='$id_tk'");exit();
         $id_t=$q->laycot($p->connect(),"SELECT ID_TK FROM  `pass` WHERE ID_TK='$id_tk'");
         //echo $id_t;exit();
         if($id_t==0)
         {
            $link=$p->connect();
            $sql="INSERT INTO `pass` (`ID`, `Password`, `ID_TK`) VALUES (NULL, '$pass','$id_tk')";
            if(mysqli_query($link,$sql))
              {
                echo "<script>alert('Khởi tạo thành công.')</script>";
              }
              else{
                echo 'Tạo thất bại';
                echo "<script>alert('Khởi tạo thất bại.')</script>";
              }
        }
        else
        {
          $link=$p->connect();
          $sql="UPDATE `pass` SET `Password` = '$pass' WHERE ID_TK = '$id_tk'";
          if(mysqli_query($link,$sql))
          {
           
            echo "<script>alert('Khởi tạo mật khẩu điểm danh thành công.')</script>";
          }
          else
          {
            echo "<script>alert('Khởi tạo thất bại.')</script>";
          }
        }
        }break;
   }
   if(isset($_POST['danhsach']))
   {
    header('location:quanli_dd.php');
   }
   ?>
    <script src="../js/script.js"></script>
</body>
</html>