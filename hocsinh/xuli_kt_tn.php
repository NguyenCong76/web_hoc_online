<?php
session_start();
ob_start();
if (isset($_SESSION['user']) && isset($_SESSION['pass']) && isset($_SESSION['id_user']) && isset($_SESSION['ss']) && isset($_SESSION['hs'])) {
    include("../confid.php");
    $p = new login();
    $p->confirm_hs($_SESSION['id_user'], $_SESSION['user'], $_SESSION['pass'], $_SESSION['ss']);
} else {
    header('location:../index.php');
}
include("../includes/sql.php");
$q = new sql();
$d=0;
$s=0;
$ten=$q->laycot($p->connect(),"SELECT Tên_HS FROM `hoc_sinh` WHERE ID_HS=".$_SESSION['id_user']."");

//Kiểm tra thời gian
if(isset($_COOKIE["start_tests"])==2)
{
        if(isset($_POST)) //Khi bấm nút nộp 
        {
            //header("location:xuli_kt_tn.php");exit();
            //var_dump($_POST);exit();
            $mang=$_POST;
           
            foreach($mang as $key => $value)
            {
                if(is_numeric($key)){
                        $sql1="SELECT dap_an FROM `trac_nghiem` WHERE id='$key' LIMIT 1";
                        $res=mysqli_query($p->connect(),$sql1);
                        $da=mysqli_fetch_object($res);

                        if($value==$da->dap_an)
                        {
                          
                            $d++;
                        }else
                        {
                            
                            $s++;
                        }
                        $id_kt=$q->laycot($p->connect(),"SELECT id_kt_tn FROM `trac_nghiem` WHERE id='$key'");
                }
                
            }
                         if($id_kt!=0){
                            $ten_kt=$q->laycot($p->connect(),"SELECT ten FROM `bai_kt_trac_nghiem` WHERE id_kt_tn='$id_kt'");
                            $so_c=$d+$s;
                                $diem=(10/$so_c)*$d;
                                 $diem_s=Base64_encode(serialize($diem));
                                $sqlt="INSERT INTO `bang_diem_tn` (`ID`, `ID_HS`, `ID_KT`, `Ket_qua`, `thoigian_tao`,`theloai`,`Ten_hs`,`Ten_kt`) VALUES
                                (NULL,".$_SESSION['id_user'].",'$id_kt','$diem_s',current_timestamp(),'Trắc nghiệm','$ten','$ten_kt')";
                                if(mysqli_query($p->connect(),$sqlt))
                                {
                                    header("location:all_khoahoc.php");exit();
                                }
                                else
                                {
                                    echo "<script>alert('Nộp bài thất bại.')</script>";
                                   header("refresh:5;url=all_khoahoc.php");exit();
                                }  
                         }    
         
        }

}
else
{
  // echo 'hết thời gian'; 
  header("location:all_khoahoc.php");
}
?>
