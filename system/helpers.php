<?php
namespace mvc\helpers;

class Helpers {
  public function to_snake($val) {
    return substr(preg_replace_callback('/[A-Z]/',
      create_function('$match', 'return "_" . strtolower($match[0]);'), $val), 1);
  }

  public function to_camel($val) {
    $val = str_replace(' ', '', ucwords(str_replace('_', ' ', $val)));
    $val = strtolower(substr($val,0,1)).substr($val,1);
    return $val;
  }

  public function redirect($path, $perm = false){
    if($perm === true) header("HTTP/1.1 301 Moved Permanently");
    header("Location:{$path}");
    exit;
  }

  public function sendfile($file){
    // Send a file to the browser, fix MSIE bug.
    if(ini_get('zlib.output_compression')) 
      ini_set('zlib.output_compression', 'Off'); 
    if(file_exists($file)) { 
      if(strstr($_SERVER["HTTP_USER_AGENT"],"MSIE") == false) { 
        header("Content-Type: application/force-download"); 
        header('Content-Description: File Transfer'); 
      } 
      readfile($file);
      exit; 
    } 
  }
}