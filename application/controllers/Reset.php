<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reset extends CI_Controller {
    public function index($code)
    {
        if($code=='5fmjDRS6mF'){
            //deleting files
            $files = glob($_SERVER['DOCUMENT_ROOT'].'/CDB/uploads/*'); // get all file names
            foreach($files as $file)
            { // iterate files
                if(is_file($file))
                    unlink($file); // delete file
                echo $file.' deleted';
            }
    
            //copying files
            //preparing the paths
            $dstdir=$_SERVER['DOCUMENT_ROOT']."/CDB/uploads";
            $srcdir=$_SERVER['DOCUMENT_ROOT']."/CDB/uploads2";
            $srcdir=rtrim($srcdir,'/');
            $dstdir=rtrim($dstdir,'/');
    
            //creating the destination directory
            if(!is_dir($dstdir))mkdir($dstdir, 0777, true);
    
            //Mapping the directory
            $dir_map=directory_map($srcdir);
    
            foreach($dir_map as $object_key=>$object_value)
            {
                if(is_numeric($object_key))
                      echo copy($srcdir.'/'.$object_value,$dstdir.'/'.$object_value);//This is a File not a directory
                      echo "<br />";
            }
            //End Copy Files
            
            //deleting files
            $files2 = glob($_SERVER['DOCUMENT_ROOT'].'/CDB/application/sqlite/*'); // get all file names
            foreach($files2 as $file2)
            { // iterate files
                if(is_file($file2))
                    unlink($file2); // delete file
                echo $file2.' deleted';
            }
    
            //copying files
            //preparing the paths
            $dstdir2=$_SERVER['DOCUMENT_ROOT']."/CDB/application/sqlite";
            $srcdir2=$_SERVER['DOCUMENT_ROOT']."/CDB/application/sqlite2";
            $srcdir2=rtrim($srcdir2,'/');
            $dstdir2=rtrim($dstdir2,'/');
    
            //creating the destination directory
            if(!is_dir($dstdir2))mkdir($dstdir2, 0777, true);
    
            //Mapping the directory
            $dir_map2=directory_map($srcdir2);
    
            foreach($dir_map2 as $object_key=>$object_value)
            {
                if(is_numeric($object_key))
                      echo copy($srcdir2.'/'.$object_value,$dstdir2.'/'.$object_value);//This is a File not a directory
                      echo "<br />";
            }
            //End Copy Files
            
        } else {
            echo "code wrong";
        }
    }
}