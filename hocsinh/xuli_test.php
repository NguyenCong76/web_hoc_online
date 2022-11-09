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
 if(isset($_POST['nut1']))  // tồn tại bấm nút nộp.
 { 
   
    if(!isset($_COOKIE["start_test"])==1) // thời gian nộp bài
    {
        echo"<script>alert('Không thể nộp bài!')</script>";
        if(!isset($_SESSION['1lan']))
        {
        $_SESSION['1lan']=true;
        }
    }else{
   $tt=$_POST['tieude'];
   $name=$_FILES['file']['name'];
    $type=$_FILES['file']['type'];
    $size=$_FILES['file']['size'];
     $tmp_name=$_FILES['file']['tmp_name'];
     if($tt==''||$name==''|| $tt==''&& $name==''){
     
      echo"<script>alert('Hoàn thành đủ các trường nhập.')</script>";
     }
     else
     {
     if($name!=''&& $type=='application/pdf')
     {
       if($q->upload($name,$tmp_name,"../file"))
       {
        $sql="INSERT INTO `nop_kt`(`ID_KT`, `ID_HS`, `Tieu_de`, `File`, `thoi_gian`, `ID`,`trangthai`) VALUES
        (".$_SESSION['id_kt'].", ".$_SESSION['id_user'].", '$tt', '$name', current_timestamp(), NULL,'chưa chấm')";
            if(mysqli_query($p->connect(),$sql))
            {
                echo"<script>alert('nộp bài thành công.')</script>";
                unset($_SESSION['batdau']);
                header("refresh:3;url=test_tl.php");
            }else
            {
                echo"<script>alert('Nộp bài thất bại.')</script>";
            }
       }else
       {
        echo"<script>alert('upfile không thành công.')</script>";
       }
     }
     else{
        echo"<script>alert('File không đúng mẫu pdf.')</script>";
     }
    }
   //echo $_SESSION['lay_id'];  // id khóa học.
  //echo $_SESSION['id_kt'];    // id bài kiểm tra.
 }
}else
 {
    header("location:test_tl.php");
 }

 //INSERT INTO `nop_kt` (`ID_KT`, `ID_HS`, `Tieu_de`, `File`, `thoi_gian`, `ID`) VALUES
 // ('14', '1', 'Học sinh 1 nộp bài thi cuối kì', 'kt.zip', current_timestamp(), NULL);
?>