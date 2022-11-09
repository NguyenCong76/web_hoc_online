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
include("../includes/sql.php");
$q = new sql();
?>
<?php

$lay_id = $id_k =$lay_idkt = '';
if (isset($_REQUEST['id'])) {
    $id_k = unserialize(base64_decode($_REQUEST['id']));
}
if (isset($_REQUEST['ids'])) {
    $lay_id = unserialize(base64_decode($_REQUEST['ids']));
}
if (isset($_REQUEST['id_kt'])) {
    $lay_idkt = unserialize(base64_decode($_REQUEST['id_kt']));
}
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
                        <h3 class="pt-2">Tạo câu hỏi trắc nghiệm</h3>
                        <?php //INSERT INTO `bai_kt_trac_nghiem` (`id_kt_tn`, `ten`, `thoi_gian`, `thoi_luong`) VALUES (NULL, '15 phút toán', '15', current_timestamp());
                        ?>
                    </div>
                </div>
                <hr>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="">Câu hỏi:</label>
                        <textarea class="form-control" name="cau_hoi" rows="2" placeholder="Nhập câu hỏi"><?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `cau_hoi` FROM `trac_nghiem` WHERE id=' . $lay_id . '');
                                                                                                            } ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="mota">Đáp án A:</label>
                        <textarea class="form-control" name="cau_a" rows="2" placeholder="Nhập đáp án A"><?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `cau_a` FROM `trac_nghiem` WHERE id=' . $lay_id . '');
                                                                                                            } ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Đáp án B:</label>
                        <textarea class="form-control" name="cau_b" rows="2" placeholder="Nhập đáp án B"><?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `cau_b` FROM `trac_nghiem` WHERE id=' . $lay_id . '');
                                                                                                            } ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Đáp án C:</label>
                        <textarea class="form-control" name="cau_c" rows="2" placeholder="Nhập đáp án C"><?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT  `cau_c` FROM `trac_nghiem` WHERE id=' . $lay_id . '');
                                                                                                            } ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Đáp án D:</label>
                        <textarea class="form-control" name="cau_d" rows="2" placeholder="Nhập đáp án D"><?php if (isset($lay_id)) {
                                                                                                                echo $q->laycot($p->connect(), 'SELECT `cau_d` FROM `trac_nghiem` WHERE id=' . $lay_id . '');
                                                                                                            } ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                        <label for="">Đáp án đúng:</label>
                        <input class="form-control" type="text" name="dap_an" placeholder="Nhập đáp án đúng" value="<?php if (isset($lay_id)) {
                                                                                            echo $q->laycot($p->connect(), 'SELECT `dap_an` FROM `trac_nghiem` WHERE id=' . $lay_id . '');
                                                                                        } ?>">
                         </div>                                                               
                    </div>
                    <div class="row pt-2 pb-2 tex-center">
                        <div class="col-4"><button type="submit" class="btn btn-success " name="nut" value="Tạo">Tạo</button></div>
                        <div class="col-4"><button type="submit" class="btn btn-info" name="nut" value="Chỉnh sửa">Chỉnh sửa</button></div>
                        <div class="col-4"><button type="submit" class="btn btn-danger " name="nut" value="Xóa">Xóa</button></div>
                    </div>
                </form>

                <?php
                //var_dump($_POST);exit();
                $cau_hoi = '';
                $cau_a = '';
                $cau_b = '';
                $cau_c = '';
                $cau_d = '';
                $dap_an = '';
                if (isset($_POST['nut'])) {
                    switch ($_POST['nut']) {
                        case 'Tạo': {
                                if (empty($_POST['cau_hoi']) || empty($_POST['cau_a']) || empty($_POST['cau_b']) || empty($_POST['cau_c']) || empty($_POST['cau_d']) || empty($_POST['dap_an'])) {
                                    echo '<script>alert("Vui lòng nhập đầy đủ thông tin")</script>';

                                    exit();
                                }
                               
                                $cau_hoi = $_POST['cau_hoi'];
                                $cau_a = $_POST['cau_a'];
                                $cau_b = $_POST['cau_b'];
                                $cau_c = $_POST['cau_c'];
                                $cau_d = $_POST['cau_d'];
                                $dap_an = $_POST['dap_an'];
                                $link = $p->connect();
                                $sql = "INSERT INTO `trac_nghiem` (`id`, `cau_hoi`, `cau_a`, `cau_b`, `cau_c`,`cau_d`,`dap_an`,`id_kt_tn`) VALUES
                                (NULL, '$cau_hoi', '$cau_a', '$cau_b', '$cau_c','$cau_d','$dap_an','$lay_idkt')";
                                if (mysqli_query($link, $sql)) {
                                    echo '<script>alert("Tạo câu hỏi thành công")</script>';
                                } else {
                                    echo '<script>alert("Tạo câu hỏi thất bại")</script>';
                                }
                            }
                            break;

                        case 'Chỉnh sửa': {
                                if (empty($_POST['cau_hoi']) || empty($_POST['cau_a']) || empty($_POST['cau_b']) || empty($_POST['cau_c']) || empty($_POST['cau_d']) || empty($_POST['dap_an'])) {
                                    echo '<script>alert("Vui lòng chọn câu hỏi")</script>';
                                    exit();
                                }
                                $cau_hoi = $_POST['cau_hoi'];
                                $cau_a = $_POST['cau_a'];
                                $cau_b = $_POST['cau_b'];
                                $cau_c = $_POST['cau_c'];
                                $cau_d = $_POST['cau_d'];
                                $dap_an = $_POST['dap_an'];
                                $link = $p->connect();
                                $sql = "UPDATE `trac_nghiem` SET `cau_hoi` = '$cau_hoi', `cau_a` = '$cau_a', `cau_b` = '$cau_b',`cau_c` = '$cau_c',`cau_d` = '$cau_d',`dap_an` = '$dap_an' WHERE `trac_nghiem`.`id` = '$lay_id'";
                                if (mysqli_query($link, $sql)) {
                                    echo '<script>alert("Chỉnh sửa câu hỏi thành công")</script>';
                                } else {
                                    echo '<script>alert("Chỉnh sửa câu hỏi thất bại")</script>';
                                }
                            }
                            break;

                        case 'Xóa': {
                                if (empty($_POST['cau_hoi']) || empty($_POST['cau_a']) || empty($_POST['cau_b']) || empty($_POST['cau_c']) || empty($_POST['cau_d']) || empty($_POST['dap_an'])) {
                                    echo '<script>alert("Vui lòng chọn câu hỏi")</script>';
                                    exit();
                                }
                                $cau_hoi = $_POST['cau_hoi'];
                                $cau_a = $_POST['cau_a'];
                                $cau_b = $_POST['cau_b'];
                                $cau_c = $_POST['cau_c'];
                                $cau_d = $_POST['cau_d'];
                                $dap_an = $_POST['dap_an'];
                                $link = $p->connect();
                                $sql = "DELETE FROM `trac_nghiem` WHERE id='$lay_id'";
                                if (mysqli_query($link, $sql)) {
                                    echo '<script>alert("Xóa câu hỏi thành công")</script>';
                                    header("refresh:2;url=gv_tao_kt_trac_nghiem.php");
                                } else {
                                    echo '<script>alert("Xóa thất bại")</script>';
                                }
                            }
                            break;
                    }
                }

                ?>

                <?php
                if(isset($_REQUEST['id_kt'])){
                $q->load_cau_hoi($p->connect(), "SELECT * FROM `trac_nghiem` WHERE id_kt_tn='$lay_idkt' ORDER BY id DESC");exit();
                }else{
                    $q->load_cau_hoi($p->connect(), "SELECT * FROM `trac_nghiem` WHERE id_kt_tn='$id_k' ORDER BY id DESC");exit();
                }

                ?>

            </div>
        </div>
    </div>

    <script src="../js/script.js"></script>

</body>

</html>