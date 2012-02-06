<?php
namespace mvc\route;

class Route {
  public $http_method;
  public $controller;
  public $method;
  public $params;

  public function __construct(){
    // Set HTTP method
    $this->http_method = strtolower($_SERVER['REQUEST_METHOD']);

    $path = $_SERVER['REQUEST_URI'];
    if(substr($path, -1) == "/") $path = substr($path, 0, strlen($path)-1);
    $xpath = $path.'/';

    // Fetch the routes..
    include dirname(__DIR__).'/routes.php';

    // Do a quick check if our route exists...
    if(!empty($routes[$path])){
      $action = explode(':', $routes[$path]);
      $this->controller = $action[0];
      $this->method     = $action[1];
    }
    elseif(!empty($routes[$xpath])){
      $action = explode(':', $routes[$xpath]);
      $this->controller = $action[0];
      $this->method     = $action[1];
    } else {
      // Time for the bit more complicated route searching...
      
      // We can remove .json, .xml, etc.
      // TODO: Make this more "magical"
      $remove = array('.json');
      $path = str_replace($remove, '', $path);
      
      $replace = '(?P<\1>[^/]+)';
      $pattern = '!:([^/]+)!';
      // Go through each route, replace all ":" variables with regex
      foreach($routes AS $route => $method){
        $r = preg_replace($pattern, $replace, $route);

        preg_match_all("!$r!", $path, $matches);
        if(count($matches[0]) > 0 && $matches[0][0] == $path){
          foreach($matches AS $key => $val){
            if(is_numeric($key)) continue; // Don't need number keys
            $this->params[$key] = $val[0];
          }
          $action = explode(':', $method);
          $this->controller = $action[0];
          $this->method     = $action[1];
        }
      }
    }
  }
}
