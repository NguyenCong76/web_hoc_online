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
$lay_id='';
  if(isset($_GET['id']))
  {
    $lay_id=unserialize(base64_decode($_GET['id']));
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chấm bài</title>
    <link rel="stylesheet" href="../css/style_course.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <h3>Hãy chọn khóa học để chấm bài:</h3>
  <?php
  $mail=$_SESSION['user'];
   $sql="SELECT ID_GV FROM `giao_vien` WHERE Email='$mail'";
   $id_gv= $p->laycot($p->connect(),$sql);
  
  ?>
  <form action="" method="POST">
    <?php
        $q->loadcombo_khoa($p->connect(),"SELECT ID_khoa,Ten_khoa FROM `khoa_hoc` WHERE ID_GV='$id_gv'");
    ?>
    <input type="submit" name ='nut' value='Xem danh sách các bài kiểm tra'>
  </form>
  <br><h3>  Danh sách các bài chưa chấm điểm :</h3>
  <?php
  if(isset($_POST['nut']))
  {
    //var_dump($_POST);exit();
    if(isset($_POST['khoa']))
    {
    
      $sql="SELECT * FROM `kiemtra_tl` WHERE ID_khoahoc=".$_POST['khoa']."";
      $kq=mysqli_query($p->connect(),$sql);
      $i=@mysqli_num_rows($kq);
      if($i>0)
          {
            echo "<table class='table'>
            <tr>
              <td>Tên bài kiểm tra </td>
              <td>Thời gian diễn ra</td>
              <td>Thời lượng làm bài</td>
              <td>Nội dung</td>
              <td>File đề (Nếu có)</td>
              <td>Ghi chú</td>
            </tr>
          ";
          while($row=mysqli_fetch_array($kq))
          {
            $id_kt = $row['ID_KT'];
            $ten = $row['Ten_KT'];
            $tg = $row['thoi_gian'];
            $tl = $row['thoi_luong'];
            $nd= $row['noidung'];
            $de= $row['file'];
            $note= $row['ghichu'];
            echo " <tr>
            <td>$ten</td>
            <td>$tg</td>
            <td>$tl</td>
            <td>$nd</td>
            <td>$de</td>
            <td>$note</td>
            <td><a href='?id=".Base64_encode(serialize($id_kt))."'>Chọn</a></td>
          </tr>";
          }
          echo "</table>";
          }
      else
          {
            echo 'Vui lòng chọn khóa học';
          }
    }
  }
  ?>
  <?php
   if($lay_id!='')
   {
    $sql="SELECT * FROM `nop_kt` WHERE ID_KT='$lay_id' AND trangthai='chưa chấm'";
    $kq=mysqli_query($p->connect(),$sql);
    $i=@mysqli_num_rows($kq);
    if($i>0)
    {
      echo "<table class='table'>
      <tr>
        <td>Người nộp bài  </td>
        <td>Tên bài làm</td>
        <td>File nộp bài</td>
        <td>Thời gian diễn ra</td>
        <td></td>
      </tr>
    ";
    while($row=mysqli_fetch_array($kq))
    {
      $id_t = $row['ID_KT'];
      $id_ng=$row['ID_HS'];
            $tieu_d = $row['Tieu_de'];
            $noi_d = $row['File'];
            $time = $row['thoi_gian'];
            $k=$q->laycot($p->connect(),"SELECT Tên_HS FROM `hoc_sinh` WHERE ID_HS='$id_ng'");
      echo"
      <tr>
        <td>$k</td>
        <td>$tieu_d</td>
        <td>$noi_d</td>
        <td>$time</td>
        <td><button><a href='cham_chitiet.php?id=".Base64_encode(serialize($id_t))."&ids=".Base64_encode(serialize($id_ng))."'>Chấm điểm<a></button></td>
      </tr>
      ";
    }
    echo "</table>";
    }else
    {
      echo 'Chưa có học sinh nào nộp bài thực hiện kiểm tra.';
    }
   }
  ?>
  <h3>Danh sách các bài đã chấm điểm :</h3>
  <?php
   if($lay_id!='')
   {
    $sql="SELECT * FROM `nop_kt` WHERE ID_KT='$lay_id' AND trangthai='đã chấm'";
    $kq=mysqli_query($p->connect(),$sql);
    $i=@mysqli_num_rows($kq);
    if($i>0)
    {
      echo "<table class='table'>
      <tr>
        <td>Người nộp bài  </td>
        <td>Tên bài làm</td>
        <td>File nộp bài</td>
        <td>Thời gian diễn ra</td>
        <td>Trạng thái</td>
      </tr>
    ";
    while($row=mysqli_fetch_array($kq))
    {
      $id_t = $row['ID_KT'];
      $id_ng=$row['ID_HS'];
            $tieu_d = $row['Tieu_de'];
            $noi_d = $row['File'];
            $time = $row['thoi_gian'];
            $k=$q->laycot($p->connect(),"SELECT Tên_HS FROM `hoc_sinh` WHERE ID_HS='$id_ng'");
            $tt=$row['trangthai'];
      echo"
      <tr>
        <td>$k</td>
        <td>$tieu_d</td>
        <td>$noi_d</td>
        <td>$time</td>
        <td style='color=blue;'>$tt</td>
      </tr>
      ";
    }
    echo "</table>";
    }else
    {
      echo 'Chưa có bài nào.';
    }
   }
  ?>
</body>
</html>