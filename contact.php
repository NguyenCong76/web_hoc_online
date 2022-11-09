<?php
ob_start();
include("confid.php");
$p=new login();
include("includes/sql.php");
$q=new sql();
include("mail/send_contact.php");
$mail=new contact_us();
$html='';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>KidKinder - Kindergarten Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">


    <!-- Google Web Fonts -->
   
    <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Flaticon Font -->
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <div class="container-fluid bg-light position-relative shadow">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0 px-lg-5">
            <a href="" class="navbar-brand font-weight-bold text-secondary" style="font-size: 50px;">

                <span class="text-primary">E-Learning</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Trang chủ</a>
                    <a href="about.php" class="nav-item nav-link">Giới thiệu</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Khóa học</a>
                        <div class="dropdown-menu rounded-0 m-0 font-weight-bold ">
                            <a href="blog.html" class="dropdown-item">Toán</a>
                            <a href="single.html" class="dropdown-item">Tiếng Việt</a>
                            <a href="single.html" class="dropdown-item">Tiếng Anh</a>
                        </div>
                    </div>
                    <a href="contact.php" class="nav-item nav-link">Liên hệ</a>
                </div>
                <form class="form-inline my-2 my-lg-0 pr-2">
                    <input class="form-control mr-sm-2" type="search" placeholder="Tìm kiếm" aria-label="Search">
                    <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fa fa-search"
                            aria-hidden="true"></i> </button>
                </form>

                <a href="login.php" class="btn btn-primary px-4">Đăng nhập</a>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="container-fluid bg-primary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 400px">
            <h3 class="display-3 font-weight-bold text-white">Liên hệ</h3>
            <div class="d-inline-flex text-white">
                <p class="m-0"><a class="text-white" href="">Trang chủ</a></p>
                <p class="m-0 px-2">/</p>
                <p class="m-0">Liên hệ</p>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="container">
            <div class="text-center pb-2">
                <h1 class="mb-4">Liên hệ với hệ với chúng tôi</h1>
            </div>
            <div class="row">
                <div class="col-lg-7 mb-5">
                    <div class="contact-form">
                        <div id="success"></div>
                        <form action="" method="post">
                            <div class="control-group">
                                <input type="text" class="form-control" name="hoten" id="name" placeholder="Họ và tên của bạn"
                              />
                                <p></p>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                                   />
                                    <p></p>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control" name="td" id="subject" placeholder="Tiêu đề"
                                   />
                                <p ></p>
                            </div>
                            <div class="control-group">
                                <textarea class="form-control" rows="6" name="nd" id="message" placeholder="Nội dung"
                                 ></textarea>
                                <p ></p>
                            </div>
                            <div>
                                <button class="btn btn-primary py-2 px-4" type="submit"
                                    name="nut" value="Gửi">Gửi</button>
                            </div>
                        </form>
                    </div>
                </div>
               
                <?php
                 if(isset($_POST['nut']))
                 switch($_POST['nut'])
                 {
                    case'Gửi':
                        {
                          //var_dump($_POST);exit();
                          $name=$_POST['hoten'];
                          $email=$_POST['email'];
                          $title=$_POST['td'];
                          $content=$_POST['nd'];
                         $html="<table>
                          <tr>
                              <td>Tiêu đề</td>
                              <td>$title</td>
                          </tr>
                          <tr>
                              <td>Họ tên</td>
                              <td>$name</td>
                          </tr>
                          <tr>
                              <td>Email</td>
                              <td>$email</td>
                          </tr>
                          <tr>
                              <td>Nội dung</td>
                              <td>$content</td>
                          </tr>
                      </table>";
                         if(empty($name)||empty($email)||empty($title)||empty($content))
                         {
                            echo"<script>alert('Vui lòng nhập đủ các thông tin cần gửi.')</script>";
                         }
                         else
                         {
                            $sql="INSERT INTO `contact_us` (`ID`, `hoten`, `Email`, `tieude`, `noidung`) VALUES
                      (NULL, '$name', '$email', '$title', '$content')";
                            if(mysqli_query($p->connect(),$sql)){
                               $mail->contact('Thông tin cần hỗ trợ',$html,'thaihung11092001@gmail.com');
                               header("refresh:4;url=contact.php");
                            }else
                            {
                                echo"<script>alert('Gửi liên hệ tới hệ thống thất bại.')</script>";
                            }
                         }
                        }break;
                 }
                ?>
                <div class="col-lg-5 mb-5">
                    <div class="d-flex">
                        <i class="fa fa-map-marker-alt d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                            style="width: 45px; height: 45px;"></i>
                        <div class="pl-3">
                            <h5>Địa chỉ</h5>
                            <p>12 Nguyễn Văn Bảo, P.4, Q.Gò Vấp, Tp.Hồ Chí Minh, Việt Nam</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class="fa fa-envelope d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                            style="width: 45px; height: 45px;"></i>
                        <div class="pl-3">
                            <h5>Email</h5>
                            <p>thaihung11092001@gmail.com</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <i class="fa fa-phone-alt d-inline-flex align-items-center justify-content-center bg-primary text-secondary rounded-circle"
                            style="width: 45px; height: 45px;"></i>
                        <div class="pl-3">
                            <h5>Điện thoại</h5>
                            <p>(84) 97 714 8630</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-secondary text-white mt-5 py-5 px-sm-3 px-md-5">
        <div class="row pt-3">
            <div class="col-lg-4 col-md-6 mb-5">
                <h3 class="text-primary mb-4">E-Learning</h3>
                <p>Hệ thống dạy học trực tuyến( e-learning) là hệ thống giáo dục bằng phương pháp dạy và học online qua 
                  các thiết bị có kết nối internet như điện thoại, máy tính, máy tính bảng,….
                    Học sinh có thể học tập tại nhà hoặc bất cứ đâu mà không cần đến trường.</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-primary rounded-circle text-center mr-2 px-0"
                        style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 mb-5">
                <h3 class="text-primary mb-4">Liên hệ</h3>
                <p><i class="fas fa-map-marked    "></i> 12 Nguyễn Văn Bảo, P.4, Q.Gò Vấp, Tp.Hồ Chí Minh, VN</p>
                <p><i class="fa fa-phone" aria-hidden="true"></i> (84) 97 714 8630</p>
                <p><i class="fa fa-envelope" aria-hidden="true"></i> hc@elearning.com</p>
            </div>
            <div class="col-lg-4 col-md-6 mb-5">
                <h3 class="text-primary mb-4">Khóa học</h3>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Toán</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Tiếng Việt</a>
                    <a class="text-white mb-2" href="#"><i class="fa fa-angle-right mr-2"></i>Tiếng Anh</a>
                </div>
            </div>

            <div class="container-fluid pt-5" style="border-top: 1px solid rgba(23, 162, 184, .2);;">
                <p class="m-0 text-center text-white">
                    &copy; <a class="text-primary font-weight-bold" href="#">E-Learning Copyright © 2022. All Rights Reserved</a>
                </p>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-primary p-3 back-to-top"><i class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/isotope/isotope.pkgd.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>