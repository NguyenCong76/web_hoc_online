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
include("../php_excel/SimpleXLSXGen.php");
include("../includes/sql.php");
$q = new sql();
$id_gv = $p->laycot($p->connect(), "SELECT ID_User FROM `taikhoan` WHERE ID=" . $_SESSION['id'] . "");

if (isset($_POST['file'])) //bấm nút xuất file
{
    if (isset($_POST['khoa'])) {
        //var_dump($_POST);exit();
        $id_k = $_POST['khoa'];
        $ten = $q->laycot($p->connect(), "SELECT Ten_khoa FROM `khoa_hoc` WHERE ID_khoa='$id_k'");
        $diem = [
            ['STT', 'Mã học sinh', 'Họ và Tên', 'Kết quả', 'Tên bài kiểm tra', 'Hình thức kiểm tra']
        ];

        //SELECT * FROM `bai_kt_trac_nghiem` AS a JOIN `kiemtra_tl` AS b ON a.ID_khoa=b.ID_khoahoc WHERE ID_khoa='$id_k'

        //var_dump($row1);exit();
        if (isset($_POST['tl'])) {
            switch ($_POST['tl']) {
                case 'Tự luận': {
                        $id = 0;
                        $kq = mysqli_query($p->connect(), "SELECT * FROM `bai_kt_trac_nghiem` AS a JOIN `kiemtra_tl` AS b ON a.ID_khoa=b.ID_khoahoc  WHERE ID_khoa='$id_k'");
                        while ($row1 = mysqli_fetch_array($kq)) {
                            $result = mysqli_query($p->connect(), "SELECT * FROM `bang_diem_tn` WHERE ID_KT=" . $row1['ID_KT'] . " AND theloai='Tự luận'"); //" . $row1['ID_KT'] . "
                            //SELECT Ten_HS,Toan,NguVan,TiengAnh FROM `bang_diem_tn` JOIN `khoa_hoc` on `bang_diem_tn`.ID_khoa=`khoa_hoc`.ID_khoa WHERE Ten_khoa ='$ten'
                            $i=mysqli_num_rows($result);
                            if ($i > 0) {
                                foreach ($result as $row){
                                    $id++;
                                    $diem=array_merge($diem, array(array($id, $row['ID_HS'], $row['Ten_hs'],
                                     unserialize(base64_decode($row['Ket_qua'])), $row['Ten_kt'], $row['theloai'])));
                                    
                                }
                          
                                $xlsx = SimpleXLSXGen::fromArray($diem);
                            $xlsx->downloadAs('diemtuluan.xlsx');
                        
                            }
                          
                            
                       }
                        
                    }
                    break;
                case 'Trắc nghiệm': {
                        $ids = 0;
                        $kq = mysqli_query($p->connect(), "SELECT * FROM `bai_kt_trac_nghiem` AS a JOIN `kiemtra_tl` AS b ON a.ID_khoa=b.ID_khoahoc  WHERE ID_khoa='$id_k'");
                        while ($row1 = mysqli_fetch_array($kq)) {
                            $result1 = mysqli_query($p->connect(), "SELECT * FROM `bang_diem_tn` WHERE ID_KT=" . $row1['id_kt_tn'] . " AND theloai='Trắc nghiệm'");
                            if (mysqli_num_rows($result1) > 0) {
                                foreach ($result1 as $row2){
                                    $ids++;
                                    $diem = array_merge($diem, array(array($ids, $row2['ID_HS'], $row2['Ten_hs'],
                                     unserialize(base64_decode($row2['Ket_qua'])), $row2['Ten_kt'], $row2['theloai']))); 
                                }
                            }
                            $xlsx = SimpleXLSXGen::fromArray($diem);
                        $xlsx->downloadAs('diemtracnghiem.xlsx');
                        }
                        
                        
                    }
                    break;
            }
        } else {
            echo 'Vui lòng chọn trắc nghiệm hoặc tự luận.';
        }
        //exit();

    } else {
        echo 'Vui lòng chọn  khóa học cần xuất điểm.';
        exit();
    }
}



/* foreach ($result as $row) {
                          $id++;
                       
                           $diem1=array_merge($diem,array(array($id, $row['ID_HS'],$hten=$q->layten($row['ID_HS']), $row['Ket_qua'],$tenkt=$q->layten_kt($row['ID_KT']), $row['theloai'])));
                      }
                     // print_r($diem1);exit();
                      $xlsx = SimpleXLSXGen::fromArray($diem1);
                      $xlsx->downloadAs('diem.xlsx'); */
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
                                <div class="dropdown-menu">
                                  <a href="../hocsinh/doi_pass.php" class="dropdown-item"><i class="fa fa-lock" aria-hidden="true"></i> Đổi mật khẩu</a>
                                  <a href="../logout.php" class="dropdown-item"><i class="fa fa-arrow-right" aria-hidden="true"></i></i> Đăng xuất</a>
                                </div>
                              </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="course" class="container-fluid bg-light">
    <form action="" method="POST">
        <?php
        $q->loadcombo_khoa($p->connect(), "SELECT * FROM `khoa_hoc` WHERE ID_GV='$id_gv'");
        ?>
        <br><br>
         <h3>Hình thức:</h3>
            <input type="radio" name="tl" value="Tự luận">Tự luận
            <input type="radio" name="tl" value="Trắc nghiệm">Trắc nghiệm
    
        <button type="submit" name="file" class="btn btn-success">Xuất File Excel</button>
       
    </form>
    </div>
  </div>
  </div>

  <script src="../js/script.js"></script>
  </body>
</html>