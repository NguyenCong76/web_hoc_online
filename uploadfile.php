<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <form method="post" action="" enctype="multipart/form-data">
            <input type="file" name="avatar"/>
            <input type="submit" name="uploadclick" value="Upload"/>
        </form>
        <?php
    if (isset($_POST['uploadclick']))
    {
    
        if (isset($_FILES['avatar']))
        {
            if ($_FILES['avatar']['error'] > 0)
            {
                echo 'File Upload Bị Lỗi';
            }
            else{
                move_uploaded_file($_FILES['avatar']['tmp_name'], './file/'.$_FILES['avatar']['name']);
                echo 'File tải lên thành công';
                header("refresh:3;url=uploadfile.php");
            }
        }
        else{
            echo 'Bạn chưa chọn file upload';
        }
    }
        ?>
        <?php
        /*echo 'Tải file về máy :';
include("includes/downloadfile.php");
set_time_limit(0);
$file_path="file";
output_file($file_path, 'LYDANGTHAIHUNG_19509781_TK2_ERP.zip', 'application/zip');*/

        ?>
    </body>
</html>