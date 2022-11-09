<?php 
 session_start();
 include("confid.php");
 $p=new login();
 //UPDATE `taikhoan` SET `status` = 'Không hoạt động' WHERE `taikhoan`.`ID` = 22;
 if(!isset($_SESSION['user_token']))
 {
 $email=$_SESSION['user'];
}else
{
   $email=$p->laycot($p->connect(),"SELECT Email FROM `taikhoan` WHERE token=".$_SESSION['user_token']."");
}
    $sql="UPDATE `taikhoan` SET `status` ='Không hoạt động' WHERE `taikhoan`.`Email` ='$email'";
    if(mysqli_query($p->connect(),$sql)){
    session_unset();
    session_destroy();
    header('location:login.php');
 }else
 {
    echo 'Đăng xuất không thành công.';
 }

  
?>