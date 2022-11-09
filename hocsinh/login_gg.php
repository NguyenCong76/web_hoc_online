<?php
//ID client="947840471908-umncs13698icef2vlsmjp453uvmk42gn.apps.googleusercontent.com"
//pass="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"
include("../includes/sql.php");
$p=new sql();
require_once '../includes/confid_gg.php';
$hostname = "localhost";
$username = "root";
$password = "";
$database = "hoc_online";

$conn = mysqli_connect($hostname, $username, $password, $database);
// authenticate code from Google OAuth Flow
if (isset($_GET['code'])) {
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  //$client->setAccessToken($token['access_token']);

  // get profile info
  $google_oauth = new Google_Service_Oauth2($client);
  
    $google_account_info = $google_oauth->userinfo->get();
    $email = $google_account_info->email;
    $hinh=$google_account_info->picture;
    $name = $google_account_info->name;
    $token = $google_account_info->id;
    $_SESSION['token'] 	= $client->getAccessToken();
  //print_r($userinfo);exit();
  // checking if user is already exists in database
   // save user data into session
    $_SESSION['user_token']=$token;
    //var_dump($_SESSION);exit();
  $sql100 = "SELECT * FROM `taikhoan` WHERE Email ='$email'";
  $result = mysqli_query($conn, $sql100);
    $num = mysqli_num_rows($result);
  if ($num>0) {
    // user is exists
    mysqli_query($conn,"UPDATE `taikhoan` SET `status` = 'Đang hoạt động' WHERE `taikhoan`.`Email` ='$email'");
    $_SESSION['unique_id']=$p->laycot($conn,"SELECT unique_id FROM `taikhoan` WHERE `taikhoan`.`Email` ='$email'");
    header("location:../hocsinh/danh_sach_khoa_hoc.php");
    
  } else {
    // user is not exists
   
    //$sql1="INSERT INTO `hoc_sinh` (`ID_HS`, `Tên_HS`, `DC`, `dien_thoai`, `Email`, `Giới tính`) VALUES
    //(NULL,'Lý Đặng Thái Hưng','Việt Nam','123456','lydangthaihung@gmail.com','Chưa xác định')";
    $sql1="INSERT INTO `hoc_sinh` (`ID_HS`, `Tên_HS`, `DC`, `dien_thoai`, `Email`, `Giới tính`) VALUES
    (NULL, '$name','Việt Nam','123456','$email','Chưa xác định')";
     if(mysqli_query($conn,$sql1))
     {
         $last_id = mysqli_insert_id($conn);
         $uni = rand(time(), 1000000000);
         $_SESSION['unique_id']=$uni;
     $sql="INSERT INTO `taikhoan` (`ID`, `ID_User`, `Email`, `Password`, `Dec`, `time_at`, `image`, `status`, `unique_id`, `token`) VALUES
      (NULL, '$last_id', '$email', MD5('1111'), '1',current_timestamp(),'gg.jpg', 'Đang hoạt động', '$uni','$token')";

    $result = mysqli_query($conn,$sql);
            if($result){
           header("location:../hocsinh/danh_sach_khoa_hoc.php");
            } else {
            echo "User is not created";
            die();
            }
     }else
     {
        echo'Thêm học sinh không thành công';
     }
    
  }

} else{
    ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0.1; url= <?php echo $client->createAuthUrl();?>">
  </head>
  <?php
}
?>