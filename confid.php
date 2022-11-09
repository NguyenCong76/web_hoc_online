<?php
class login
{
    public function connect()
	{
		$conn=mysqli_connect("localhost","root","","hoc_online");
		if(!$conn)
		{
			echo 'Không kết nối data!!';
		}
		else
		{
			mysqli_set_charset($conn,"utf8");
			return $conn;
		}
		
	}
    public function login_user($user,$pass)
    {
        $pass=md5($pass);
		$sql="SELECT * FROM `taikhoan` WHERE `taikhoan`.`Email`='$user' AND `taikhoan`.`Password` ='$pass'";
		$link=$this->connect();
		$ketqua=mysqli_query($link,$sql);
		$i=mysqli_num_rows($ketqua);
		if($i==1)
		{
		   	while($row=mysqli_fetch_array($ketqua))
			{
				$id=$row['ID'];
				$user=$row['Email'];
				$pass=$row['Password'];
				$id_user=$row['ID_User'];
				$phanquyen=$row['Dec'];
				$uni=$row['unique_id'];
				if($phanquyen==1)
				{
					$_SESSION['id_user']=$id_user;
					$_SESSION['user']=$user;
					$_SESSION['pass']=$pass;
					$_SESSION['ss']=$phanquyen;
					$_SESSION['unique_id']=$uni;
					return 1;
				}
				else if($phanquyen==2)
				{
					$_SESSION['id']=$id;
					$_SESSION['user']=$user;
					$_SESSION['pass']=$pass;
					$_SESSION['ss']=$phanquyen;
					$_SESSION['unique_id']=$uni;
					return 2;
				}
				else if($phanquyen==3)
				{
					$_SESSION['id']=$id;
					$_SESSION['user']=$user;
					$_SESSION['pass']=$pass;
					$_SESSION['id_user']=$id_user;
                    $_SESSION['ss']=$phanquyen;
					$_SESSION['unique_id']=$uni;
					return 3;
				}

			}
		}
		else{
			return 0;
		}
       
    }
    public function confirm_hs($id_user,$user,$pass,$phanquyen)
	{
		$link=$this->connect();
		$sql="SELECT ID FROM `taikhoan` WHERE ID_User='$id_user' AND Email='$user' AND Password='$pass' AND Dec='$phanquyen'";
		$ketqua=mysqli_query($link,$sql);
		$i=@mysqli_num_rows($ketqua);
		if($i>1)
		{
			return 1;		
		}
		else 
		{
			return 0;
		}
	}
    
    public function confirm_gv($id,$user,$pass,$phanquyen)
	{
		$link=$this->connect();
		$sql="SELECT ID FROM `taikhoan` WHERE ID='$id' AND Email='$user' AND Password='$pass' AND Dec='$phanquyen'";
		$ketqua=mysqli_query($link,$sql);
		$i=@mysqli_num_rows($ketqua);
		if($i>1)
		{
			return 1;		
		}
		else 
		{
			return 0;
		}
	}
   
    public function confirm_admin($id,$id_user,$user,$pass,$phanquyen)
	{
		$link=$this->connect();
		$sql="SELECT ID FROM `taikhoan` WHERE ID='$id' AND ID_User='$id_user' AND Email='$user' AND Password='$pass' AND Dec='$phanquyen'";
		$ketqua=mysqli_query($link,$sql);
		$i=@mysqli_num_rows($ketqua);
		if($i>1)
		{
			return 1;		
		}
		else 
		{
			return 0;
		}
	}
	public function laycot($link,$sql)
	{
		$ketqua=@mysqli_query($link,$sql);
		@mysqli_close($link); //chạy xong đóng kết nối
		$i=@mysqli_num_rows($ketqua); 
		$giatri='';
		if($i>0)
		{
			
			while($row=@mysqli_fetch_array($ketqua))
			{
				$id=$row['0'];
				$giatri=$id;
			}
		}
		return $giatri;
		@mysqli_close($link);
	}

}
?>