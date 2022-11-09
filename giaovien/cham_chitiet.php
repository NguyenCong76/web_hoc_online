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
include("../includes/sql.php");
$q=new sql();
$id_kt='';
$id_ng='';
$file='';
  if(isset($_GET['id']))
  {
    $id_kt=unserialize(base64_decode($_GET['id']));
   $ten_kt=$q->laycot($p->connect(),"SELECT Ten_KT FROM `kiemtra_tl` WHERE ID_KT='$id_kt'");
  }
  if(isset($_GET['ids']))
  {
    $id_ng=unserialize(base64_decode($_GET['ids']));
  }

?>
<?php
if(isset($_POST['xacnhan']))
{
    switch($_POST['xacnhan'])
    {
        case'Xác nhận':
            {
                $diem=$_POST['diem'];
                $sau=$_POST['sau'];
                $nhanxet=$_POST['nhanxet'];
             
                //$id_k=$q->laycot($p->connect(),"SELECT ID_khoahoc FROM `kiemtra_tl` WHERE ID_KT='$id_kt'"); //lấy id_khoa trong bảng kiemtra_tl
                $ten=$q->laycot($p->connect(),"SELECT Tên_HS FROM `hoc_sinh` WHERE ID_HS='$id_ng'");//lấy tên hs từ id_hs 
                //INSERT INTO `bang_diem` (`ID`, `ID_khoa`, `ID_HS`, `Ten_HS`, `Ket_qua`, `nhanxet`) 
                //VALUES (NULL, '1', '1', 'ahdcwqd', 'dasadsadsa', 'helolo');
                if($diem==''&& $nhanxet=='')
                {
                    echo "<script>alert('Cần nhập đủ trường điểm và nhận xét bài kiểm tra !')</script>";
                }else{
                    if($diem==10)
                    {
                        $kq=$diem.".".'0';
                    }else{ 
                        $kq=$diem.".".$sau;
                    }

                   /* echo $ten;
                    echo $id_k;
                    echo $id_ng;
                    echo Base64_encode(serialize($kq));
                    echo $nhanxet;exit();*/
                    $kq=Base64_encode(serialize($kq));
                $sql="INSERT INTO `bang_diem_tn` (`ID`, `ID_KT`, `ID_HS`, `Ket_qua`,`nhanxet`,`thoigian_tao`,`theloai`,`Ten_hs`,`Ten_kt`) 
                VALUES (NULL, '$id_kt', '$id_ng','$kq', '$nhanxet',current_timestamp(),'Tự luận','$ten','$ten_kt')";
                if(mysqli_query($p->connect(),$sql))
                 {
                    if(mysqli_query($p->connect(),"UPDATE `nop_kt` SET `trangthai` ='đã chấm' WHERE ID_HS = '$id_ng'"))
                    {
                        echo "<script>alert('Chấm bài nhập điểm thành công!')</script>";
                        header("refresh:3;url=chamdiem_tl.php?id=".$_GET['id']."");
                    }
            
                 }
                 else
                 {
                    echo "<script>alert('Chấm bài nhập điểm không thành công!')</script>"; 
                 }
                }

            }break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chấm bài học sinh</title>
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
          <a href="taodiemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
        </li>
        <li>
          <a href="#"><i class="fas fa-chart-bar"></i> Thống kê</a>
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
            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <i class="fas fa-align-justify"></i>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav navbar-nav ml-auto">
              <li class="nav-item ">
                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
              </li>
              <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fas fa-comment" aria-hidden="true"></i></a>
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
    <form action="" method="POST">
        <table class="table">
            <tr>
                <td>Điểm số</td>
                <td>Nhận xét</td>
            </tr>
            <tr>
                <td style="color:red;">
                <select name='diem' style="color:red;">
                <option value=''>Chọn điểm</option>
                    <option value='10'>10</option>
                    <option value='9'>9</option>
                    <option value='8'>8</option>
                    <option value='7'>7</option>
                    <option value='6'>6</option>
                    <option value='5'>5</option>
                    <option value='4'>4</option>
                    <option value='3'>3</option>
                    <option value='2'>2</option>
                    <option value='1'>1</option>
                    <option value='0'>0</option>
                </select>,<select name='sau'  style="color:red;">
                    <option value='0'>0</option>
                    <option value='9'>9</option>
                    <option value='8'>8</option>
                    <option value='7'>7</option>
                    <option value='6'>6</option>
                    <option value='5'>5</option>
                    <option value='4'>4</option>
                    <option value='3'>3</option>
                    <option value='2'>2</option>
                    <option value='1'>1</option>
                </select></td>
                <td><textarea name="nhanxet" id="" cols="25" rows="3" placeholder="Nhập nhận xét bài kiểm tra ..."></textarea></td>
            </tr>
            <tr>
                <td>Tên bài nộp</td>
                <td><?php echo $q->laycot($p->connect(),"SELECT Tieu_de FROM `nop_kt` WHERE ID_HS='$id_ng' AND ID_KT='$id_kt'"); ?></td>
            </tr>
            <tr>
                <td>Thư mục nội dung</td>
                <td><?php echo $file=$q->laycot($p->connect(),"SELECT File FROM `nop_kt` WHERE ID_HS='$id_ng' AND ID_KT='$id_kt'");
                if(isset($_POST['file']))
                {
                  include("../includes/downloadfile.php");
                  set_time_limit(0);
                  $file_path="../file/$file";
                  output_file($file_path,$file,"application/pdf");
                }
                ?><br><input type="submit" class="btn btn-info" name="file" value="tải bài làm"></td>
            </tr>
        </table>
        <button type="button" class="btn btn-info" data-toggle="modal"
                data-target="#myModal">Lưu kết quả</button>
    <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title">Hoàn thành nhập điểm </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Xác nhận nhập điểm !</p>
                          </div>
                          <div class="modal-footer">
                                <button type="submit" id="btnSave" name="xacnhan" value="Xác nhận" class="btn btn-success ">
                                  Xác nhận
                                </button>
                              </div>

                        </div>
                      </div>
                    </div>
            </form>
      </div>
    </div>
</div> 
</body>
</html>