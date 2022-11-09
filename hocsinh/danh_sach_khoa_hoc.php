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
 if(!isset($p))
 {
    include("../confid.php");
    $p=new login();
 }
 include("../includes/sql.php");
$q=new sql();
$lay_id='';
if(!isset($_SESSION['user_token']))
 {
     $id_hs=$_SESSION['id_user'];
 }else
 {
    //var_dump($_SESSION);exit();
    $sql="SELECT ID_User FROM `taikhoan` WHERE token=".$_SESSION['user_token']."";
     $id_hs=$q->laycot($con,$sql);
 }
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
                                <a class="nav-link" href=""><i class="fas fa-search" aria-hidden="true"></i></a>
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
            <?php 
       if(isset($_GET['id']))
       {
         $lay_id=unserialize(base64_decode($_GET['id']));
         $ten_khoa=$q->laycot($con,"SELECT Ten_khoa FROM `khoa_hoc` WHERE ID_khoa='$lay_id'");
         echo '<h3>Bạn vừa chọn '.$ten_khoa.' .Bạn có chắc chắn muốn đăng kí khóa học này?<br><h2><a href="?ids='.$_GET['id'].'">Đồng ý đăng ký khóa học</a></h2></h3>';
       }
       else{
        echo '<h3 style="color:red;">Mời bạn chọn khóa học bên dưới để đăng kí tham gia !!!</h3>';
       }
       
  ?>
 <?php
    if(isset($_GET['ids']))
    {
      $lay_id=unserialize(base64_decode($_GET['ids']));
      $sql="INSERT INTO `hocsinh_khoahoc` (`ID_HS`, `ID_khoa`,`Payment`) VALUES ('$id_hs', '$lay_id','no')";
      if(mysqli_query($con,$sql)==true)
      {
        echo"<script>alert('Đăng ký thành công.')</script>";
        header("refresh:3;url=danh_sach_khoa_hoc.php");
      }
      else
      {
        echo"<script>alert('Đăng kí không thành công.Vì bạn đã đăng kí khóa học này rồi.')</script>";
    
      }   
    } 
 ?>
            <div id="course" class="container-fluid bg-light">
               <div class="row">
               <div class="col-sm-6"><h3>Các khóa học trên hệ thống :</h3>
               <form action="" method="POST"> <input type="search" name="timkiem" placeholder="Tìm kiếm khóa học..."> </form>
                </div>
              <div class="col-sm-6"><div id="MyClockDisplay" class="clock" onload="showTime()"></div></div>
              </div>
                <hr>
                <div class="row mt-3">
                <?php
                if(isset($_POST['timkiem']))
                {
                    $s=$_POST['timkiem'];
                       $k1="SELECT * FROM `khoa_hoc` WHERE Ten_khoa LIKE'%$s%'";
                       $q->load_khoa($con,$k1);
                }else{
                    $k="SELECT * FROM `khoa_hoc`";
                    $q->load_khoa($con,$k);
                }

                ?>
                </div>
            </div>
            <div id="course" class="container-fluid bg-light">
            <br>
            <h3>Khóa học đã đăng ký tham gia</h3>
            <hr>
                <div class="row mt-3">
                <?php
                $sql="SELECT * FROM `hocsinh_khoahoc` WHERE ID_HS='$id_hs'";
                $kq=mysqli_query($p->connect(),$sql);
                
                while($row=@mysqli_fetch_array($kq)){
                   $sql1="SELECT * FROM `khoa_hoc` WHERE ID_khoa=".$row['ID_khoa']."";
                    $ketqua=mysqli_query($p->connect(),$sql1);
                            $i=@mysqli_num_rows($ketqua);
                           
                            if ($i>0)	
                            { 
                                while ($row=@mysqli_fetch_array($ketqua))
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
                                                        <p class="">'.$tg.'</p>
                                                   <a href="xem_video.php?id='.Base64_encode(serialize($id)).'" class="btn btn-primary">Xem video</a>
                                                    </div>
                                                </div>
                                            </div>
                                
                                    ';

                                }
		  }    
         @mysqli_close($con);  
               }
               @mysqli_close($con);
                ?>
                </div>
        </div>
        <div id="course" class="container-fluid bg-light">
        <br>
            <h3>Khóa học chưa hoàn thành học phí</h3>
            <hr>
            <div class="row mt-3">
            <?php
           // echo $id_hs;
           $kq=mysqli_query($p->connect(),"SELECT ID_khoa FROM hocsinh_khoahoc WHERE ID_HS='$id_hs' AND payment='no'");
           while($row=@mysqli_fetch_array($kq))
           {
                $sql="SELECT * FROM `khoa_hoc` WHERE ID_khoa=".$row['ID_khoa']."";
                $ketqua1=mysqli_query( $p->connect(),$sql);
                        $i=@mysqli_num_rows($ketqua1);
                       
                        if ($i>0)	
                        { 
                            while ($row=@mysqli_fetch_array($ketqua1))
                            {
                            //$id=$row['ID_khoa'];
                            $ten=$row['Ten_khoa'];
                            $tg=$row['thoigian'];
                            $mo=$row['mota'];
                                echo'
                                <div class="col-sm-4">
                                            <div class="card" style="width: 18rem;">
                                                <div class="card-body">
                                                    <h5 class="card-title">'.$ten.'</h5>
                                                    <p class="card-text">'.$mo.'</p>
                                                    <p class="">'.$tg.'</p>
                                                </div>
                                            </div>
                                        </div>
        
                                ';

                            }              
               }    
              @mysqli_close($con);
            }
            @mysqli_close($con);
            ?>
            </div>
    </div>
    </div>
    
    <script src="../js/script.js"></script>
    <script src="../clock_js/dist/script.js"></script>

</body>

</html>