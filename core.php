<?php
/* Core file for this micro MVC framework*/

namespace mvc\web;

class Core {
  static public $config;
  static public $view;
  static public $controller;
  static public $helpers;
  static public $environment;
  static public $req;
  static public $db;
  static public $connection;

  public function __construct(){
    // Load all of the core files.
    self::loadAll(__DIR__.'/system');

    // Set the main variables
    $this->config       = new \mvc\config\Config();
    $this->environment  = $this->config->get('environment');
    $this->helpers      = new \mvc\helpers\Helpers();
    $this->req          = new \mvc\route\Route($this->config);
    $this->connection   = new \mvc\databases\Connection($this->config);
    $this->db           = $this->connection->db;

    // If our request->controller is empty.. we don't have a route!
    if(!$this->req->controller) self::show404();

    // View engine
    $this->view = new view\View($this->req->controller, $this->environment, $this->helpers, $this->config);

    // Load all of the models
    self::loadAll(__DIR__.'/models');

    // Load all of the controllers
    self::loadAll(__DIR__.'/controllers');

    // Set the controller from snake_form to CamelCase
    $controller = "\mvc\web\controller\\".$this->helpers->to_camel($this->req->controller);

    // Does the controller exist? If not, let's try to scale back to the default controller
    if(class_exists($controller)) $this->controller = new $controller($this);
    else {
      $controller = "\mvc\web\controller\\".$this->helpers->to_camel($this->config->get('controller'));
      $this->controller = new $controller($this);
    }

    // Set the method name (HTTP METHOD _ method), then check if it exists in the controller
    $method = "{$this->req->http_method}_{$this->req->method}";
    (method_exists($this->controller, $method)) ? $this->controller->run($method) : self::show404();

    // Call all_<method> if it exists
    if(method_exists($this->controller, "all_{$this->req->method}")) $this->controller->run("all_{$this->req->method}");
  }

  // Load all .php files within a directory (cleans up our code a bit)
  public function loadAll($location, $follow = false){
    $iterator = new \RecursiveDirectoryIterator($location, \FilesystemIterator::SKIP_DOTS | \FilesystemIterator::FOLLOW_SYMLINKS);
    if($follow === true) $iterator = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST);

    foreach($iterator AS $file)
      if(preg_match('#\.php$#', $file)) include $file;
  }

  // Our simple 404 page.
  public function show404(){
    header("HTTP/1.0 404 Not Found");
    include __DIR__.'/errors/404.php';
    exit;
  }
}

session_start();
$web = new Core();