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
 $email=$_SESSION['user'];
 $id_gv=$q->laycot($p->connect(),"SELECT ID_User FROM `taikhoan` WHERE Email='$email'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lí điểm danh</title>
    <link rel="stylesheet" href="../css/style_course.css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!--Vẽ biểu đồ--> 
  <script src="../chartjs/dist/Chart.bundle.js"></script>
  <script src="../chartjs/samples/utils.js"></script>
  <style>
          .clock {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: #17D4FE;
    font-size: 30px;
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
    <form action="" method="post">
    <div class="row">
               <div class="col-sm-6"><h3>Lọc điểm danh theo thời gian:</h3></div>
              <div class="col-sm-6"><div id="MyClockDisplay" class="clock" onload="showTime()"></div></div>
              </div><br>
       <lable><b>Chọn ngày</b></lable> <input type="date" name="day">
       <lable><b>Chọn giờ</b></lable> <input type="time" name="h"> <br><br>
        <div class="row">
            <div class="col-sm-6">
                <button type="submit" name="nut" value="chọn" class="btn btn-warning text-black" >Chọn</button>
            </div>
        </div>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-9">
            <div id="canvas-holder" style="width:40%">
        <canvas id="chart-area"></canvas>
    </div>
            </div>
        </div>
    </form><br>   
    <?php 
    if(!isset($_POST['nut']))
    {
    //$q->load_diemdanh($p->connect(),"SELECT * FROM `chitiet_diemdanh` WHERE ID_TK=".$_SESSION['id']."");
    $sql="SELECT * FROM `chitiet_diemdanh` WHERE ID_TK=".$_SESSION['id']."";
    $ketqua = mysqli_query($p->connect(),$sql);
    mysqli_close($p->connect());
    $i=mysqli_num_rows($ketqua);
    $j=1;
    if($i>0)
    { 
        echo '
        <form action="" method="POST">
        <table class="table">
        <tr style="background-color:blue; color: white;">
            <td>STT</td>
            <td>Họ và Tên</td>
            <td>Email</td>
            <td>Ngày điểm danh</td>
            <td>Thời gian</td>
            <td>Trạng thái</td>
        </tr>';
        while($row=mysqli_fetch_array($ketqua))
        {
            
            $mail=$row['Email'];
            $date=$row['date'];
            $time=$row['time'];
            $tt=$row['trangthai'];
            $ten=$q->layten($mail);
            echo "<tr>
            <td>$j</td>
            <td>$ten</td>
            <td>$mail</td>
            <td>$date</td>
            <td>$time</td>
            <td>$tt</td>
            </tr>";
            $j++;
        }
        echo'</table></form>';
    }
    }
    else{
        switch($_POST['nut'])
        {
            case'chọn':
                {
                    //var_dump($_POST);exit();
                    $time=$_POST['day'];
                    $h=$_POST['h'];
                //$q->load_diemdanh($p->connect(),"SELECT * FROM `chitiet_diemdanh` WHERE ID_TK=".$_SESSION['id']." AND date='$time' OR time ='$h'");
                $sql="SELECT * FROM `chitiet_diemdanh` WHERE ID_TK=".$_SESSION['id']." AND date='$time' OR time ='$h'";
                $ketqua = mysqli_query($p->connect(),$sql);
                mysqli_close($p->connect());
                $i=mysqli_num_rows($ketqua);
                $j=1;
                if($i>0)
                { 
                    echo '
                    <form action="" method="POST"><table class="table" >
                    <tr style="background-color:blue; color: white;">
                        <td>STT</td>
                        <td>Họ và Tên</td>
                        <td>Email</td>
                        <td>Ngày điểm danh</td>
                        <td>Thời gian</td>
                        <td>Trạng thái</td>
                    </tr>';
                    while($row=mysqli_fetch_array($ketqua))
                    {
                    
                        $mail=$row['Email'];
                        $date=$row['date'];
                        $time=$row['time'];
                        $tt=$row['trangthai'];
                        
                        $ten=$q->layten($mail);
                        echo "<tr>
                        <td>$j</td>
                        <td>$ten</td>
                        <td>$mail</td>
                        <td>$date</td>
                        <td>$time</td>
                        <td>$tt</td>
                        </tr>";
                        $j++;
                    }
                    echo'</table></form>';
                }
                }break;
        }
    }

    ?>
            </div>
        </div>
</div>
<?php 
//lấy tổng số học sinh thuộc các khóa học của giáo viên đang dạy
$kh_hoc="SELECT ID_khoa FROM `khoa_hoc` WHERE ID_GV='$id_gv'";
$kq_k=mysqli_query($p->connect(),$kh_hoc);
while($row=mysqli_fetch_array($kq_k))
{
   $hocsinh="SELECT ID_HS FROM `hocsinh_khoahoc` WHERE ID_khoa=".$row['ID_khoa']."";
   $kq=mysqli_query($p->connect(),$hocsinh);
   $k=mysqli_num_rows($kq);
}
?>
    <script>
        
    var config = {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [
                    <?php echo  $i;?>,
                    <?php echo $k-$i;?>,
                ],
                backgroundColor:[
                    window.chartColors.red,
                    window.chartColors.blue,
                ],
                label: 'Dataset 1'
            }],
            labels: [
                "Có mặt",
                "Vắng mặt",
              
            ]
        },
        options: {
            responsive: true,
            legend: {
                position: 'left',
            },
            title: {
                display: true,
                text: 'Biểu đồ đánh giá điểm danh'
            },
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    };

    window.onload = function() {
        var ctx = document.getElementById("chart-area").getContext("2d");
        window.myDoughnut = new Chart(ctx, config);
    };

    </script>

<script src="../js/script.js"></script>
<script src="../clock_js/dist/script.js"></script>

</body>
</html>