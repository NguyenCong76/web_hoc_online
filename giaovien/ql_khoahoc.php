<?php
session_start();
ob_start();
if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['ss']) && isset($_SESSION['gv'])) {
  include("../confid.php");
  $p = new login();
  $p->confirm_gv($_SESSION['id'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
} else {
  header('location:../index.php');
}
include('../includes/sql.php');
$q = new sql();
$lay_id = '';
if (isset($_GET['id'])) {
  $lay_id = unserialize(base64_decode($_GET['id']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quản lí khóa học</title>
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
                <a class="nav-link" href="../chat/users.php"><i class="fa fa-comment" aria-hidden="true"></i></a>
              </li>
              <li class="dropdown" style="width: auto;">
                <a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown"><span><?php $email = $_SESSION['user'];
                                                                                            echo $q->laycot($p->connect(), "SELECT Ten_GV FROM `giao_vien` WHERE Email ='$email'"); ?></span><i class="fas fa-user ml-2" aria-hidden="true"></i></a>
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
        <div class="col-sm-4">
          <h3 class="pt-2">Thông tin khóa học</h3>
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="">Tên khóa học</label>
              <input type="text" class="form-control" style="width: 400px;" name="txtten" value="<?php if (isset($lay_id)) {
                                                                                                    echo  $q->laycot($p->connect(), 'SELECT Ten_khoa FROM khoa_hoc WHERE ID_khoa=' . $lay_id . '');
                                                                                                  }
                                                                                                  ?>">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-7">
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="">Mô tả</label>
                  <textarea class="form-control" name='txtmota' style="width: 400px;"><?php if (isset($lay_id)) {
                                                                                        echo $q->laycot($p->connect(), 'SELECT mota FROM khoa_hoc WHERE ID_khoa=' . $lay_id . '');
                                                                                      } ?></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-3">
                  <label for="">Thời gian</label>
                  <input type="date" name="time" style="width: 400px;" class="form-control" value="<?php if (isset($lay_id)) {
                                                                                                      echo $q->laycot($p->connect(), 'SELECT thoigian FROM khoa_hoc WHERE ID_khoa=' . $lay_id . '');
                                                                                                    } ?>">
                </div>
              </div>
              <div class="row">
                <div class="col-4"><button type="submit" class="btn btn-success " name="nut" value="Tạo">Tạo khóa</button></div>
                <div class="col-4"><button type="submit" class="btn btn-info" name="nut" value="Xác nhận thay đổi">Thay đổi</button></div>
                <div class="col-4"><button type="submit" class="btn btn-danger " name="nut" value="Hủy">Hủy</button></div>
              </div>
            </div>
            <div class="col-sm-5">
              <?php
              if (isset($_GET['id'])) {
                echo '
                                 <h3>Up Load file video hướng dẫn khóa học ở dạng (.zip)</h3>
                                 <input type="text" name="ten_file" placeholder="Điền vào Tên File ">
                                 <input type="file" name="file">
                                 <input type="submit" name="them" class="btn btn-success" value="Thêm file">
                               ';
                if (isset($_POST['them'])) {
                  switch ($_POST['them']) {
                    case 'Thêm file': {
                        //INSERT INTO `video_hd` (`ID`,`Ten_file`,`file`, `ID_khoa`) VALUES (NULL, 'test.zip', '1');
                        $ten_file = $_REQUEST['ten_file'];
                        $name = $_FILES['file']['name'];
                        $type = $_FILES['file']['type'];
                        $size = $_FILES['file']['size'];
                        $tmp_name = $_FILES['file']['tmp_name'];

                        if ($name != '' && $type == 'application/x-zip-compressed') //up lên zip thì dùng 'application/x-zip-compressed'
                        {
                          $name1 = str_replace('.zip', '', $name);
                          $ten = Base64_encode(serialize($name1));
                          $sql = "INSERT INTO `video_hd` (`ID`, `Ten_file`,`file`, `ID_khoa`) VALUES (NULL,'$ten_file','$ten',' $lay_id')";
                          if (mysqli_query($p->connect(), $sql)) {
                            if ($q->upload($name, $tmp_name, "./file_video")) {
                              require_once('../includes/Extractor.class.php');
                              $extractor = new Extractor();
                              // dẫn tới file nén
                              $archivePath = "./file_video/$name";

                              // chứa file đã giải nén
                              $destPath = "./file_video/";

                              // xử lí nén
                              if ($extractor->extract($archivePath, $destPath) == true) {
                                echo "<script type='text/javascript'>alert('Tải file thành công rồi đấy.');</script>";
                              } else {
                                echo "<script type='text/javascript'>alert('Tải rồi nhưng chưa xử được file nén.');</script>";
                              }
                            }
                          } else {
                            echo "<script type='text/javascript'>alert('Tải file thất bại! (bạn hãy thử thay đổi tên file xem sao.)');</script>";
                          }
                        } else {
                          echo "<script type='text/javascript'>alert('Vui lòng chọn định dạng file zip !');</script>";
                        }
                      }
                  }
                }
              }
              ?>

            </div>
          </div>
        </form>

        <?php
        $ten = '';
        $mo = '';
        $ngay = '';
        $id = $p->laycot($p->connect(), "SELECT ID_User FROM `taikhoan` WHERE ID=" . $_SESSION['id'] . "");
        if (isset($_POST['nut'])) {
          switch ($_POST['nut']) {
            case 'Tạo': {
                if (empty($_POST['txtten']) || empty($_POST['txtmota']) || empty($_POST['time'])) {
                  echo 'Thầy chưa nhập đủ thầy ơi.';
                  header("refresh:2;url=quanli_khoahoc.php");
                  exit();
                }
                $ten = $_POST['txtten'];
                $mo = $_POST['txtmota'];
                $ngay = $_POST['time'];
                $link = $p->connect();
                $sql = "INSERT INTO `khoa_hoc` (`ID_khoa`, `Ten_khoa`, `ID_GV`, `thoigian`, `mota`) VALUES
                                       (NULL, '$ten', '$id', '$ngay', '$mo');";
                if (mysqli_query($link, $sql)) {
                  echo 'Đã tạo khóa học thành công. ';
                } else {
                  echo 'Khởi tạo Thất bại';
                }
              }
              break;
            case 'Hủy': {
                header("location:ql_khoahoc.php");
              }
              break;
            case 'Xác nhận thay đổi': {
                if (empty($_POST['txtten']) || empty($_POST['txtmota']) || empty($_POST['time'])) {
                  echo 'Thầy chưa nhập đủ thầy ơi.';
                  header("refresh:2;url=quanli_khoahoc.php");
                  exit();
                }
                $ten = $_POST['txtten'];
                $mo = $_POST['txtmota'];
                $ngay = $_POST['time'];
                $link = $p->connect();
                $sql = "UPDATE `khoa_hoc` SET `Ten_khoa` = '$ten', `thoigian` = '2022-08-26', `mota` = '$mo' WHERE `khoa_hoc`.`ID_khoa` = '$lay_id'";
                if (mysqli_query($link, $sql)) {
                  echo 'Đã cập nhật khóa học thành công. ';
                  header("refresh:3;url=quanli_khoahoc.php");
                } else {
                  echo 'Cập nhật Thất bại';
                }
              }
              break;
          }
        }

        ?>
        <hr>
        <h3 class="mt-3"><a href="">Danh sách các khóa học đã tạo:</a></h3>
        <form action="" method="POST"> <input type="search" name="timkiem" placeholder="Tìm kiếm khóa học..."> </form>
        <div class="row">
          <?php
          if (isset($_POST['timkiem'])) {
            $s = $_POST['timkiem'];
            $k1 = "SELECT * FROM `khoa_hoc` WHERE ID_GV='$id' AND Ten_khoa LIKE'%$s%'";
            $q->gv_load_khoa($p->connect(), $k1);
          } else {
            $q->gv_load_khoa($p->connect(), "SELECT * FROM `khoa_hoc` WHERE ID_GV='$id'");
          }
          ?>
        </div>
      </div>
    </div>
  </div>
  </div>

  <script src="../js/script.js"></script>

</body>

</html>