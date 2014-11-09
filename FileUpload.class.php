<?php
/****************************************
Author: Kuei App
******************************************/

class GetUpload
{
    private $FILE;
    function __construct($arrUploadFile)
    {
        $this->FILE = $arrUploadFile;
    }
    
// Check file format
    function checkFiles()
    {
        $filename = $this->FILE['file']['name'];
        if( $filename != '' ) 
        {
            $filenameArr = explode('.',$filename);
            $tmpFile = strtolower($filenameArr[1]);
            if( strtolower($tmpFile) !== '3w') 
            {
                echo "<pre>請上傳 .3w 的檔案.</pre>";
                return 0;
            }else 
            {
                return $filename;
            }
        }
    
    
    }

// Move files
    function doUpload($filename,$email)
    {
    // upload file
        $root = "root/path/to";
    // check permission
        if( !is_dir($root) ) mkdir($root,'0700');
        if( !is_dir("$root/$email") ) mkdir("$root/$email", '0700');
    
        $path = $email.'/'.$filename;
        $uploadTo = $root.'/'.$path;

        if($this->FILE["file"]["error"] !== 0 )
        {
           echo '<pre>500 上傳程序錯誤：',$this->FILE["file"]["error"].", 請聯絡系統管理員</pre>";
                    return 0;
        }
        else if($this->FILE['file']['size'] == 0){
            echo '<pre>500 上傳程序錯誤： 檔案大小不可為零</pre>';
                    return 0;
        }
        else
        {
            if( is_uploaded_file($this->FILE['file']['tmp_name']) )
            {
                if( move_uploaded_file($this->FILE['file']['tmp_name'], iconv('UTF-8','BIG5',$uploadTo)) ) 
                {				
                    $Type = $this->FILE['file']['type'];
                    $Size = $this->FILE['file']['size'];
                    $Name = $this->FILE['file']['name'];
                    echo "<pre>
檔案上傳成功.
檔名：$Name
大小：$Size / 1024 kb</pre>";//類型：$Type<br/>";
                    return $path;
                } 
                else 
                {
                    echo '<pre>500 移動檔案錯誤, 請聯絡系統管理員</pre>';
                    return 0;
                }
            }
        
        
        }

    }// doUpload




}//class