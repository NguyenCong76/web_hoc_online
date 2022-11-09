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
 ?>
<?php
$lay_id = $id_kt='';
if (isset($_REQUEST['id'])) {
      $lay_id = unserialize(base64_decode($_REQUEST['id']));
}
if (isset($_REQUEST['id_kt'])) {
    $id_kt = unserialize(base64_decode($_REQUEST['id_kt']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kiểm tra</title>
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
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fa fa-comment" aria-hidden="true"></i></a>
                            </li>
                            <li class="dropdown" style="width: auto;">
                                <a href="../thong_tin_user.php" class=" nav-link dropdown-toggle" data-toggle="dropdown"><span>Ly dang thai
                                        hung </span><i class="fas fa-user ml-2" aria-hidden="true"></i></a>
                                <div class="dropdown-menu ">
                                    <a href="doi_pass.php" class="dropdown-item"><i class="fa fa-lock" aria-hidden="true"></i> Đổi
                                        mật khẩu</a>
                                    <a href="../logout.php" class="dropdown-item"><i class="fa fa-arrow-right" aria-hidden="true"></i></i> Đăng
                                        xuất</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="course" class="container-fluid bg-light">
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="pt-2">Bài kiểm tra trắc nghiệm</h3>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center pt-2">
                        <button class="btn btn-warning text-white" type="button" data-toggle="modal" data-target="#start">Bắt đầu</button>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center pt-2">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </div>
                </div>
                <hr>
                <form action="" method="POST">
                <div class="modal fade" id="start" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Xác nhận bắt đầu làm bài</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <span>Mỗi câu hỏi chỉ có 1 đáp án đúng.</span><br>
                            <span>Hết thời gian hệ thống sẽ tự động nộp bài!</span>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-danger" data-dismiss="modal">Hủy</button>
                                <button type="submit" class="btn btn-success" name="nut" value="xacnhan">Xác nhận</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
<?php
if(isset($_POST['nut']))
{
    switch($_POST['nut'])
    {
        case'xacnhan':
            { 
                          
                              $tg= $q->laycot($p->connect(), "SELECT thoi_luong FROM `bai_kt_trac_nghiem` WHERE id_kt_tn='$id_kt'");
                             $time=$tg*60+5;
                              setcookie("start_tests","2",time()+$time,"/");
                             
                          header("location:kt_trac_nghiem.php?id_kt=". Base64_encode(serialize($id_kt))."");
          }break;
                 
    }
}
?>




            </div>
        </div>
    </div>

    <script src="../js/script.js"></script>
    <script src="../clock_js/dist/script.js"></script>

</body>

</html>