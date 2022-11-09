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
  include('../includes/sql.php');
  $q=new sql();
 
  unset($_SESSION['id_bam']);
  unset($_SESSION['xacnhan']);
  $id=$p->laycot($p->connect(),"SELECT ID_User FROM `taikhoan` WHERE ID=".$_SESSION['id']."");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí kiểm tra</title>
    <link rel="stylesheet" href="../css/style_course.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
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
                  <a href="ql_hocsinh.php"><i class="fas fa-user-graduate "></i>Quản lí Học sinh</a>
                </li>
                <li>
                  <a href="taodiemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i>Quản lý Điểm danh</a>
                </li>
                <li>
                  <a href="chamdiem_tl.php"><i class="fas fa-pencil-ruler" aria-hidden="true"></i>Chấm điểm</a>
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
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto" >
                            <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="../chat/users.php"><i class="fa fa-comment" aria-hidden="true"></i></a>
                            </li>
                            <li class="dropdown" style="width: auto;">
                                <a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown"><span><?php $email=$_SESSION['user']; echo $q->laycot($p->connect(),"SELECT Ten_GV FROM `giao_vien` WHERE Email ='$email'");?></span><i class="fas fa-user ml-2" aria-hidden="true"></i></a>
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
                <?php
                    //$lay_id='';
                        if(isset($_GET['id']))
                        {
                            //$lay_id=unserialize(base64_decode($_GET['id']));
                            echo'<br><h3 class="mt-3">Tạo bài kiểm tra cho khóa học:</h3><div class="dropdown mr-2">
                            <button class="btn btn-warning dropdown-toggle text-white " type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tạo kiểm tra
                            </button>
                            <div class="dropdown-menu" >
                            <a class="dropdown-item" href="gv_tao_kt_tn.php?id='.$_GET['id'].'">Trắc nghiệm</a>
                            <a class="dropdown-item" href="gv_tao_test_tl.php?id='.$_GET['id'].'">Tự luận</a>
                            </div></div><hr><br>';
                            
                        }
                ?>
            <h3 class="mt-3">Danh sách các khóa học đang thực hiện:</h3>
              <i style='color:red;'>(Để tạo kiểm tra vui lòng chọn vào chỉnh sửa bên dưới mỗi khóa học!)</i><br>
                  <div class="row">
                <?php 
                  $q->gv_load_khoa($p->connect(),"SELECT * FROM `khoa_hoc` WHERE ID_GV='$id'");
                ?>
                </div>
          </div>
        </div>
</div>
<script src="../js/script.js"></script>
</body>
</html>