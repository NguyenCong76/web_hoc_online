<?php
session_start();
ob_start();
//nếu là học sinh
$con = mysqli_connect("localhost", "root", "", "hoc_online");
if (isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['id_user']) && isset($_SESSION['ss']) && isset($_SESSION['hs'])) {
    include("../confid.php");
    $p = new login();
    $p->confirm_hs($_SESSION['id_user'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
} else if (isset($_SESSION['user_token'])) {
    // header('location:../index.php');
}
//nếu là giáo viên
else if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['ss']) && isset($_SESSION['gv'])) {
    include("../confid.php");
    $p = new login();
    $p->confirm_gv($_SESSION['id'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
} else {
    header('location:../login.php');
}
include("../includes/sql.php");
$q = new sql();
$lay_id = '';
$id_gv = '';
if (isset($_GET['ids'])) {
    $lay_id = unserialize(base64_decode($_GET['ids']));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết khóa học</title>
    <link rel="stylesheet" href="../css/style_course.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

</head>
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
                    <a href="kiemtra.php"><i class="fas fa-pencil-ruler"></i> Kiểm tra</a>
                </li>
                <li>
                    <a href="hs_diemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
                </li>
                <li>
                    <a href="../payment/index.php"><i class="fas fa-dollar-sign"></i> Đóng học phí</a>
                </li>
                <li>
                    <a href="doi_pass.php"><i class="fa fa-setting" aria-hidden="true"></i>Thay đổi mật khẩu</a>
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
                <br>
                <div class="row">
                    <div class="col-sm-6">
                        <h3 style="color:royalblue;">Chi tiết khóa học: <?php echo $q->laycot($con, "SELECT Ten_khoa FROM `khoa_hoc` WHERE ID_khoa='$lay_id'"); ?></h3>
                    </div>
                    <div class="col-sm-6">
                        <div id="MyClockDisplay" class="clock" onload="showTime()"></div>
                    </div>
                </div>
                <hr>
                <h4>Giáo viên phụ trách: <p style="color:royalblue;"><?php $id_gv = $q->laycot($con, "SELECT ID_GV FROM `khoa_hoc` WHERE ID_khoa='$lay_id'");
                                                                        echo $q->laycot($con, "SELECT Ten_GV FROM `giao_vien` WHERE ID_GV='$id_gv'");
                                                                        ?></p>
                </h4>
                <h4>Thời gian: <p style="color:royalblue;"><?php echo $q->laycot($con, "SELECT thoigian FROM `khoa_hoc` WHERE ID_khoa='$lay_id'"); ?></p>
                </h4>
                <h4>Giới thiệu sơ lược: <p style="color:royalblue;"><?php echo $q->laycot($con, "SELECT mota FROM `khoa_hoc` WHERE ID_khoa='$lay_id'"); ?></p>
                </h4>
                <form action="" method="post">
                    <input type="text" class="form-control" name="binhluan">
                    <input type="submit" class="btn btn-info" name="nut" value="Bình Luận">
                    <input type="reset" class="btn btn-danger" name="nut" value="Hủy">
                </form>
                <?php
                $bl = '';
                if (isset($_POST['nut'])) {
                    switch ($_POST['nut']) {
                        case 'Bình Luận': {
                                $bl = $_POST['binhluan'];
                                if ($bl == '') {
                                    header("location:chitiet_khoahoc.php?ids=" . $_GET['ids'] . "");
                                    exit();
                                } else {
                                    if (isset($_SESSION['id_user'])) {
                                        $sql = "INSERT INTO `binhluan_khoahoc` (`ID_bl`, `ID_HS`, `ID_khoa`, `noidung`, `thoigian`) VALUES
                     (NULL, " . $_SESSION['id_user'] . ",'.$lay_id.','$bl', current_timestamp())";
                                    } else {
                                        $id_user = $q->laycot($con, "SELECT ID_User FROM `taikhoan` WHERE token=" . $_SESSION['user_token'] . ""); //$_SESSION['user_token'];
                                        $sql = "INSERT INTO `binhluan_khoahoc` (`ID_bl`, `ID_HS`, `ID_khoa`, `noidung`, `thoigian`) VALUES
                     (NULL, '$id_user','.$lay_id.','$bl', current_timestamp())";
                                    }
                                    if (mysqli_query($con, $sql)) {
                                        echo 'bình luận thành công.';
                                        header("refresh:2;url=chitiet_khoahoc.php?ids=" . $_GET['ids'] . "");
                                    } else {
                                        echo 'bình luận thất bại';
                                    }
                                }
                            }
                            break;
                    }
                }
                ?>
                <?php
                //xuất bình luận

                $q->xuat_bl($con, $lay_id);

                ?>
            </div>
        </div>
    </div>
    </div>

    <script src="../js/script.js"></script>
    <script src="../clock_js/dist/script.js"></script>
</body>

</html>