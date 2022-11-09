<?php
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
  include('../includes/sql.php');
  $q=new sql();
  $lay_id='';
  if(isset($_GET['id']))
  {
    $lay_id=unserialize(base64_decode($_GET['id']));
  }
  $email=$_SESSION['user'];
 $id_gv=$q->laycot($p->connect(),"SELECT ID_User FROM `taikhoan` WHERE Email='$email'");
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
            <form action="" method="POST">
            <div class="row">
                      <div class="col-4"><button type="submit" class="btn btn-success " name="nut" value="danhsach">Danh sách </button></div>
                      <div class="col-4"><button type="submit" class="btn btn-info" name="nut" value="ketqua">Kết quả</button></div>
                      <div class="col-4"><button type="submit" class="btn btn-danger" name="nut" value="chuanop">Thiếu bài</button></div>
                    </div>
            </form>
            <?php
            if(isset($_POST['nut']))
            {
                switch($_POST['nut'])
                {
                    case'danhsach':
                        {
                          $kh_hoc="SELECT ID_khoa FROM `khoa_hoc` WHERE ID_GV='$id_gv'";
                            $kq_k=mysqli_query($p->connect(),$kh_hoc);
                            while($row=mysqli_fetch_array($kq_k))
                            {
                                $hocsinh_kh="SELECT ID_HS FROM `hocsinh_khoahoc` WHERE ID_khoa=".$row['ID_khoa']."";
                                $ten_khoa=$q->laytenkhoa($row['ID_khoa']);
                                $kq=mysqli_query($p->connect(),$hocsinh_kh);
                                echo "<br><h3 > Khóa học: $ten_khoa </h3><br>
                                <table class='table'>
                                <thead>
                                        <tr style='background-color:blue; color: white;'>
                                          <td>STT</td>
                                          <td>Họ và tên</td>
                                          <td>Giới tính</td>
                                          <td>Email</td>
                                          <td>Địa chỉ</td>
                                        </tr></thead>";
                                        $j=1;
                                while($row1=mysqli_fetch_array($kq))
                                { 
                                    $sql="SELECT * FROM `hoc_sinh` WHERE ID_HS=".$row1['ID_HS']."";
                                    $ketqua=mysqli_query( $p->connect(),$sql);
                                    @mysqli_close($p->connect());
                                     $i=@mysqli_num_rows ($ketqua);
                                    
                                      if ($i>0)	
                                      { 
                                        while ($row= @mysqli_fetch_array($ketqua))
                                            {
                                              $id=$row['ID_HS'];
                                              $ten=$row['Tên_HS'];
                                              $gt=$row['Giới tính'];
                                                $dc=$row['DC'];
                                              $email=$row['Email'];
                                              echo "<tbody><tr>
                                                  <td>$j</td>
                                                  <td>$ten</td>
                                                  <td>$gt</td>
                                                  <td>$email</td>
                                                  <td>$dc</td>
                                                </tr></tbody>";
                                                $j++;
                                            }
                                      }
                                }
                                echo '</table>';
                            }
                        }break;
                    case'ketqua':
                        {
                          echo 'kết quả';
                          
                        }break;
                    case'chuanop':
                        {
                           echo'bài chưa nộp';
                        }break;

                }
            }
            ?>
            </div>
        </div>
    </div>
    </div>
    
    <script src="../js/script.js"></script>

</body>

</html>