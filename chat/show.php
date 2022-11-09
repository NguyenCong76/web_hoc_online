<?php
session_start();
include("../confid.php");
$p = new login();
include("../includes/sql.php");
$q = new sql();
$lay_id = $_SESSION['id_nhan'];


//xử lí để hiện tin nhắn 
$sql = "SELECT * FROM `messages`  JOIN `taikhoan` ON `taikhoan`.unique_id = `messages`.outgoing_msg_id
WHERE (outgoing_msg_id =" . $_SESSION['unique_id'] . " AND incoming_msg_id ='$lay_id')
OR (outgoing_msg_id ='$lay_id' AND incoming_msg_id = " . $_SESSION['unique_id'] . ") ORDER BY msg_id ASC";
$query_get_msg = mysqli_query($p->connect(), $sql);
while ($row = mysqli_fetch_assoc($query_get_msg)) {
    if ($row['outgoing_msg_id'] === $_SESSION['unique_id']) {
?>
        <div class="container darker">
            <img src="../hinh/<?php echo $q->laycot($p->connect(), "SELECT image FROM`taikhoan` WHERE unique_id=" . $_SESSION['unique_id'] . "") ?>" alt="Avatar" class="right">
            <p><?php echo unserialize(base64_decode($row['msg'])); ?></p>
            <span class="time-left"><?php echo $row['time']; ?></span>
        </div>
    <?php } else { ?>
        <div class="container">
            <img src="../hinh/<?php echo $q->laycot($p->connect(), "SELECT image FROM`taikhoan` WHERE unique_id='$lay_id' ") ?>" alt="Avatar">
            <p><?php echo unserialize(base64_decode($row['msg'])); ?></p>
            <span class="time-right"><?php echo $row['time']; ?> </span>
        </div>


<?php }
} ?>