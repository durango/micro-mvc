<?php
/* View engine */

namespace mvc\web\view;

class View {
  public $twig;

  public function __construct($path, $env, $helpers, $config){
    /*
    We use Twig over Smarty for no real reason. Compilation is faster
    but execution code is *slightly* slower*. Haanga, despite
    being faster than both engines, cannot be used due to no
    way of recursive view folders (can't separate views folders
    into controller names).

      * According to some benchmarks, Twig is actually faster
    */

    $path = $helpers->to_snake(ucfirst($path));

    // Build our list of directories.
    $dirs = array(dirname(__DIR__).'/views');
    if(file_exists(dirname(__DIR__).'/views/'.strtolower($path)))
      array_push($dirs, dirname(__DIR__).'/views/'.strtolower($path));

    switch(strtolower($config->get('view_engine'))) {
    case 'smarty':
      $this->engine = new Smarty($dirs, $env);
      break;
    case 'twig':
    default:
      $this->engine = new Twig($dirs, $env);
      break;
    }
  }

  public function render($file, array $args = array()){
    $this->engine->render($file, $args);
  }
}

class Smarty {
  static public $engine;

  public function __construct($dirs, $env){
    require_once __DIR__.'/Smarty/Smarty.class.php';

    $array = array();
    $this->engine = new \Smarty();
    $this->engine->setTemplateDir($dirs)
                 ->setCacheDir(dirname(__DIR__).'/cache')
                 ->setCompileDir(dirname(__DIR__).'/cache/compiled');
  }

  public function assign_variables(array $args){
    foreach($args AS $key => $val)
      $this->engine->assign($key, $val);
  }

  public function render($file, array $args = array()){
    $this->assign_variables($args);
    echo (is_a($file, '\mvc\web\controller\JSON')) ? json_encode($args) : $this->engine->display($file);
  }
}

class Twig {
  static public $engine;

  public function __construct($dirs, $env){
    require_once __DIR__.'/Twig/Autoloader.php';
    \Twig_Autoloader::register();

    $loader = new \Twig_Loader_Filesystem($dirs);
    $array = array();
    if($env == "production") $array += array('cache' => dirname(__DIR__).'/cache');

    $this->engine = new \Twig_Environment($loader, $array);
  }

  public function render($file, array $args = array()){
    echo (is_a($file, '\mvc\web\controller\JSON')) ? json_encode($args) : $this->engine->render($file, $args);
  }
}