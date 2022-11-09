<?php
session_start();
ob_start();
if(isset($_SESSION['id'])&&isset($_SESSION['user']) && isset($_SESSION['pass'])&& isset($_SESSION['id_user']) && isset($_SESSION['ss']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_admin($_SESSION['id'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['id_user'],$_SESSION['ss']);
 }
 else
 {
  header('location:../index.php');
 }
//echo phpinfo();exit(); 
?>

<?php
    $tg = time();
    $tgout = 900;
    $tgnew = $tg - $tgout;
    $local=$_SERVER['PHP_SELF'];
    //$sql1="INSERT INTO `useronline`(tgtmp,ip,local) VALUES ('$tg',".$_SERVER['REMOTE_ADDR'].",".$_SERVER['PHP_SELF'].")";
    //$query = mysqli_query($p->connect(),$sql1);
    $sql2 = "DELETE FROM `useronline` WHERE tgtmp < $tgnew";
    $query = mysqli_query($p->connect(),$sql2);
    $sql3 = "SELECT ip FROM `useronline` WHERE local='/giao_dien_hoc_online/index.php'";
    $query = mysqli_query($p->connect(),$sql3);
    $user = @mysqli_num_rows($query);
    echo "user online :$user";
?>