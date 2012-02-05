<?php
namespace mvc\config;

class Config {
  // Store all of the values from the config file...
  private static $config = null;

  function __construct(){
    $this->load();
  }

  // Load the config file
  public static function load(){
    self::$config = parse_ini_file(dirname(__DIR__).'/config.ini');
    if(!self::$config) throw new Exception("Config file could not be loaded!");
  }

  // Get a config key
  public static function get($key){
    if(!isset(self::$config)) self::load();

    if(isset(self::$config[$key]))
      return self::$config[$key];

    return NULL;
  }
}