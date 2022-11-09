<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
 /*function countdown($event,$month,$day,$year) {
 $remain = ceil((mktime(0,0,0,$month,$day,$year)- time()) / 86400);
 if ($remain > 0) {
  echo "<p><strong>$remain</strong> ngày nữa là đến $event.'</p>";
 }
else {
 echo"<p>$event has arrived!</p>";
 }
 }
 countdown("Christmas Day", 8, 30, 2022);*/
$d=ceil(mktime(0,0,0, 8, 12, 2021)-time()/(86400));
echo "Created date is $d" . date("Y-m-d h:i:sa", $d);

?>