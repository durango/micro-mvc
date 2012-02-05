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
}
