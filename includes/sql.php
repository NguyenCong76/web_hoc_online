<?php

class sql
{
    public function connect()
	{
	    $con=mysqli_connect("localhost","root","","hoc_online");
		if(!$con)
		{
			echo'Khong ket noi du lieu';
			exit();
		}
		else
		{
			
			mysqli_set_charset($con,"utf8");
			return $con;
		}
	}
    public function themxoasua($link,$sql)
    {
		if(mysqli_query($link,$sql))
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
		@mysqli_close($link); //chạy xong đóng kết nối
	}
	public function layten($s)
	{
		$link=$this->connect();
        $sql="SELECT Tên_HS FROM `hoc_sinh` WHERE Email='$s'";
		$ketqua=@mysqli_query($link,$sql);
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
		@mysqli_close($link); //chạy xong đóng kết nối
	}
	public function layten_kt($s)
	{
		$link=$this->connect();
        $sql="SELECT ten FROM `bai_kt_trac_nghiem` WHERE ID_khoa='$s'";
		$ketqua=@mysqli_query($link,$sql);
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
		@mysqli_close($link); //chạy xong đóng kết nối
	}
	public function laytenkhoa($s)
	{
		$link=$this->connect();
        $sql="SELECT Ten_khoa FROM `khoa_hoc` WHERE ID_khoa='$s'";
		$ketqua=@mysqli_query($link,$sql);
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
		@mysqli_close($link); //chạy xong đóng kết nối
	}
	public function gv_load_khoa($link,$sql)
	{
		$ketqua=@mysqli_query( $link,$sql);
		@mysqli_close($link);
		 $i=@mysqli_num_rows ($ketqua);
		  if ($i>0)	
		  { 
		    while ($row = @mysqli_fetch_array($ketqua))
			{
               $id=$row['ID_khoa'];
			   $ten=$row['Ten_khoa'];
               $mo=$row['mota'];
			
				echo'
			<div class="col-sm-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">'.$ten.'</h5>
                                <p class="card-text">'.$mo.'</p>
                                <a href="?id='.Base64_encode(serialize($id)).'" class="btn btn-primary">Chọn chỉnh sửa </a><hr>
								<a href="../hocsinh/chitiet_khoahoc.php?ids='.Base64_encode(serialize($id)).'" class="btn btn-success">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
		
			';

			}
		
		  }
	}
	public function load_khoa($conn,$sql)
	{
		$ketqua=@mysqli_query($conn,$sql);
		
		 $i=@mysqli_num_rows ($ketqua);
		  if($i>0)	
		  { 
		    while ($row = @mysqli_fetch_array($ketqua))
			{
               $id=$row['ID_khoa'];
			   $ten=$row['Ten_khoa'];
               $mo=$row['mota'];
			
				echo'
			<div class="col-sm-4">
                        <div class="card" style="width: 18rem;">
                            <div class="card-body">
                                <h5 class="card-title">'.$ten.'</h5>
                                <p class="card-text">'.$mo.'</p>
                                <a href="?id='.Base64_encode(serialize($id)).'" class="btn btn-primary">Đăng kí </a>
								<a href="./chitiet_khoahoc.php?ids='.Base64_encode(serialize($id)).'" class="btn btn-primary">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
		
			';
			}
		  }
		  @mysqli_close($conn);
	}
	public function load_khoa_test($conn,$sql)
	{
		$ketqua=@mysqli_query( $conn,$sql);
		 $i=@mysqli_num_rows($ketqua);
		 mysqli_close($conn);
		  if ($i>0)	
		  { 
		    while ($row=@mysqli_fetch_array($ketqua))
			{
               //$id=$row['ID_khoa'];
			   $ten=$row['Ten_khoa'];
			   $tg=$row['thoigian'];
               $mo=$row['mota'];
				echo'
				<div class="col-sm-4">
							<div class="card" style="width: 18rem;">
								<div class="card-body">
									<h5 class="card-title">'.$ten.'</h5>
									<p class="card-text">'.$mo.'</p>
									<p class="">'.$tg.'</p>
								</div>
							</div>
						</div>
				';
			}
		  }
		  
	}
	public function upload($name,$tmp_name,$folder)
	{
		if($name!='' && $tmp_name!='' && $folder!='')
		{
			$newname=$folder."/".$name;
			if(move_uploaded_file($tmp_name,$newname))
			{
				return 1;

			}
			return 0;
		}else
		{
			return 0;
		}
	}
	public function load_test($link,$sql)
	{
		$ketqua=mysqli_query( $link,$sql);
		@mysqli_close($link);
		 $i=@mysqli_num_rows ($ketqua);
		  if ($i>0)	
		  { 
			echo '<table style="border:1px solid black; background-color: black; color:white;"> <tr>
				   <td >Tên bài kiểm tra</td>
				   <td>Thời gian</td>
				   <td>Thời lượng</td>
				   <td>Ghi chú</td>
               </tr>
			';
		    while ($row = @mysqli_fetch_array($ketqua))
			{
               $id=$row['ID_KT'];
			   $ten=$row['Ten_KT'];
			   $tg=$row['thoi_gian'];
               $th=$row['thoi_luong'];
               $note=$row['ghichu'];
				echo '<tr >
				<td><a href="?ids='.Base64_encode(serialize($id)).'">'.$ten.'</a></td>
				<td>'.$tg.'</td>
				<td>'.$th.'</td>
				<td>'.$note.'</td>
				</tr>
				';
			}
			echo '</table>';
		  }
	}
	public function getData($link,$sql){
		$ketqua=mysqli_query( $link,$sql);
		@mysqli_close($link);
		 $i=@mysqli_num_rows ($ketqua);
		  if ($i>0)	
		  {
			echo '<table class="table"> <tr>
		
			       <td>Hình</td>
				   <td>Email</td>
				   <td>Trạng thái</td>
               </tr>
			';
			while ($row = @mysqli_fetch_array($ketqua))
			{
               $id=$row['unique_id'];
			   $token=$row['token'];
			   $ten=$row['Email'];
			   $hinh=$row['image'];
            $tt=$row['status'];
				echo '<tr >
				<td><a href="chat.php?id='.Base64_encode(serialize($id)).'&token='.Base64_encode(serialize($token)).'"><image src="../hinh/'.$hinh.'" width=40px; height=auto></a></td>
				<td>'.$ten.'</td>
				<td>'.$tt.'</td>
				</tr>
				';
			}
			echo '</table>';
		  }
    }
	function loadcombo_khoa($link,$sql)
    {  
        $ketqua = mysqli_query($link,$sql);
        mysqli_close($link);
        $i=mysqli_num_rows($ketqua);
        if($i>0)
        {
			echo '<td><select name="khoa" id="khoa">';
			echo '<option>Chọn khóa</option>';
            while($row=mysqli_fetch_array($ketqua))
            {
               
                $id_khoa = $row['ID_khoa'];
                $tenkhoa = $row['Ten_khoa'];
                    echo '<option value="'.$id_khoa.'">'.$tenkhoa.'</option>';
            }
			echo '</select></td>';
        }

	}
	function load_diemdanh($link,$sql)
	{
		$ten='';
		$ketqua = mysqli_query($link,$sql);
        mysqli_close($link);
        $i=mysqli_num_rows($ketqua);
		if($i>0)
		{ 
			echo '<table class="table" >
			<tr style="background-color:blue; color: white;">
				<td>STT</td>
				<td>Họ và Tên</td>
				<td>Email</td>
				<td>Ngày điểm danh</td>
				<td>Thời gian</td>
				<td>Trạng thái</td>
			</tr>';
			while($row=mysqli_fetch_array($ketqua))
			{
				$id=$row['ID'];
				$mail=$row['Email'];
				$date=$row['date'];
				$time=$row['time'];
				$tt=$row['trangthai'];
				//$res="SELECT Tên_HS FROM `hoc_sinh` WHERE Email='$mail'";
                //$ten=layten($mail);
				echo "<tr>
				<td>$id</td>
				<td>$ten</td>
				<td>$mail</td>
				<td>$date</td>
				<td>$time</td>
				<td>$tt</td>
				</tr>";
			}
			echo'</table>';
		}
	}
	public function load_ds_hs($link,$sql)
	{
		$ketqua=mysqli_query( $link,$sql);
		@mysqli_close($link);
		 $i=@mysqli_num_rows ($ketqua);
		 $j=1;
		  if ($i>0)	
		  { 
		    while ($row = @mysqli_fetch_array($ketqua))
			{
               $id=$row['ID_HS'];
			   $ten=$row['Tên_HS'];
			   $gt=$row['Giới tính'];
               $dc=$row['DC'];
               $email=$row['Email'];
				echo "<tr>
						<td>$j</td>
						<td>$ten</td>
						<td>$gt</td>
						<td>$dc</td>
						<td>$email</td>
					</tr>";
					$j+1;
			}
		  }
	}
	public function xuat_bl($link,$s)
	{
		$sql1="SELECT * FROM `binhluan_khoahoc` WHERE ID_khoa='$s' ORDER BY ID_bl ASC";
		$ketqua = mysqli_query($link,$sql1);
        
        $i=@mysqli_num_rows($ketqua);
		if($i>0)
		{ 
			while($row=mysqli_fetch_array($ketqua))
			{
				
					$noidung=$row['noidung'];
					$time=$row['thoigian'];
					 $hinh=$this->laycot($link,"SELECT image FROM `taikhoan` WHERE ID_User=".$row['ID_HS']."");
					 $ten=$this->laycot($link,"SELECT Tên_HS FROM `hoc_sinh` WHERE ID_HS=".$row['ID_HS']."");
					//echo "<image src='../hinh/$hinh' width=40px; height=auto> <span>$noidung</span><br> <i>$time</i> <br>";
					echo "<br><form style='border:1px solid #08088A ;width:700px';>
					<div class='row'>
					  <div class='col-sm-9'>
							
							<image src='../hinh/$hinh' class='rounded-circle' width=40px; height=40px;> 
							<span class='text-capitalize'> $ten</span>	<br>	
							<div class='col-sm-6'></div>			
						    <div class='col-sm-6'><span class='font-weight-bolder'> $noidung</span></div>
							
					  </div>
					  <div class='col-sm-3'>
					  <p class='font-italic' style='color:blue'; >$time</p>
					  </div>
					</div>
				  </form>";
			}		
		}
		mysqli_close($link);
	}
	public function load_cau_hoi($link,$sql)
	{
		$ketqua = mysqli_query($link,$sql);
        mysqli_close($link);
        $i=mysqli_num_rows($ketqua);
		if($i>0)
		{
			echo'
			<table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Câu hỏi</th>
						<th scope="col">Đáp án đúng</th>
						<th scope="col">Thao tác</th>
                      </tr>
                    </thead>
			';
			$dem=1;
			while($row=mysqli_fetch_array($ketqua))
			{
				$id=$row['id'];
				$cau_hoi=$row['cau_hoi'];
				$dap_an=$row['dap_an'];
				$id_kt=$row['id_kt_tn'];
				echo'
					<tbody>
                      <tr>
                        <td>'.$dem.'</td>
                        <td>'.$cau_hoi.'</td>
						<td>'.$dap_an.'</td>
                        <td> <a href="?ids='.Base64_encode(serialize($id)).'&id='.Base64_encode(serialize($id_kt)).'" class="btn btn-primary">Chọn</a></td>
                      </tr>
                    </tbody>
				';
				$dem++;
			}
			echo '</table>';
		}
		else
		{
			echo'Không có câu hỏi';
		}
	}

	public function load_bai_kt_tn($link,$sql)
	{
		$ketqua = mysqli_query($link,$sql);
        mysqli_close($link);
        $i=mysqli_num_rows($ketqua);
		if($i>0)
		{
			echo'
			<table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">STT</th>
                        <th scope="col">Tên bài kiểm tra</th>
						<th scope="col">Thời lượng</th>
						<th scope="col">Thời gian</th>
						<th scope="col">Thao tác</th>
                      </tr>
                    </thead>
			';
			$dem=1;
			while($row=mysqli_fetch_array($ketqua))
			{
				$id=$row['id_kt_tn'];
				$ten=$row['ten'];
				$thoi_luong=$row['thoi_luong'];
				$thoi_gian=$row['thoi_gian'];
				$id_khoa=$row['ID_khoa'];
				echo'
					<tbody>
                      <tr>
                        <td>'.$dem.'</td>
                        <td>'.$ten.'</td>
						<td>'.$thoi_luong.' phút</td>
						<td>'.$thoi_gian.'</td>
                        <td> <a href="?ids='.Base64_encode(serialize($id)).'&id='.Base64_encode(serialize($id_khoa)).'" class="btn btn-primary">Chọn</a></td>
						<td> <a href="gv_tao_cau_hoi_tn.php?id_kt='.Base64_encode(serialize($id)).'" class="btn btn-success">Tạo câu hỏi</a></td>
                      </tr>
                    </tbody>
				';
				$dem++;
			}
			echo '</table>';
		}
		else
		{
			echo'Không có bài kiểm tra';
		}
	}
	
}
?>
