<?php
namespace mvc\databases;

class Connection {
  public $db;

  public function __construct($config){
    switch(strtolower($config->get('db_type'))){
    case 'mysql':
    default:
      $this->db = new Database_MySQL($config);
    }
  }
}

class Errors {
  function log_error($query, $error) {
    if($this->debug) return $query.'<br><br>'.mysql_error();
    else  {
      $info =	debug_backtrace();
      $info = $info[1];
      $contents = file_get_contents(dirname(__DIR__).'/errors/sql.txt');
      $fh = fopen(dirname(__DIR__).'/errors/sql.txt', 'w');
      fwrite($fh, $contents."\n".date('M d Y h:i:s').' - '.$error."\nInfo: {$info['file']} at line {$info['line']}\nQuery: {$query}\n\n");
      fclose($fh);
      return 'A problem has occurred with the database. We have filed the error and will fix the problem as soon as possible.';
    }
  }

  function getTime() {
    $time = microtime();
    $time = explode(' ', $time);
    $time = $time[1] + $time[0];
    $start = $time;
    return $start;
  }
}

class Database_MySQL extends Errors {
  protected $user;
  protected $pass;
  protected $host;
  protected $db;
  protected $id;

  public $rows;
  public $data;
  public $queryCount = 0;
  public $queries = array();
  public $last_id;
  public $affectedRows;
  public $debug;

  public function __construct($config) {
    if(empty($this->user)) $this->user  = $config->get('db_user');
    if(empty($this->pass)) $this->pass  = $config->get('db_pass');
    if(empty($this->host)) $this->host  = $config->get('db_host');
    if(empty($this->db))   $this->db    = $config->get('db_name');

    $this->id = mysql_connect($this->host, $this->user, $this->pass) or die ("Error connecting to database!");
    mysql_select_db($this->db, $this->id);
  }

  public function escape($string) {
    if(get_magic_quotes_runtime()) $string = stripslashes($string);
    if(!is_string($string)) return $string;
    $return = mysql_real_escape_string($string, $this->id);
    return $return;
  }

  protected function wildcard($query, $argv = NULL){
    $q = explode('?', $query);
    $count = 0;
    if(count($q) > 0)
      foreach($q AS $k) {
        $str .= $k.'\''.$this->escape($argv[$count]).'\'';
        ++$count;
      }
    return substr($str, 0, -2);
  }

  public function logQuery($sql, $start) {
    $this->queryCount++;
    $query = array(
      'sql' => $sql,
      'time' => ($this->getTime() - $start) * 1000
    );
    array_push($this->queries, $query);
  }

  public function query($query, $argv=NULL) {
    $start = $this->getTime();
    if(count($argv) > 0) $query = $this->wildcard($query, $argv);

    $this->result = mysql_query($query, $this->id) or die($this->log_error($query, mysql_error()));
    $this->rows = mysql_num_rows($this->result);
    $this->logQuery($query, $start);
    return $this->result;
  }

  public function simple($query, $argv = null) {
    if(count($argv) > 0 && is_array($argv)) $query = $this->wildcard($query, $argv);

    $this->result = mysql_query($query.' LIMIT 1', $this->id) or die($this->log_error($query.' LIMIT 1', mysql_error()));
    $this->rows = mysql_num_rows($this->result);
    $this->data = mysql_fetch_array($this->result);

    return $this->data;
  }

  public function update($query, $argv=NULL) {
    if(count($argv) > 0) $query = $this->wildcard($query, $argv);

    $this->result = mysql_query($query, $this->id) or die($this->log_error($query, mysql_error()));
    $this->affectedRows = mysql_affected_rows();
  }

  public function insert($query, $argv=NULL) {
    if(count($argv) > 0) $query = $this->wildcard($query, $argv);

    $this->result = mysql_query($query, $this->id) or die($this->log_error($query, mysql_error()));
    $this->last_id = mysql_insert_id($this->id);
    $this->affectedRows = mysql_affected_rows();
  }

  public function delete($query, $argv=NULL) {
    if(count($argv) > 0) $query = $this->wildcard($query, $argv);

    $this->result = mysql_query($query) or die($this->log_error($query, mysql_error()));
    $this->affectedRows = mysql_affected_rows();
  }

  public function fetch($row, $assoc=false) {
    if(is_resource($this->result)) { 
      if(mysql_data_seek($this->result, $row))
        if($assoc) $this->data = @mysql_fetch_assoc($this->result);
        else $this->data = @mysql_fetch_array($this->result); 
    }
  }

  public function fetchrows($query, $argv=NULL) {
    if(count($argv) > 0) $query = $this->wildcard($query, $argv);

    $this->result = mysql_query($query) or die (mysql_error());
    $this->rows = @mysql_result($this->result,0);
  }
}
