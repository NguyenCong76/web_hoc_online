<?php
session_start();
include("../confid.php");
$p=new login();
include("../includes/sql.php");
$q=new sql();
$lay_id='';
$token='';
if(isset($_SESSION['user_token'])){
  $lay_id=unserialize(base64_decode($_GET['id']));
  $_SESSION['id_nhan']=$lay_id;
  $avt=$q->laycot($p->connect(),"SELECT image FROM `taikhoan` WHERE unique_id='$lay_id'") ;
  $mail=$q->laycot($p->connect(),"SELECT Email FROM `taikhoan` WHERE unique_id='$lay_id'");
  $tt=$q->laycot($p->connect(),"SELECT status FROM `taikhoan` WHERE unique_id='$lay_id'") ;
}
else if(isset($_SESSION['unique_id']))
{
  $lay_id=unserialize(base64_decode($_GET['id']));
  $_SESSION['id_nhan']=$lay_id;
  $avt=$q->laycot($p->connect(),"SELECT image FROM `taikhoan` WHERE unique_id='$lay_id'") ;
  $mail=$q->laycot($p->connect(),"SELECT Email FROM `taikhoan` WHERE unique_id='$lay_id'");
  $tt=$q->laycot($p->connect(),"SELECT status FROM `taikhoan` WHERE unique_id='$lay_id'") ;
}
else
{
  header("location:users.php");
}


//$mail=$p->laycot($p->connect(),"SELECT Email FROM `taikhoan` WHERE unique_id='$lay_id'");
$output='';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  
   <style>
    body {
  margin: 0 auto;
  max-width: 800px;
  padding: 0 20px;
}

.container {
  border: 2px solid #dedede;
  background-color: #f1f1f1;
  border-radius: 5px;
  padding: 10px;
  margin: 10px 0;
}

.darker {
  border-color: #ccc;
  background-color: #ddd;
}

.container::after {
  content: "";
  clear: both;
  display: table;
}

.container img {
  float: left;
  max-width: 60px;
  width: 100%;
  margin-right: 20px;
  border-radius: 50%;
  height:50px;
}

.container img.right {
  float: right;
  margin-left: 20px;
  margin-right:0;
}

.time-right {
  float: right;
  color: #aaa;
}

.time-left {
  float: left;
  color: #999;
}
   </style>
</head>
<body>
  <div class="wrapper">
    <section class="chat-area">
      <header>
        <a href="users.php" class="back-icon">
          <i class="fas fa-arrow-left"></i>
        </a>
        <img src="../hinh/<?php echo $avt; ?>" alt="">
        <div class="details">
          <span><?php echo $p->laycot($p->connect(),"SELECT Tên_HS FROM `hoc_sinh` WHERE Email='$mail'"); ?></span>
          <div><p><i style="color:green;"><?php echo $tt; ?></i></p></div>
          <h4><form action="" method="POST"><input type="submit" name="chan" value="Chặn người này"> <input type="submit" name="chan" value="Bỏ chặn"></form></h4>
          <?php
                if(isset($_POST['chan']))
                switch($_POST['chan'])
                {
                  case'Chặn người này':
                    {
                      if(!isset($_SESSION['block'])){
                      $_SESSION['block']=true;
                      echo "<script type='text/javascript'>alert('Đã thực hiện chặn người dùng thành công.');</script>";
                      }else{
                        echo 'Đang chặn người dùng.';
                      }
                    }break;
                    case'Bỏ chặn':
                      {
                        if(isset($_SESSION['block']))
                        {
                          unset($_SESSION['block']);
                          echo 'Đã bỏ chặn người dùng.';
                        }else{
                          echo 'Chưa có hành động chặn người dùng.';
                        }

                      }break;
                }
            ?>
        </div>
      </header>
      <div class="chat-box">
  
      </div>
      <form action="" class="typing-area" id="formSend" method="POST"  onsubmit="return false;" >
    
        <input type="text" name="message" class="input-field" placeholder="Nhập nội dung ở đây..." >
        
      </form>
    </section>
  </div>
  <script type="text/javascript">
  // Hàm gửi tin nhắn
function sendMsg(){
    // Khai ba1oca1c biến trong form
    $body_msg = $('#formSend input[type="text"]').val();
 
    // Gửi dữ liệu
    $.ajax({
        url: 'send_chat.php', // đường dẫn file xử lý
        type: 'POST', // phương thức
        // dữ liệu
        data: {
            body_msg: $body_msg
                    // thực thi khi gửi dữ liệu thành công
        }, success: function () {
            $('#formSend input[type="text"]').val(''); // làm trống thanh trò chuyện
        }
    });
}
// Bắt sự kiện gõ phím enter trong thanh trò chuyện
$('#formSend input[type="text"]').keypress(function () {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13'){
        // Chạy hàm gửi tin nhắn
        sendMsg();
    }
});
// Bắt sự kiện click vào thanh trò chuyện
$('#formSend input[type="text"]').click(function (e) {
    // Kéo hết thanh cuộn trình duyệt đến cuối
    window.scrollBy(0, $(document).height());
});
$.ajaxSetup({cache:false});
// Thiết lập thời gian thực vòng lặp 1 giây
setInterval(function() {$('.chat-box').load('show.php');}, 1000);
 </script>
  
</body>
</html>