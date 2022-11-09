<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
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
 $lay_id=$lay_ids=$nhap=$erro='';
  if(isset($_GET['id']))
  {
    $lay_id=unserialize(base64_decode($_GET['id']));
   
  }
  
  if(isset($_GET['ids']))
  {
    $lay_ids=unserialize(base64_decode($_GET['ids']));
  }
  $h=$q->laycot($p->connect(), "SELECT thoi_gian FROM `bai_kt_trac_nghiem` 
  WHERE id_kt_tn='$lay_ids' ORDER BY id_kt_tn DESC");
  //echo date("Y,d,m,H,i,s", strtotime($h)); //chỉnh lại thời gian để đưa vào ràng buộc
  
 $pass_user=$_SESSION['pass'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giao diện giáo viên</title>
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
          <a href="ql_khoahoc.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Danh sách khóa học</a>
        </li>
        <li>
          <a href="ql_hocsinh.php"><i class="fas fa-user-graduate"></i>Quản lí Học sinh</a>
        </li>
        <li>
          <a href="ql_kiemtra.php"><i class="fas fa-pencil-ruler"></i>Quản lí Kiểm tra</a>
        </li>
        <li>
          <a href="taodiemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i>Quản lí Điểm danh</a>
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
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="pt-6">Tạo bài kiểm tra trắc nghiệm</h3>
                    </div>
                    <div class="col-sm-6"></div>
                </div>
                <hr>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="">Tên bài kiểm tra:</label>
                        <input type="text" class="form-control" name="ten" placeholder="Nhập tên bài kiểm tra" value="<?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `ten` FROM `bai_kt_trac_nghiem` WHERE id_kt_tn=' . $lay_ids . '');
                                                                                                            } ?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="">Thời lượng:</label>
                        <input type="text" class="form-control" name="thoi_luong"  placeholder="Nhập thời lượng (phút)" value="<?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `thoi_luong` FROM `bai_kt_trac_nghiem` WHERE id_kt_tn=' . $lay_ids . '')   ;
                                                                                                                 } ?>"></input>
                    </div>
                    <div class="form-group">
                        <label for="">Thời gian kết thúc:</label>
                        <input type="datetime-local" class="form-control" name="tg"   value="<?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `thoi_gian` FROM `bai_kt_trac_nghiem` WHERE id_kt_tn=' . $lay_ids . '')   ; } ?>"></input>
                    </div>
                    <div class="row pt-2 pb-2 tex-center">
                        <div class="col-3"><button type="submit" class="btn btn-success " name="nut" value="Tạo">Tạo</button></div>
                        <div class="col-3"><button type="submit" class="btn btn-info" name="nut" value="Chỉnh sửa">Chỉnh sửa</button></div>
                        <div class="col-3"><button type="rest" class="btn btn-secondary " name="Hủy" value="Xóa">Hủy</button></div>
                        <?php if(isset($_GET['ids'])){echo ' <div class="col-3"><button type="submit" class="btn btn-success " name="nut" value="Đăng">Đăng bài</button></div>';} ?>
                    </div>
                </form>

                <?php
                //var_dump($_POST);exit();
                $ten = '';
                $thoi_luong = '';
                $tg='';
                if (isset($_POST['nut'])) {
                    switch ($_POST['nut']) {
                        case 'Tạo': {
                                if (empty($_POST['ten']) || empty($_POST['thoi_luong'])||empty($_POST['tg'])) {
                                    echo '<script>alert("Vui lòng nhập đầy đủ thông tin")</script>';
                                    exit();
                                }
                                $ten = $_POST['ten'];
                                $thoi_luong = $_POST['thoi_luong'];
                                $tg=$_POST['tg'];
                                $link = $p->connect();
                                $sql = "INSERT INTO `bai_kt_trac_nghiem` (`id_kt_tn`, `ten`, `thoi_luong`, `thoi_gian`, `ID_khoa`,`trangthai`) VALUES
                                (NULL, '$ten', '$thoi_luong', '$tg','$lay_id','no')";
                                if (mysqli_query($link, $sql)) {
                                    echo '<script>alert("Tạo bài kiểm tra trắc nghiệm thành công")</script>';
                                } else {
                                    echo '<script>alert("Tạo bài kiểm tra trắc nghiệm thất bại")</script>';
                                }
                            }
                            break;

                        case 'Chỉnh sửa': {
                                if (empty($_POST['ten']) || empty($_POST['thoi_luong']) || empty($_POST['tg'])) {
                                    echo '<script>alert("Vui lòng chọn bài kiểm tra")</script>';
                                    exit();
                                }
                                $ten = $_POST['ten'];
                                $thoi_luong = $_POST['thoi_luong'];
                                $tg=$_POST['tg'];
                                $link = $p->connect();
                                $sql = "UPDATE `bai_kt_trac_nghiem` SET `ten` = '$ten', `thoi_luong` = '$thoi_luong',`thoi_gian`='$tg' WHERE `bai_kt_trac_nghiem`.`id_kt_tn` = '$lay_ids'";
                                if (mysqli_query($link, $sql)) {
                                    echo '<script>alert("Chỉnh sửa bài kiểm tra thành công")</script>';
                                } else {
                                    echo '<script>alert("Chỉnh sửa bài kiểm tra thất bại")</script>';
                                }
                            }break;
                        case 'Đăng':
                            {
                                $sql = "UPDATE `bai_kt_trac_nghiem` SET `trangthai`='yes' WHERE `bai_kt_trac_nghiem`.`id_kt_tn` = '$lay_ids'";
                                if (mysqli_query($p->connect(), $sql)) {
                                    echo '<script>alert("Đăng bài thi thành công! ")</script>';
                                }
                            }
                            break;
                    }
                }

                ?>
                <h3>Danh sách các bài kiểm tra chưa đăng:</h3>
                <?php
                 $q->load_bai_kt_tn($p->connect(), "SELECT * FROM `bai_kt_trac_nghiem` WHERE ID_khoa='$lay_id' AND `trangthai`='no' AND thoi_gian>CURTIME() ORDER BY id_kt_tn DESC");
                ?>
                <h3>Danh sách các bài kiểm tra đã đăng lên:</h3>
                <?php
                 $q->load_bai_kt_tn($p->connect(), "SELECT * FROM `bai_kt_trac_nghiem` WHERE ID_khoa='$lay_id' AND `trangthai`='yes' ORDER BY id_kt_tn DESC");
                ?>
                <h3>Danh sách các bài kiểm tra (cũ):</h3>
                <?php
                 $q->load_bai_kt_tn($p->connect(), "SELECT * FROM `bai_kt_trac_nghiem` WHERE ID_khoa='$lay_id' AND thoi_gian<CURTIME() ORDER BY id_kt_tn DESC");
                ?>
            </div>
        </div>
    </div>

    <script src="../js/script.js"></script>

</body>

</html>