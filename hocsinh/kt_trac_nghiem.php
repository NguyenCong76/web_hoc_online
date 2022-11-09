<?php
session_start();
ob_start();
if (isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['id_user']) && isset($_SESSION['ss']) && isset($_SESSION['hs'])) {
    include("../confid.php");
    $p = new login();
    $p->confirm_hs($_SESSION['id_user'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
} else {
    header('location:../index.php');
}
include("../includes/sql.php");
$q = new sql();
 $id_kt ='';
if (isset($_REQUEST['id_kt'])) {
    $id_kt = unserialize(base64_decode($_REQUEST['id_kt']));
}
 $phut=$q->laycot($p->connect(),"SELECT thoi_luong FROM `bai_kt_trac_nghiem` WHERE id_kt_tn='$id_kt'");
  $tg=$q->laycot($p->connect(),"SELECT thoi_gian FROM `bai_kt_trac_nghiem` WHERE id_kt_tn='$id_kt'");
  //echo date("Y,d,m,H,i,s",strtotime($tg));exit();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học sinh kiểm tra</title>
    <link rel="stylesheet" href="../css/style_course.css">
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
          .clock {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translateX(-50%) translateY(-50%);
    color: #17D4FE;
    font-size: 15px;
    font-family: Orbitron;
    letter-spacing: 5px;
    background-color: black;
}
        </style> 
</head>

<body onload="auto_sub1();">
    <div class="wrapper" >
        <nav id="sidebar">
            <div class="sidebar-header">
                <h2>E-Learning</h2>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="danh_sach_khoa_hoc.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Danh sách khóa học</a>
                </li>
                <li>
                    <a href="all_khoahoc.php"><i class="fas fa-pencil-ruler"></i> Kiểm tra</a>
                </li>
                <li>
                    <a href="hs_diemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
                </li>
                <li>
                    <a href="../payment/index.php"><i class="fas fa-dollar-sign"></i> Đóng học phí</a>
                </li>
                <li>
                    <a href="doi_pass.php"><i class="fa fa-change" aria-hidden="true"></i>Thay đổi mật khẩu</a>
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
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="#"><i class="fa fa-comment" aria-hidden="true"></i></a>
                            </li>
                            <li class="dropdown" style="width: auto;">
                                <a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown"><span>Ly dang thai
                                        hung </span><i class="fas fa-user ml-2" aria-hidden="true"></i></a>
                                <div class="dropdown-menu ">
                                <a href="doi_pass.php" class="dropdown-item"><i class="fa fa-lock" aria-hidden="true"></i> Đổi
                                        mật khẩu</a>
                                    <a href="../logout.php" class="dropdown-item"><i class="fa fa-arrow-right" aria-hidden="true"></i></i> Đăng
                                        xuất</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="course" class="container-fluid bg-light">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="pt-2">Chào mừng đến với bài kiểm tra:</h3>
                    </div>
                    <div class="col-sm-6">
                <div class="clock" id="clock">         
                </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-2"></div>
                <div class="col-10">
                <form action="xuli_kt_tn.php" method="POST" name="form" id="subform" >
                    <?php
                    $sql = "SELECT * FROM `trac_nghiem` WHERE id_kt_tn='$id_kt'";
                    $kq = mysqli_query($p->connect(),$sql);
                    $i = 1;
                    while ($row = mysqli_fetch_object($kq)){
                        //var_dump($row);exit();
                       ?>
                       
                        <fieldset id="">
                                <h6 style="font-weight: bold" id=""><span class="text-danger">Câu <?php echo $i; ?> : </span> <?php echo $row->cau_hoi; ?></h6>
                                <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo $row->id ?>" id="exampleRadios1" value="a">
                                <label class="form-check-label" for="exampleRadios1"><span class="text-danger">A</span>.
                                <?php echo $row->cau_a ?>
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo $row->id ?>" id="exampleRadios2" value="b">
                                <label class="form-check-label" for="exampleRadios2"><span class="text-danger">B</span>.
                                <?php echo $row->cau_b ?>
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="<?php echo $row->id ?>" id="exampleRadios3" value="c">
                                <label class="form-check-label" for="exampleRadios3"><span class="text-danger">C</span>.
                                <?php echo $row->cau_c ?>
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio"  name="<?php echo $row->id ?>" id="exampleRadios3" value="d">
                                <label class="form-check-label" for="exampleRadios3"><span class="text-danger">D</span>.
                                <?php echo $row->cau_d ?>
                                </label>
                              </div></fieldset>
                                
                        
        
                 <?php
                 $i++;
                    }
                 ?>
                  <input type="submit" class="btn btn-success" id="btnSubmit" name="nut" value="Nộp bài">
                    </form>
                    </div>
                    </div>
             
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
    <script language="JavaScript">
function auto_sub()
{
document.form.submit();
}
function auto_sub1()
{
setTimeout("auto_sub()",<?php echo $phut*60*1000-3000; ?>);//submit sau tg quy định
}
</script>

<script>

// Set the date we're counting down to
var countDownDate = new Date("<?php echo date("m d ,Y H:i:s", strtotime($tg));?>").getTime();//năm , ngày, tháng ,giờ, phút , giây 

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();
    
  // Find the distance between now and the count down date
  var distance = countDownDate - now;
    
  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
  // Output the result in an element with id="demo"
  document.getElementById("clock").innerHTML =  hours + "giờ "
  + minutes + "phút " + seconds + "giây ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("clock").innerHTML = "EXPIRED";
  }
}, 1000);
</script>
</body>

</html>