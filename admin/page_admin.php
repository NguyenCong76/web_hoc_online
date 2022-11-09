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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <script src="../chartjs/dist/Chart.bundle.js"></script>
  <script src="../chartjs/samples/utils.js"></script>
</head>
<body>
    <button><a href="cap_tk.php">Cấp tài khoản</a><button>
    <p>Chào admin</p>
    <p>Thống kê truy cập theo ngày: 
    <?php
    $tg = time();
    $tgout =24*60*60;
    $tgnew = $tg - $tgout;
    $local=$_SERVER['PHP_SELF'];
    $sql2 = "DELETE FROM `useronline` WHERE tgtmp < $tgnew";
    $query = mysqli_query($p->connect(),$sql2);
    $sql3 = "SELECT ip FROM `useronline` WHERE local='/giao_dien_hoc_online/index.php'";
    $query = mysqli_query($p->connect(),$sql3);
    $user = @mysqli_num_rows($query);
    echo $user .' lược';
    ?>
    </p>
    <div id="canvas-holder" style="width:40%">
        <canvas id="chart-area">Biểu đồ thể hiện số lượng tài khoản trong hệ thống</canvas>
    </div>
    <?php
    $kq1=mysqli_query($p->connect(),"SELECT ID FROM `taikhoan` WHERE `Dec`='3'");
    $kq2=mysqli_query($p->connect(),"SELECT ID FROM `taikhoan` WHERE `Dec`='2'");
    $kq3=mysqli_query($p->connect(),"SELECT ID FROM `taikhoan` WHERE `Dec`='1'");
     $ad=@mysqli_num_rows($kq1);
      $gv=@mysqli_num_rows($kq2);
      $hs=@mysqli_num_rows($kq3);

    ?>
    <script>
    var config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    <?php echo $ad;?>,
                    <?php echo $gv;?>,
                    <?php echo $hs;?>,
                    //randomScalingFactor(),
                    //randomScalingFactor(),
                    //randomScalingFactor(),
                   
                ],
                backgroundColor: [
                    window.chartColors.red,
                    window.chartColors.green,
                    window.chartColors.yellow,
                ],
                label:'Tài khoản hệ thống'
            }],
            labels: [
                "AMDIN",
                "GIÁO VIÊN",
                "HỌC SINH"
            ],
        },
        options: {
            responsive: true
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myPie = new Chart(ctx, config);
    };
    </script>
</body>
</html>