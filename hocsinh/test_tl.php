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
 $lay_ids=$id_kt='';
 if(isset($_GET['ids']))
  {
    $lay_ids=unserialize(base64_decode($_GET['ids']));
  }

  if(isset($_GET['id_kt']))
  {
    $id_kt=unserialize(base64_decode($_GET['id_kt']));
  }

  if(!isset($_SESSION['batdau'])==true)
  {
    header("location:all_khoahoc.php");
  }
 $phut=$q->laycot($p->connect(),"SELECT thoi_luong FROM `kiemtra_tl` WHERE ID_KT='$id_kt'");


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="un-refresh" content="number">

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kiểm tra tự luận</title>
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
    font-size: 15px;
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
               <div class="col-sm-6"><h3>Chào mừng đến với bài kiểm tra:</h3></div>
              <div class="col-sm-6">
                <div class="clock"> 
                    <p>thời gian làm bài</p>
                    <b>Thời gian làm bài:</b>
             <span id='m'>Phút</span> Phút :
             <span id='s'>Giây</span> Giây.
                </div>
              </div>
            </div>
  <br>
  <?php

 /* $kq=mysqli_query($p->connect(),"SELECT ID_khoa FROM `hocsinh_khoahoc` WHERE ID_HS=".$_SESSION['id_user']."");//lấy id khóa học mà học sinh đang tham gia.
  while ($row = @mysqli_fetch_array($kq))
  {
  $q->load_test($p->connect(),"SELECT * FROM `kiemtra_tl` WHERE ID_khoahoc=".$row['ID_khoa']."");
 }*/
  ?>
  <table style="border:1px solid black;">
    <tr>
      <td>Tên bài kiểm tra:</td>
      <td><?php echo $q->laycot($p->connect(),"SELECT Ten_KT FROM `kiemtra_tl` WHERE ID_KT='$id_kt'");?></td>
    </tr>
    <tr>
      <td>Nội dung :</td>
      <td><textarea  cols="auto" rows="auto"><?php echo $q->laycot($p->connect(),"SELECT noidung FROM `kiemtra_tl` WHERE ID_KT='$id_kt'"); ?></textarea></td>
    </tr>
    <tr>
      <td>Thời gian làm bài:</td>
      <td><?php echo $q->laycot($p->connect(),"SELECT thoi_luong FROM `kiemtra_tl` WHERE ID_KT='$id_kt'");?> phút</td>
    </tr>
    <tr>
      <td>Lưu ý:</td>
      <td><?php echo $q->laycot($p->connect(),"SELECT ghichu FROM `kiemtra_tl` WHERE ID_KT='$id_kt'");?></td>
    </tr>
  </table>
  <form action="" method="POST">
    <br><input type="submit" class="btn btn-info" name="nutfile" value="File"> 
  </form><br>
  <input type="button"  data-toggle="modal" data-target="#myModal"  class="btn btn-danger" value="Nộp bài">
  <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title">Nộp bài kiểm tra</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="xuli_test.php" method="POST" enctype="multipart/form-data">
                              <div class="form-group">
                                <label for="">Tiêu đề nộp bài:</label>
                                <input type="text"  class="form-control"  name="tieude">
                              </div>
                              <div class="form-group">
                                <label for="">File nội dung làm bài:</label>
                                <input type="file" class="form-control" name="file"><br>
                                <i>(Chỉ nhận file định dạng .pdf)</i>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="nut1" value="Nộp bài" class="btn btn-success ">
                                  Xác nhận nộp bài
                                </button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal" class="btn btn-danger">
                                  Hủy
                                </button>
                              </div>
                          </form>
                          </div>
                        </div>
                      </div>
                    </div>
</div>
  <?php 
  include("../includes/downloadfile.php");
  if(isset($_POST['nutfile']))
  {
        set_time_limit(0);
        $ten_file=$q->laycot($p->connect(),"SELECT file FROM `kiemtra_tl` WHERE ID_KT='$id_kt'");
        $file_path="../file/$ten_file";
        output_file($file_path,$ten_file,"application/pdf");
  }
  $_SESSION['id_kt']=$id_kt;//??
  ?>
<br>
<i>(Học sinh thực hiện đúng nội quy kiểm tra của giáo viên đã quy định.)</i><br>
<i>(Thời gian làm bài và nộp bài sẽ theo thời lượng làm bài + 15 phút để nộp bài lên hệ thống.)</i><br>
<i>Lưu ý : khi vượt qua thời hạn học sinh sẽ không thể nộp bài được.</i>
</div>
</div>
        
        <script language="javascript">

var h = null; // Giờ
var m = null; // Phút
var s = null; // Giây

var timeout = null; // Timeout

function start()
{
    if (h === null)
{
  // h = parseInt(document.getElementById('h_val').value);
  //  m = parseInt(document.getElementById('m_val').value);
  //  s = parseInt(document.getElementById('s_val').value);
  h= 0;
    m= <?php echo $phut;?> ;
    s= 0 ;
}

/*BƯỚC 1: CHUYỂN ĐỔI DỮ LIỆU*/
// Nếu số giây = -1 tức là đã chạy ngược hết số giây, lúc này:
//  - giảm số phút xuống 1 đơn vị
//  - thiết lập số giây lại 59
if (s === -1){
    m -= 1;
    s = 59;
}

// Nếu số phút = -1 tức là đã chạy ngược hết số phút, lúc này:
//  - giảm số giờ xuống 1 đơn vị
//  - thiết lập số phút lại 59
if (m === -1){
    h -= 1;
    m = 59;
}

// Nếu số giờ = -1 tức là đã hết giờ, lúc này:
//  - Dừng chương trình
if (h == -1){
    clearTimeout(timeout);
    alert('Hết giờ làm bài ! bạn có 15 phút để thực hiện nộp bài.');
    return false;
}

/*BƯỚC 1: HIỂN THỊ ĐỒNG HỒ*/
//document.getElementById('h').innerText = h.toString();
document.getElementById('m').innerText = m.toString();
document.getElementById('s').innerText = s.toString();

/*BƯỚC 1: GIẢM PHÚT XUỐNG 1 GIÂY VÀ GỌI LẠI SAU 1 GIÂY */
timeout = setTimeout(function(){
    s--;
    start();
}, 1000);

}
start();

</script>

</body>
</html>