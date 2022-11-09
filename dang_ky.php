<?php
session_start();
ob_start();
include("includes/sql.php");
$q = new sql();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <?php
    // define variables to empty values  
    $tenErr = $emailErr = $sdtErr = $genderErr = $adrErr = $passErr = $repassErr = $fileErr = $dateErr = "";
    $ten = $email = $sdt = $gender = $adr = $pass = $repass = $files = $date = "";

    //Input fields validation  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //String Validation  
        if (empty($_POST["txtten"])) {
            $tenErr = "Họ và tên là bắt buộc!";
        } else {
            $ten = input_data($_POST["txtten"]);
            // check if name only contains letters and whitespace  
            if (!preg_match("/^[^\d+]*[\d+]{0}[^\d+]*$/", $ten)) {
                $tenErr = "Họ và tên không hợp lệ!";
            }
        }

        //Email Validation   
        if (empty($_POST["txtuser"])) {
            $emailErr = "Email là bắt buộc!";
        } else {
            $email = input_data($_POST["txtuser"]);
            // check that the e-mail address is well-formed  
            if (!preg_match("/[A-Z0-9._%+-]+@[A-Z0-9-]+.+.[A-Z]{2,4}/i", $email)) {
                $emailErr = "Email không hợp lệ!";
            }
        }

        //Number Validation  
        if (empty($_POST["txtphone"])) {
            $sdtErr = "SĐT là bắt buộc!";
        } else {
            $sdt = input_data($_POST["txtphone"]);
            // check if mobile no is well-formed  
            if (!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $sdt)) {
                $sdtErr = "SĐT Không hợp lệ!";
            }
            //check mobile no length should not be less and greator than 10  
            if (strlen($sdt) != 10) {
                $sdtErr = "SĐT gồm 10 số!";
            }
        }

        //Pass Validation      
        if (empty($_POST["txtpass"])) {
            $passErr = "Mật khẩu là bắt buộc!";
        } else {
            $pass = input_data($_POST["txtpass"]);
            // check if URL address syntax is valid  
            if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/", $pass)) {
                $passErr = "Mật khẩu không hợp lệ!";
            }
        }


        if (empty($_POST["txtconfpass"])) {
            $repassErr = " Nhập lại mật khẩu!";
        } else {
            $repass = input_data($_POST["txtconfpass"]);
            if ($repass != $pass) {
                $repassErr = "Mật khẩu không trùng khớp!";
            }
        }

        if (empty($_POST["txtadr"])) {
            $adrErr = "Địa chỉ là bắt buộc!";
        } else {
            $adr = input_data($_POST["txtadr"]);
            // check if name only contains letters and whitespace  
            if (!preg_match("/[A-Za-z0-9'\.\-\s\,]/", $adr)) {
                $adr = "Địa chỉ không hợp lệ!";
            }
        }


        if (empty($_POST["gender"])) {
            $genderErr = "Giới tính là bắt buộc!";
        } else {
            $gender = input_data($_POST["gender"]);
        }

        if (empty($_POST["date"])) {
            $dateErr = "Bắt buộc!";
        } else {
            $date = input_data($_POST["date"]);
        }

        
    }




    function input_data($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }


    ?>
    <div class="container-fulid wp-50 p-5 bg-info">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-12 col-lg-9 col-xl-7">
                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                    <div class="card-body p-4 p-md-3">
                        <h1 class=" text-center font-italic text-info"><b>E-Learning</b></h1>
                        <hr>
                        <h3 class="text-center mb-3"> <span class="font-italic">Đăng ký tài khoản để tham gia khóa học ngay nào!</span></h3>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="form-outline">
                                        <label for="txtten"><b>Họ và tên</b> <span class="text-danger">(*)<?php echo $tenErr; ?></span></label>
                                        <div class="input-group">
                                            <input type="text" name="txtten" id="txtten" class="form-control" placeholder="Nhập họ và tên" value="<?php echo (isset(($ten))) ? $ten : ''; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label for="txtuser"><b>Email </b><span class="text-danger">(*)<?php echo $emailErr; ?></span></label>
                                        <div class="input-group">
                                            <input type="email" name="txtuser" id="txtuser" class="form-control" placeholder=" Nhập Email" value="<?php echo (isset(($email))) ? $email : ''; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label for="sdt"><b>Số điện thoại</b> <span class="text-danger">(*)<?php echo $sdtErr; ?></span></label>
                                        <div class="input-group">
                                            <input type="text" name="txtphone" id="txtphone" class="form-control" placeholder="Nhập số điện thoại" value="<?php echo (isset(($sdt))) ? $sdt : ''; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-phone" aria-hidden="true"></i></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-2">
                                    <div class="form-outline">
                                        <label for="txtadr"><b>Địa chỉ</b> <span class="text-danger">(*)<?php echo $adrErr; ?></span></label>
                                        <div class="input-group">
                                            <input type="text" name="txtadr" id="" class="form-control" placeholder="Nhập địa chỉ hiện tại" value="<?php echo (isset(($adr))) ? $adr : ''; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label for="gender" class="mb-2 pb-1"> <b>Giới tính</b> <span class="text-danger">(*)<?php echo $genderErr; ?></span></label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Nam" />
                                        <label class="form-check-label" for="gender">Nam</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" value="Nữ" />
                                        <label class="form-check-label" for="gender">Nữ</label>
                                    </div>

                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="form-inline">
                                        <label for="date" class="mb-2 pb-1"> <b>Năm sinh</b> <span class="text-danger">(*)<?php echo $dateErr; ?></span></label>
                                        <input type="date" name="date" class="form-control" value="<?php echo (isset(($date))) ? $date : ''; ?>">
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label for="txtpass"> <b>Mật khẩu</b> <span class="text-danger">(*)<?php echo $passErr; ?></span></label>
                                        <div class="input-group">
                                            <input type="password" name="txtpass" id="txtpass" class="form-control" placeholder="Ít nhất 8 kí tự bao gồm chữ cái và số" value="<?php echo (isset(($pass))) ? $pass : ''; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="form-outline">
                                        <label for="txtconfpass"> <b>Xác nhận mật khẩu</b> <span class="text-danger">(*)<?php echo $repassErr; ?></span></label>
                                        <div class="input-group">
                                            <input type="password" name="txtconfpass" id="txtconfpass" class="form-control" placeholder="Nhập lại mật khẩu" value="<?php echo (isset(($repass))) ? $repass : ''; ?>">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="fa fa-lock" aria-hidden="true"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center">
                                <div class="col-4">
                                    <button type="submit" id="dk" name="dk" class="btn btn-info btn-block btn-lg">Đăng ký</button>
                                </div>
                                <div class="col-4">
                                    <button type="reset" class="btn btn-secondary btn-block btn-lg">Hủy</button>
                                </div>
                            </div>


                            <div class="row d-flex justify-content-center pt-2">
                                <div class="col-8">
                                    <a href="hocsinh/login_gg.php" class="btn btn-block btn-danger">
                                        <i class="fab fa-google-plus mr-2"></i>
                                        Đăng nhập với Google+
                                    </a>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center pt-2">
                                <div class="col-5">
                                    <a href="login.php">Bạn đã có tài khoản? Đăng nhập ngay!</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    if (isset($_POST['dk'])) {

                        $hoten=$_POST['txtten'];
                        $user=$_POST['txtuser'];
                        $phone=$_POST['txtphone'];
                        $diachi=$_POST['txtadr'];
                        $gioitinh=$_POST['gender'];
                        $namsinh=$_POST['date'];
                        $matkhau=$_POST['txtpass'];
                        $xnmatkhau=$_POST['txtconfpass'];

                        $_SESSION['hoten'] = $hoten;
                        $_SESSION['mail'] = $user;
                        $_SESSION['mk'] = $matkhau;
                        $_SESSION['rep'] = $xnmatkhau;
                        $_SESSION['dt'] = $phone;
                        $_SESSION['adr'] = $diachi;
                        $_SESSION['sex'] = $gioitinh;
                        $_SESSION['ns'] = $namsinh;
                        $_SESSION['code'] = rand(0, 999999);
                        //var_dump($_POST);exit();

                        if ((empty($_SESSION['mail']) || empty($_SESSION['hoten']) || empty($_SESSION['adr']) || empty($_SESSION['dt']) || empty($_SESSION['mk']) || empty($_SESSION['rep']) || empty($_SESSION['sex']) || isset($_SESSION['mk'])!=isset($_SESSION['rep']) || empty($_SESSION['ns']))) {

                            echo "<script>alert('Vui lòng nhập đầy đủ thông tin!')</script>";
                        } else {
                            setcookie("xacnhan", "123", time() + 300, "/");
                            header('location:check_taikhoan1.php');
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>



</body>

</html>