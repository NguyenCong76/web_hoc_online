<?php
$con=mysqli_connect("localhost","root","","hoc_online");
  $tg = time();
  $tgout = 900;
  $tgnew = $tg - $tgout;
  $ip= $_SERVER['REMOTE_ADDR'];
  $local=$_SERVER['PHP_SELF'];
  $sql1="INSERT INTO `useronline` (`tgtmp`, `ip`, `local`) VALUES ('$tg','$ip','$local')";
   mysqli_query($con,$sql1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Web-site hỗ trợ học online học sinh tiểu học</title>
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

                <span class="text-primary mb-4">E-Learning</span>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav font-weight-bold mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Trang chủ</a>
                    <a href="about.html" class="nav-item nav-link">Giới thiệu</a>
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

    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="./img/b1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./img/b2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="./img/b3.jpg" alt="Third slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <div id="offer" class="container-fluid text-center mt-5">
        <p class="section-title pr-5"></p>
        <h2 class="text-primary">Vì sao nên chọn E-Learning</h2>
        <br>
        <div class="row slideanim">
            <div class="col-sm-4">
                <i class="fas fa-book-open    "></i>
                <h4>Bài giảng</h4>
                <p>Hệ thống bài giảng, bài tập được giảng dạy bởi giáo viên dạy giỏi</p>
            </div>
            <div class="col-sm-4">
                <i class="fa fa-heart" aria-hidden="true"></i>
                <h4>Hỗ trợ chu đáo</h4>
                <p>Đội ngũ giáo viên luôn theo sát để đảm bảo học sinh sẽ tiến bộ </p>
            </div>
            <div class="col-sm-4">
                <i class="fas fa-coins"></i>
                <h4>Chi phí hợp lý</h4>
                <p>Chỉ từ 300.000đ/khóa</p>
            </div>
        </div>


        <div class="container-fluid pt-5">
            <div class="container">
                <div class="text-center pb-2">
                    <p class="section-title px-5">
                    <h3 class="text-uppercase">Khóa học cho lớp 1</h3>
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/class-1.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Toán lớp 1</h4>
                                <p class="card-text">Toán lớp 1 với nhiều dạng bài khác nhau như tính, điền dấu, tìm số
                                    lớn nhất, tìm số nhỏ nhất, vẽ đoạn thẳng...
                                    Giúp các em học sinh ôn tập và củng cố lại kiến thức, ôn tập các phép tính trong
                                    phạm vi 10, 100.</p>
                            </div>

                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/class-2.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Tiếng Việt lớp 1</h4>
                                <p class="card-text">Giúp em học đọc, học viết và học nghe, nói tiếng Việt. Các câu
                                    chuyện,
                                    bài thơ, bài văn cùng những tranh ảnh sinh động trong sách còn giúp em làm quen với
                                    nhiều bạn nhỏ dễ thương.
                                </p>
                            </div>
                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/portfolio-6.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Tiếng Anh lớp 1</h4>
                                <p class="card-text">Giúp học sinh bước đầu có nhận thức đơn giản nhất về tiếng Anh, để
                                    hình thành các kĩ năng tiếng Anh.
                                    Các bài học được thiết kế xoay quanh những chủ đề quen thuộc về con người, con vật,
                                    thiên nhiên</p>
                            </div>

                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <div class="container-fluid pt-5">
            <div class="container">
                <div class="text-center pb-2">
                    <p class="section-title px-5">
                    <h3 class="text-uppercase">Khóa học cho lớp 2</h3>
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/blog-2.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Toán lớp 2</h4>
                                <p class="card-text">Toán lớp 1 với nhiều dạng bài khác nhau như tính, điền dấu, tìm số
                                    lớn nhất, tìm số nhỏ nhất, vẽ đoạn thẳng...
                                    Giúp các em học sinh ôn tập và củng cố lại kiến thức, ôn tập các phép tính trong
                                    phạm vi 10, 100.</p>
                            </div>

                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/detail.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Tiếng Việt lớp 2</h4>
                                <p class="card-text">Giúp em học đọc, học viết và học nghe, nói tiếng Việt. Các câu
                                    chuyện,
                                    bài thơ, bài văn cùng những tranh ảnh sinh động trong sách còn giúp em làm quen với
                                    nhiều bạn nhỏ dễ thương.
                                </p>
                            </div>
                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/class-3.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Tiếng Anh lớp 2</h4>
                                <p class="card-text">Giúp học sinh bước đầu có nhận thức đơn giản nhất về tiếng Anh, để
                                    hình thành các kĩ năng tiếng Anh.
                                    Các bài học được thiết kế xoay quanh những chủ đề quen thuộc về con người, con vật,
                                    thiên nhiên</p>
                            </div>

                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid pt-5">
            <div class="container">
                <div class="text-center pb-2">
                    <p class="section-title px-5">
                    <h3 class="text-uppercase">Khóa học cho lớp 3</h3>
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/istockphoto-586379824-612x612.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Toán lớp 3</h4>
                                <p class="card-text">Toán lớp 1 với nhiều dạng bài khác nhau như tính, điền dấu, tìm số
                                    lớn nhất, tìm số nhỏ nhất, vẽ đoạn thẳng...
                                    Giúp các em học sinh ôn tập và củng cố lại kiến thức, ôn tập các phép tính trong
                                    phạm vi 10, 100.</p>
                            </div>

                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/portfolio-2.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Tiếng Việt lớp 3</h4>
                                <p class="card-text">Giúp em học đọc, học viết và học nghe, nói tiếng Việt. Các câu
                                    chuyện,
                                    bài thơ, bài văn cùng những tranh ảnh sinh động trong sách còn giúp em làm quen với
                                    nhiều bạn nhỏ dễ thương.
                                </p>
                            </div>
                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="card border-0 bg-light shadow-sm pb-2">
                            <img class="card-img-top mb-2" src="img/istockphoto-480507030-612x612.jpg" alt="">
                            <div class="card-body text-center">
                                <h4 class="card-title">Tiếng Anh lớp 3</h4>
                                <p class="card-text">Giúp học sinh bước đầu có nhận thức đơn giản nhất về tiếng Anh, để
                                    hình thành các kĩ năng tiếng Anh.
                                    Các bài học được thiết kế xoay quanh những chủ đề quen thuộc về con người, con vật,
                                    thiên nhiên</p>
                            </div>

                            <a href="login.php" class="btn btn-primary px-4 mx-auto mb-4">Học ngay!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
        <script language="JavaScript">

if (top.location != self.location)

{top.location = self.location}

</script>
</body>

</html>