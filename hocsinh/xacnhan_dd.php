<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
ob_start();
$con=mysqli_connect("localhost","root","","hoc_online");
if(isset($_SESSION['user']) && isset($_SESSION['pass'])&& isset($_SESSION['id_user']) && isset($_SESSION['ss'])&& isset($_SESSION['hs']))
 {
   include("../confid.php");
   $p=new login();
    $p->confirm_hs($_SESSION['id_user'],$_SESSION['user'],$_SESSION['pass'],$_SESSION['ss']);
 }
 else if(isset($_SESSION['user_token']))
 {
   // header('location:../index.php');
 }else
 {
    header('location:../index.php');
 }
include("../includes/sql.php");
$q=new sql();
?>

<!DOCTYPE html>
<html lang="en">

<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Giao diện học sinh</title>
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
                    <a href="danh_sach_khoa_hoc.php"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Danh sách khóa học</a>
                </li>
                <li>
                    <a href="all_khoahoc.php"><i class="fas fa-pencil-ruler    "></i> Kiểm tra</a>
                </li>
                <li>
                    <a href="hs_diemdanh.php"><i class="fa fa-check-square" aria-hidden="true"></i> Điểm danh</a>
                </li>
                <li>
                    <a href="../payment/index.php"><i class="fas fa-dollar-sign"></i> Đóng học phí</a>
                </li>
                <li>
                    <a href="doi_pass.php"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>Thay đổi mật khẩu</a>
                </li>
                <li>
                    <a href="../logout.php"><i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i> Đăng xuất</a>
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
                        <ul class="nav navbar-nav ml-auto" style="width: 200px;">
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><i class="fas fa-bell" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="#"><i class="fa fa-comment" aria-hidden="true"></i></a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="../thong_tin_user.php"><i class="fas fa-user"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="course" class="container-fluid bg-light">
                <br>
                <h4>Tích vào điểm danh</h4>
                <hr>
<form action="" method="POST" style="border:1px solid black; width:200px;">
    <label for="">Có mặt </label><br>
    <input type="radio" value="present" name="tt"><br>
    <input type="submit" name="nut" value="Lưu" >   <input type="reset" value="Hủy">
</form>
<?php
    if(isset($_COOKIE['Hung']))
{    
    $date = getdate();
    $house = $date['hours'];
    $day = $date['mday'];

    $tt='';
    if(!isset($_SESSION['user_token']))
 {
     $id_user=$_SESSION['id_user'];
     $ten=$_SESSION['user'];
 }else
 {
    //var_dump($_SESSION);exit();
    $sql="SELECT ID_User FROM `taikhoan` WHERE token=".$_SESSION['user_token']."";
     $id_user=$q->laycot($con,$sql);
     $ten=$q->laycot($con,"SELECT Tên_HS FROM `hoc_sinh` WHERE ID_HS='$id_user'");
 }

    $ngay=$date['year'] . '-' . $date['mon'] . '-' . $day . '';
    $gio=$house . ':' . $date['minutes'] . ':' . $date['seconds'] . '';
 
    if(isset($_POST['nut']))
    { 
        if(isset($_POST['tt']))
        $tt=$_POST['tt'];
    switch($_POST['nut'])
    {
        case'Lưu':
            {
                if($tt!='present')
                {
                  echo 'Chưa chọn trạng thái điểm danh.';
                }
                else{
                    $sql="INSERT INTO `chitiet_diemdanh` (`ID`, `ID_HS`, `Email`, `trangthai`, `date`, `time`, `ID_TK`) VALUES
                     (NULL, '$id_user', '$ten', '$tt', '$ngay', '$gio', ".$_COOKIE['Hung'].")";
                    if($q->themxoasua($con,$sql))
                    {
                        echo 'Điểm danh hệ thống thành công.';
                        setcookie( "Hung", "", time()- 60, "/","", 0);
                    }else
                    {
                        echo 'Điểm danh thất bại.';
                    }

                }
            }break;
    }
    }
}
else{
    echo "<script>alert('Thông báo thời gian điểm danh đã hết.')</script>";
   header('refresh:3;url=all_khoahoc.php');
}
?>

            </div>
        </div>
    </div>
    </div>

    <script src="js/script.js"></script>

</body>

</html>

   
   