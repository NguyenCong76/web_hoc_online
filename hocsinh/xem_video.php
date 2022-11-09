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
 $q=new sql();
 $lay_id=$id_x='';
 if(isset($_GET['id']))
 {
    $lay_id=unserialize(base64_decode($_GET['id']));
 }
 if(isset($_GET['id_v']))
 {
     $id_x=unserialize(base64_decode($_GET['id_v']));
 }
 ?>

<!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học sinh xem video hướng dẫn</title>
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
               <div class="col-sm-6"><h3>Video hướng dẫn khóa học</h3></div>
               
            
              <div class="col-sm-6"><div id="MyClockDisplay" class="clock" onload="showTime()"></div></div>
              </div><br>
              <div class="row">
             <?php
             $sql="SELECT * FROM `video_hd` WHERE ID_khoa='$lay_id'";
             $kq=mysqli_query($q->connect(),$sql);
              $i=mysqli_num_rows($kq);
             if($i>0)
             {
                while($row=mysqli_fetch_array($kq))
                {
                    $id_v=$row['ID'];
                    $ten_f=$row['Ten_file'];
                    $file=$row['file'];
                    echo'<div class="col-sm-4">
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">'.$ten_f.'</h5>
                            <img src="../hinh/logo.png" alt="" width="200px" height="200px">
                             <a href="?id='.$_GET['id'].'&id_v='.Base64_encode(serialize($id_v)).'" ><input type="submit" class="btn btn-primary" value="Xem"></a>
                        </div>
                    </div>
                </div>
              ';
            
                }
             }
             else
             {
                echo 'Chưa có video nào cho khóa học này.';
             }
             ?>
             </div>
             <?php 
             if(!empty($id_x)){
             $ten=$q->laycot($p->connect(),"SELECT Ten_file FROM `video_hd` WHERE ID='$id_x'");
             $file=$q->laycot($p->connect(),"SELECT file FROM `video_hd` WHERE ID='$id_x'");
             $vid=unserialize(base64_decode($file));
             $video=$vid.'.mp4';
             echo'
                           <div class="row">
                           <div class="col-6">
                             <div class="modal-header">
                               <h3 class="modal-title"> '.$ten.' </h3>
                             </div>
                             <div class="modal-body">
                             <video width="360" height="240" controls>
                                <source src="../giaovien/file_video/'.$video.'" type="video/mp4">
                            </video>
                             </div>
                             </div>
                        </div>
                       ';
             }
                       ?>
          
   </div>      
        </div>
 </div>
 <script src="../clock_js/dist/script.js"></script>

 </body>
 </html>