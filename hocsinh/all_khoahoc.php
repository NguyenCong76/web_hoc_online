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
 include("../includes/sql.php");
 unset($_SESSION['lay_id']);
 unset($_SESSION['id_kt']);
 $q=new sql();
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Các khóa học đã đăng kí.</title>
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
                    <a href="all_khoahoc.php"><i class="fas fa-pencil-ruler"></i> Kiểm tra</a>
                </li>
                <li>
                    <a href="hs_diemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
                </li>
                <li>
                    <a href="../payment/index.php"><i class="fas fa-dollar-sign"></i> Đóng học phí</a>
                </li>
                <li>
                    <a href="doi_pass.php"><i class="fa fa-change" aria-hidden="true"></i>Thay đổi mật khẩu</a>
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
                                <a class="nav-link" href="../thong_tin_user.php"><i class="fas fa-user"></i></a>
                            </li>   
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="course" class="container-fluid bg-light">
            <div class="row">
               <div class="col-sm-6"><h3>Các khóa học có bài kiểm tra:</h3>
               <form action="" method="POST"> <input type="search" name="timkiem" placeholder="Tìm kiếm khóa học..."> </form>
            </div>
              <div class="col-sm-6"><div id="MyClockDisplay" class="clock" onload="showTime()"></div></div>
              </div><br>
              <div class="row">
    <?php
    $kq=mysqli_query($p->connect(),"SELECT ID_khoa FROM hocsinh_khoahoc WHERE ID_HS=".$_SESSION['id_user']." AND Payment='yes'");
    $i=@mysqli_num_rows($kq);
    if($i>0){
    while($row = @mysqli_fetch_array($kq)){
   
    {
                if(isset($_POST['timkiem'])){
                    $s=$_POST['timkiem'];
                    $sql_tk="SELECT * FROM `khoa_hoc` WHERE ID_khoa=".$row['ID_khoa']." AND Ten_khoa LIKE '%$s%'";
                    $res=mysqli_query($p->connect(),$sql_tk);
                $j=mysqli_num_rows($res);
                if($j>0)
                {
                while($row=@mysqli_fetch_array($res))
                {
                    $id=$row['ID_khoa'];
                $ten=$row['Ten_khoa'];
                $tg=$row['thoigian'];
                    $mo=$row['mota'];
                echo'
                <div class="col-sm-4">
                            <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">'.$ten.'</h5>
                                <p class="card-text">'.$mo.'</p>
                                <p class="">Thời gian:'.$tg.'</p>
                                <button><a href="khoaco_kt.php?id='.Base64_encode(serialize($id)).'&ten='.Base64_encode(serialize($ten)).'" class="btn btn-primary">Vào kiểm tra</a></button>
                            </div>
                            </div>
                        </div>
            
                '; //$id;
                }
                }
                }// tìm kiếm 
                else{
                $sql1="SELECT * FROM `khoa_hoc` WHERE ID_khoa=".$row['ID_khoa']."";
                $res=mysqli_query($p->connect(),$sql1);
                $j=mysqli_num_rows($res);
                if($j>0)
                {
                while($row=@mysqli_fetch_array($res))
                {
                    $id=$row['ID_khoa'];
                $ten=$row['Ten_khoa'];
                $tg=$row['thoigian'];
                    $mo=$row['mota'];
                echo'
                <div class="col-sm-4">
                            <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">'.$ten.'</h5>
                                <p class="card-text">'.$mo.'</p>
                                <p class="">Thời gian:'.$tg.'</p>
                                <button><a href="khoaco_kt.php?id='.Base64_encode(serialize($id)).'&ten='.Base64_encode(serialize($ten)).'" class="btn btn-primary">Vào kiểm tra</a></button>
                            </div>
                            </div>
                        </div>
            
                '; //$id;
                }
                }else
                {
                    echo 'Không có khóa học.';
                }
                }
    }
    }
}
    else
    {
      echo 'Hệ thống thông báo bạn chưa hoàn thành đóng học phí khóa học.';
    }
    ?>
            </div>
   </div>
        </div>
 </div>
 <script src="../clock_js/dist/script.js"></script>

 </body>
 </html>