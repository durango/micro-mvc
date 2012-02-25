<?php
namespace mvc\web\controller;

abstract class Controller {
  static public $core;
  static public $db;
  public $params;
  public $rack = array();
  public $helpers;
  public $respond_with;

  /* Data types */
  public $json;
  public $xml;

  public function __construct($vars){
    self::$core = $vars;
    $this->db       = $vars->db;
    $this->params   = $vars->req->params;
    $this->helpers  = $vars->helpers;
    $this->json     = new JSON();
    $this->xml      = new XML();
    $this->respond_with = pathinfo($_SERVER['REQUEST_URI'], PATHINFO_EXTENSION);
  }

  public function run($method){
    self::before();
    if(method_exists(get_called_class(), 'before')) static::before();
    static::$method();
    if(method_exists(get_called_class(), 'after')) static::after();
    self::after();
  }

  public function render($file, array $args = array()){
    self::$core->view->render($file, $args);
  }

  /* Actions to call before rendering */
  public function before(){
  }

  /* Actions to call after rendering */
  public function after(){
  }
}

/*
 Abstract classes for rendering as (JSON, serialization, XML, whatever)
 Eventually we could put some business logic in here if we wanted to
*/
class JSON {}

class XML {
  public function array_to_xml($array){
    if(is_string($array)) return simplexml_load_string($array);

    $xml = new \SimpleXMLElement("<?xml version=\"1.0\"?><data></data>");

    foreach($array as $key => $value) {
      if(is_array($value)) {
        if(!is_numeric($key)){
          $subnode = $xml->addChild($key);
          $this->array_to_xml($value);
        }
        else
          $this->array_to_xml($value);
      }
      else {
        if(is_numeric($key)) $key = "Row";
        $xml->addChild($key,$value);
      }
    }

    return $xml;
  }
}
