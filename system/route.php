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
    if(!empty($routes[$path]))      $this->set_route($routes[$path]);
    elseif(!empty($routes[$xpath])) $this->set_route($routes[$xpath]);
    else {
      // Time for the bit more complicated route searching...

      // We can remove .json, .xml, etc.
      // NOTE: Make this more "magical"
      $remove = array('.json','.xml');
      $path = str_replace($remove, '', $path);

      $replace = '(?P<\1>[^/]+)';
      $pattern = '!:([^/]+)!';
      // Go through each route, replace all ":" variables with regex
      foreach($routes AS $route => $method){
        // Skip easy routes
        if(strpos($route, ':') === false && $route != $path) continue;

        $r = preg_replace($pattern, $replace, $route);

        preg_match_all("!$r!", $path, $matches);
        if((count($matches[0]) > 0 && $matches[0][0] == $path) || $route == $path){
          foreach($matches AS $key => $val){
            if(is_numeric($key)) continue; // Don't need number keys
            $this->params[$key] = $val[0];
          }
          $this->set_route($method);
          break;
        }
      }
    }
  }

  private function set_route($path){
      $action = explode(':', $path);
      $this->controller = $action[0];
      $this->method     = $action[1];
  }
}
