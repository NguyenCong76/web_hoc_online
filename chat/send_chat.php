<?php
session_start();
include("../confid.php");
$p=new login();
include("../includes/sql.php");
$q=new sql();
//var_dump($_COOKIE);exit();
$body_msg = @mysqli_real_escape_string($p->connect(), $_POST['body_msg']);
// Xử lý chuỗi $body_msg
$body_msg = htmlentities($body_msg);
$body_msg = trim($body_msg);
 if(isset($_SESSION['unique_id']))
{
     $input_id=$_SESSION['id_nhan'];
     $ouput_id=$_SESSION['unique_id'];
}
else
{
    header("location:users.php");
}
if($_SESSION['block']==true)
{
    echo "<script type='text/javascript'>alert('Người dùng hiện tại chưa muốn nhận tin nhắn từ bạn trong 24 giờ tới. ');</script>";
    header("refresh:3;url=chat.php?id=".Base64_encode(serialize($_SESSION['id_nhan'])).""); exit();
}


?>
<?php
if(!isset($_SESSION['block'])){
   
if(!empty($body_msg))
{
    $mess=Base64_encode(serialize($body_msg));
    $sql="INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `time`) VALUES
    (NULL, '$input_id', '$ouput_id', '$mess', current_timestamp())";
   mysqli_query($p->connect(),$sql);     /// gửi tin nhắn
   header("location:chat.php?id=".Base64_encode(serialize($input_id))."");
   
}
else
{
    header("location:chat.php?id=".Base64_encode(serialize($input_id))."");
}
}else
{
    echo "<script type='text/javascript'>alert('Bạn đã thực hiện chặn người dùng nên không thể nhắn tin.');</script>";
    header("refresh:3;url=chat.php?id=".Base64_encode(serialize($_SESSION['id_nhan'])).""); exit();
}

?>