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
 $lay_id=$id_kt='';
 if(isset($_GET['id']))
  {
    $lay_id=unserialize(base64_decode($_GET['id']));
   // echo $lay_id;
      if(!isset($_SESSION['lay_id']))
      {
        $_SESSION['lay_id']=$lay_id;
      }
  }else{
   header("location:all_khoahoc.php");
  }
if(isset($_GET['id_k']))
{
  $id_kt=unserialize(base64_decode($_GET['id_k']));
}else{
  header("location:all_khoahoc.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bắt đầu làm bài</title>
    <link rel="stylesheet" href="../css/style_course.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   
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
              
    <form action="" method="POST">
    <div class="row">
                    <div class="col-sm-4">
                        <h3 class="pt-2">Bài kiểm tra tự luận</h3>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center pt-2">
                        <button class="btn btn-warning text-white" type="button" data-toggle="modal" data-target="#myModal">Bắt đầu làm bài</button>
                    </div>
                    <div class="col-sm-4 d-flex justify-content-center pt-2">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </div>
                </div>
        <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title">Bắt đầu làm bài kiểm tra</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          
                              <div class="form-group">
                                <label for="exampleInputEmail1">Nhắc nhở:</label>
                                <p> Các em lưu ý trong quá trình làm bài không được rời khỏi trang làm bài của hệ thống , nếu vi phạm sẽ không thể thực hiện nộp bài làm trên hệ thống!  </p>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="start" id="batdau" value="Xác nhận làm bài" class="btn btn-success ">
                                  Xác nhận bắt đầu
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" class="btn btn-danger">
                                  Hủy
                                </button>
                              </div>
                       
                          </div>
                        </div>
                      </div>
                    </div>
    </form>
            </div>
        </div>
</div>

    <?php
    if(isset($_POST['start']))
    switch($_POST['start'])
    {
        case'Xác nhận làm bài':
            {   
                $_SESSION['batdau']=true;
                $tg=$q->laycot($p->connect(),"SELECT thoi_luong FROM `kiemtra_tl` WHERE ID_KT='$id_kt' AND ID_khoahoc='$lay_id'");
             if(!isset($_SESSION['1lan'])==true){  //Ràng buộc chỉ thực hiện được lần đầu tiên.
              setcookie("start_test","1",time()+($tg+15)*60,"/");
             }
              header("location:test_tl.php?ids=".$_GET['id']."&id_kt=".$_GET['id_k']."");
            }break;
    }
    ?>
 <script src="../clock_js/dist/script.js"></script>
</body>
</html>