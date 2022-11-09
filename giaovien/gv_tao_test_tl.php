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
    if(!isset($_SESSION['id_bam'])){       //kiểm tra nếu chưa có thì gán để dùng cho dòng 138
      $_SESSION['id_bam'] =$lay_id;
     }
  }
  if(isset($_GET['ids']))
  {
    $lay_ids=unserialize(base64_decode($_GET['ids']));
  }
 $pass_user=$_SESSION['pass'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giao diện tạo kiểm tra</title>
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
        <div class="col-sm-6">
          <h3 class="pt-2">Tạo bài kiểm tra tự luận</h3>
        </div>
        <hr>
        <form action="" method="POST" enctype="multipart/form-data">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="">Tên bài kiểm tra</label>
              <input type="text" class="form-control" name="ten" id="" value="<?php if(isset($lay_ids)){
                echo  $q->laycot($p->connect(),'SELECT Ten_KT FROM `kiemtra_tl` WHERE ID_KT='.$lay_ids.'');
                }
                ?>" placeholder="Nhập tên bài kiểm tra">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="">Nội dung bài kiểm tra</label>
              <textarea class="form-control" name="nd" id=""> <?php if(isset($lay_ids)){
                echo  $q->laycot($p->connect(),'SELECT noidung FROM `kiemtra_tl` WHERE ID_KT='.$lay_ids.'');
                }
                ?></textarea>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="">Thời lượng bài kiểm tra</label>
              <input type="datetime" class="form-control" placeholder="Nhập số phút kiểm tra" name="tg" id="" value="<?php if(isset($lay_ids)){
                echo  $q->laycot($p->connect(),'SELECT thoi_luong FROM `kiemtra_tl` WHERE ID_KT='.$lay_ids.'');
                }
                ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="">Ghi chú</label>
              <input type="text" class="form-control" name="note" id="" placeholder="Nhập nhắc nhở học sinh" value="<?php if(isset($lay_ids)){
                echo  $q->laycot($p->connect(),'SELECT ghichu FROM `kiemtra_tl` WHERE ID_KT='.$lay_ids.'');
                }
                ?>">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label for="upfile">Tải tài liệu lên (nếu có)</label>
              <input type="file" name="file" class="form-control-file" id="upfile">
            </div>
          </div>
          <div class="row">
            <div class="col-3"><button type="submit" class="btn btn-primary " name="nut" value="tao">Tạo bài kiểm tra</button></div>
            <div class="col-3"><button type="submit" class="btn btn-primary " name="nut" value="sua">Sửa bài kiểm tra</button></div>
            <div class="col-3"><button type="submit" class="btn btn-primary " name="nut" value="xoa">Xóa bài kiểm tra</button></div>
            <div class="col-3"><button type="submit" class="btn btn-danger " name="nut" value="huy">Hủy</button></div>
          </div>
            <br>
          <button class="btn btn-warning text-white" name="ds" value="danhsach" type="button" data-toggle="modal"
                data-target="#myModal">Danh sách bài kiểm tra đã tạo</button>
        
        </form>

                    <div class="modal fade" id="myModal" role="dialog">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title">Nhập mật khẩu tài khoản </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                          <form action="" method="GET">
                              <div class="form-group">
                                <label for="exampleInputEmail1">Nhập mật khẩu</label>
                                <input type="password" class="form-control" name="nhap" placeholder="nhập mật khẩu tài khoản...">
                              </div>
                              <div class="modal-footer">
                                <button type="submit" id="btnSave" name="xacnhan" value="Xác nhận" class="btn btn-success ">
                                  Xác nhận
                                </button>
                              </div>
                          <form>
                          </div>
                        </div>
                      </div>
                    </div>
        <?php
        if(isset($_SESSION['xacnhan'])==true){ /// Điều kiện nếu xác nhận nhận đúng
          $q->load_test($p->connect(),"SELECT * FROM `kiemtra_tl` WHERE ID_khoahoc=".$_SESSION['id_bam']."");
         }
        ?>
      </div>
    </div>
  </div>
  </div>
  <?php
$ten=$nd=$tg=$note='';
if(isset($_POST['nut']))
switch($_POST['nut'])
{
    case'tao':
        {
        // var_dump($_POST);
        $ten=$_POST['ten'];
        $nd=$_POST['nd'];
        $tg=$_POST['tg'];
        $note=$_POST['note'];
        $name=$_FILES['file']['name'];
        $type=$_FILES['file']['type'];
        $size=$_FILES['file']['size'];
        $tmp_name=$_FILES['file']['tmp_name'];
       
        if($name!=''&& $type=='application/pdf')
        {
          $q->upload($name,$tmp_name,"../file");
        }
$sql="INSERT INTO `kiemtra_tl` (`ID_KT`, `Ten_KT`, `thoi_gian`, `thoi_luong`, `ID_khoahoc`, `noidung`, `file`,`ghichu`) VALUES
(NULL, '$ten', current_timestamp(), '$tg', '$lay_id', '$nd','$name','$note')";
               if(empty($ten)||empty($nd) || empty($tg)|| empty($note))
               {
                $erro='Hãy nhập đủ các thông tin quan trọng.'; 
               }else{
                if(mysqli_query($p->connect(),$sql))
                {
                  $erro= 'Tạo bài kiểm tra thành công.';
                }
                else{
                  $erro= 'tạo thất bại.';
                }
               }
        }break;
    case'sua':
        {
        $ten=$_POST['ten'];
        $nd=$_POST['nd'];
        $tg=$_POST['tg'];
        $note=$_POST['note'];
        $name=$_FILES['file']['name'];
        $type=$_FILES['file']['type'];
        $size=$_FILES['file']['size'];
        $tmp_name=$_FILES['file']['tmp_name'];
       
        if($name!=''&& $type=='application/pdf')
        {
          $q->upload($name,$tmp_name,"../file");
        }
$sql="UPDATE `kiemtra_tl` SET `Ten_KT` = '$ten', `thoi_luong` = '$tg', `noidung` = '$nd', `file` = '$name', `ghichu` = '$note' 
WHERE `kiemtra_tl`.`ID_KT` = '$lay_ids';";
               if(empty($ten)||empty($nd) || empty($tg)|| empty($note))
               {
                $erro='Hãy nhập đủ các thông tin quan trọng để cập nhật.'; 
               }else{
                if(mysqli_query($p->connect(),$sql))
                {
                    $erro= 'Cập nhật bài kiểm tra thành công.';
                }
                else{
                    $erro='Cập nhật thất bại.';
                }
               }
         
        }break;

    case'xoa':
        {
          if($lay_ids!=''){
          $sql="DELETE FROM `kiemtra_tl` WHERE `kiemtra_tl`.`ID_KT` = '$lay_ids'";
          if(mysqli_query($p->connect(),$sql))
          {
            $erro='Đã xóa thành công bài kiểm tra.';
          }else
          {
            $erro="Xóa thất bại.";
          }
        }else
        {
          $erro="Chưa chọn bài kiểm tra.";
        }
        }break;
      case'huy':
        {
         header("location:tao_test_tl.php");
        }break;
        
}

  if(isset($_GET['xacnhan']))
  {
      $nhap=md5($_GET['nhap']);
      if($nhap==$pass_user)
      {
      //load tất cả bài kiểm tra đã Tạo
      $_SESSION['xacnhan']=true;  // đúng
      header("location:gv_tao_test_tl.php?id=".Base64_encode(serialize($_SESSION['id_bam']))."");   //sau khi đã xác thực thành công. 
       
      }else{
          $erro='Mật khẩu không chính xác.';   // sai
      }
  }

?>

<?php
if(!empty($erro)){    /// Điều kiện nếu xác nhận nhận sai 
echo "<script type='text/javascript'>alert('$erro');</script>";
}

?>
  <script src="../js/script.js"></script>

</body>

</html>