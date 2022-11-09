<?php
 
class Extractor 
{
    public static function extract($archive,$destination)
    {
        $ext= pathinfo($archive,PATHINFO_EXTENSION);
        switch($ext){
            case'zip':
                $res= self::extractZipArchive($archive,$destination);
                break;
            case'gz':
                $res= self::extractGzipFile($archive,$destination);
                break;
         
        }
        return $res;
    }
    
    public static function extractZipArchive($archive,$destination)
    {
        
        /*if(class_exists('ZipArchive'))
        {
            $GLOBALS['status']=array('error'=>'Lỗi phiên bản PHP (zip)');
            return false;
        }*/
       
        $zip=new ZipArchive();
        if($zip->open($archive)==TRUE)
        {
            if(is_writeable($destination. '/'))
            {
                $zip->extractTo($destination);
                $zip->close();
                $GLOBALS['status']=array('success'=>"File giải nén thành công.");
                return true;
            }
            else
            {
                $GLOBALS['status']=array('error'=>"File giải nén thất bại.");
                return false;
            }
        }
        else
        {
            $GLOBALS['status']=array('error'=>"Không đọc được file.");
                return false;
        }
    }
    public static function extractGzipFile($archive,$destination)
    {
        if(!function_exists('gzopen'))
        {
            $GLOBALS['status']=array('error'=>"PHP không hỗ trợ.");
            return false;
        }
        $filename= pathinfo($archive, PATHINFO_FILENAME);
        $gzipped= gzopen($archive,"rb");
        $file= fopen($filename,"w");
        While($string=gzread($gzipped,4096))
        {
            fwrite($file,$string,strlen($string));
        }
        gzclose($gzipped);
        fclose($file);

        if(file_exists($destination.'/'.$filename))
        {
            $GLOBALS['status']=array('success'=>"File giải nén thành công.");
            return true;
        }
        else
        {
            $GLOBALS['status']=array('error'=>"File giải nén thất bại.");
            return false;
        }
    }
}

?>