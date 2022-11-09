<?php
session_start();
ob_start();
$con = mysqli_connect("localhost", "root", "", "hoc_online");
$id_user = $id_gv = '';
include("includes/sql.php");
$q = new sql();
//hocsinh
if (isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['id_user']) && isset($_SESSION['ss']) && isset($_SESSION['hs'])) {
    include("confid.php");
    $p = new login();
    $p->confirm_hs($_SESSION['id_user'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
} else if (isset($_SESSION['user_token'])) {
    $id_user = $q->laycot($con, "SELECT ID_User FROM `taikhoan` WHERE token=" . $_SESSION['user_token'] . "");
    $mail = $q->laycot($con, "SELECT Email FROM `taikhoan` WHERE token=" . $_SESSION['user_token'] . "");
    // header('location:../index.php');
}
//nếu là giáo viên
else if (isset($_SESSION['id']) && isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['ss']) && isset($_SESSION['gv'])) {
    include("confid.php");
    $p = new login();
    $p->confirm_gv($_SESSION['id'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
    $id_gv = $q->laycot($con, "SELECT ID_User FROM `taikhoan` WHERE ID=" . $_SESSION['id'] . "");
} else {
    header('location:../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<style>
    html,
    body {
        height: 100%;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin cá nhân</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    #avt {
        object-fit: cover;
        width: 150px;
        height: 80px;
        float: left;
        margin-left: 70px;
        margin-bottom: 5px;
    }
</style>

<body>

    <div class="container-fulid w-100 h-100 p-5 bg-info">
    <button type="button" onclick="quay_lai_trang_truoc()">Quay lại</button>
<script>
    function quay_lai_trang_truoc(){
        history.back();
    }
</script>
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-3">
                        <h1 class=" text-center font-italic text-info"><b>Thông tin người dùng</b></h1>
                        <hr>
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-5 mb-5 ">
                                    <div class="card mb-4 bg-light">
                                        <div class="card-body text-center">
                                            <span><b>Ảnh đại diện</b></span>
                                            <img id="avt" alt="avt" src="hinh/<?php
                                                                                if (!empty($id_user)) {
                                                                                    echo $q->laycot($con, "SELECT image FROM `taikhoan` WHERE ID_User='$id_user'");
                                                                                } else {
                                                                                    echo $q->laycot($con, "SELECT image FROM `taikhoan` WHERE ID_User=" . $_SESSION['id_user'] . "");
                                                                                }
                                                                                ?>" class='rounded-circle' width=40px; height=40px; style="margin-left:25px;">
                                        </div>
                                        <input type="file" name="file" id="file" class="form-control">

                                    </div>
                                </div>

                                <div class="col-md-7 mb-4 ">
                                    <div class="card mb-4 bg-light">
                                        <div class="card-body">

                                            <div class="form-group">
                                                <label for="txtten"><b>Họ và tên</b> </label>
                                                <div class="input-group">
                                                    <input type="text" name="txtten" id="txtten" class="form-control" value="<?php if (!empty($id_user)) {
                                                                                                                                    echo $q->layten($mail);
                                                                                                                                } else {
                                                                                                                                    echo $q->layten($_SESSION['user']);
                                                                                                                                } ?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="sdt"><b>Số điện thoại</b> </label>
                                                <div class="input-group">
                                                    <input type="text" name="txtphone" id="txtphone" class="form-control" value="<?php if (!empty($id_user)) {
                                                                                                                                        echo $q->laycot($con, "SELECT dien_thoai FROM `hoc_sinh` WHERE ID_HS='$id_user'");
                                                                                                                                    } else {
                                                                                                                                        echo $q->laycot($con, "SELECT dien_thoai FROM `hoc_sinh` WHERE ID_HS=" . $_SESSION['id_user'] . "");
                                                                                                                                    } ?>">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-outline">
                                                    <label for="txtadr"><b>Địa chỉ</b> </label>
                                                    <div class="input-group">
                                                        <input type="text" name="txtadr" id="" class="form-control" value="<?php if (!empty($id_user)) {
                                                                                                                                echo $q->laycot($con, "SELECT DC FROM `hoc_sinh` WHERE ID_HS='$id_user'");
                                                                                                                            } else {
                                                                                                                                echo $q->laycot($con, "SELECT DC FROM `hoc_sinh` WHERE ID_HS=" . $_SESSION['id_user'] . "");
                                                                                                                            }  ?>">
                                                        <div class="input-group-append">
                                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="gender" class="mb-2 pb-1"> <b>Giới tính</b> </label>
                                                <input type="text" name="gender" id="" class="form-control" value="<?php if (!empty($id_user)) {
                                                                                                                        echo $q->laycot($con, "SELECT `Giới tính` FROM `hoc_sinh` WHERE ID_HS='$id_user'");
                                                                                                                    } else {
                                                                                                                        echo $q->laycot($con, "SELECT `Giới tính` FROM `hoc_sinh` WHERE ID_HS=" . $_SESSION['id_user'] . "");
                                                                                                                    } ?>">

                                            </div>


                                            <div class="form-group">
                                               
                                                    <label for="date" class="mb-2 pb-1"> <b>Năm sinh</b> </label>
                                                    <input type="date" name="date" class="form-control" value="<?php if (!empty($id_user)) {
                                                                                                                    echo $q->laycot($con, "SELECT nam_sinh FROM `hoc_sinh` WHERE ID_HS='$id_user'");
                                                                                                                } else {
                                                                                                                    echo $q->laycot($con, "SELECT nam_sinh FROM `hoc_sinh` WHERE ID_HS=" . $_SESSION['id_user'] . "");
                                                                                                                }  ?>">
                                              
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-4">
                                    <button type="submit" id="dk" name="update" class="btn btn-danger btn-block btn-lg">Chỉnh sửa</button>
                                </div>
                                <div class="col-4">
                                    <button type="reset" class="btn btn-secondary btn-block btn-lg">Hủy</button>
                                </div>
                            </div>

                        </form>
                    </div>
                    <?php
                    //avatar
                    if (isset($_POST['update'])) {
                        //var_dump($_POST);exit();
                        $ten= $_POST['txtten'];
                        $dc=$_POST['txtadr'];
                        $phone=$_POST['txtphone'];
                        $gen=$_POST['gender'];
                        $day=$_POST['date'];
                        $name = $_FILES['file']['name'];
                        $type = $_FILES['file']['type'];
                        $size = $_FILES['file']['size'];
                        $tmp_name = $_FILES['file']['tmp_name'];
                        if ($q->upload($name, $tmp_name, 'hinh')){
                            if ($name != '') { // hình ảnh trong bảng tài khoản
                                if (!empty($id_user)) {
                                    $sql = "UPDATE `taikhoan` SET `image` = '$name' WHERE ID_User = '$id_user'";
                                    mysqli_query($con, $sql);
                                } else{
                                    $sql1 = "UPDATE `taikhoan` SET `image` = '$name' WHERE ID_User=" . $_SESSION['id_user'] . "";
                                    mysqli_query($con, $sql1);
                                }
                            }
                        }

                        if (empty($_POST['txtten']) || empty($_POST['txtphone']) || empty($_POST['txtadr']) || empty($_POST['gender'] || empty($_POST['date']))) {
                            echo "<script>alert('Vui lòng không để rỗng các thông tin.')</script>";
                        } 
                        else { //chỉnh sửa thông tin trong bảng học sinh
                            if (!empty($id_user)) //nếu có gg
                            {
                                $sqlk = "UPDATE `hoc_sinh` SET `Tên_HS`='$ten',`DC`='$dc', `dien_thoai` ='$phone', `Giới tính` ='$gen', `nam_sinh` ='$day'  WHERE ID_HS = '$id_user'";
                                
                                if(mysqli_query($con, $sqlk))
                                {
                                    header("location:thong_tin_user.php");
                                }else{echo 'thất bại gg';}
                            } else { //nếu bình thường
                                $sqll = "UPDATE `hoc_sinh` SET `Tên_HS`='$ten',`DC`='$dc', `dien_thoai` ='$phone', `Giới tính` ='$gen', `nam_sinh` ='$day'  WHERE ID_HS =".$_SESSION['id_user']."";
                                if(mysqli_query($con, $sqll))
                                { 
                                 header("location:thong_tin_user.php");
                                }else{echo 'thất bại';}
                            }
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>



</body>

</html>