<?php
session_start();

include("../confid.php");
$p=new login();
include("../includes/sql.php");
$q=new sql();
if(isset($_SESSION['user_token']))
{
  $avt=$q->laycot($p->connect(),"SELECT image FROM `taikhoan` WHERE token=".$_SESSION['user_token']."") ;
  $mail=$q->laycot($p->connect(),"SELECT Email FROM `taikhoan` WHERE token=".$_SESSION['user_token']."");
  $tt=$q->laycot($p->connect(),"SELECT status FROM `taikhoan` WHERE token=".$_SESSION['user_token']."") ;
  $sql = "SELECT * FROM `taikhoan` WHERE NOT token=".$_SESSION['user_token']."";
}
else if(isset($_SESSION['unique_id']))
{
  $avt=$q->laycot($p->connect(),"SELECT image FROM `taikhoan` WHERE unique_id=".$_SESSION['unique_id']."") ;
  $mail=$q->laycot($p->connect(),"SELECT Email FROM `taikhoan` WHERE unique_id=".$_SESSION['unique_id']."");
  $tt=$q->laycot($p->connect(),"SELECT status FROM `taikhoan` WHERE unique_id=".$_SESSION['unique_id']."") ;
  $sql = "SELECT * FROM `taikhoan` WHERE NOT unique_id = ".$_SESSION['unique_id']."";
}else{
  header("location:../index.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../chat/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <img src="../hinh/<?php echo $avt; ?>" alt="" width="100px;" height="auto">
          <div class="details">
           <span><?php if(isset($_SESSION['gv'])){echo $q->laycot($p->connect(),"SELECT Ten_GV FROM `giao_vien` WHERE Email='$mail'");}else{echo $q->laycot($p->connect(),"SELECT Tên_HS FROM `hoc_sinh` WHERE Email='$mail'");}?></span></br>
            <p><i style="color:green;"><?php echo $tt; ?></i></p>
        </div>
        </div>
        <a href="../logout.php" class="logout">Đăng xuất</a>
      </header>
      
      <div class="user">
       <?php 
          
           $q->getData($p->connect(),$sql);

        ?>
      
      </div>
    </section>
  </div>
<script src="css/users-event.js"></script>
 
</body>
</html>