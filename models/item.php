<?php
namespace mvc\model;

class Item extends Model {
  public $ids, $sql, $vars = array();
  public $functions = array();

  function __construct($sql = null) {
    $this->sql = $sql;
  }

  public function all($limit = ''){
    (is_numeric($limit) && $limit > 0) ? $limit = " LIMIT {$limit}" : $limit = "";
    $this->sql->query("SELECT * FROM items {$limit}");
    $data = array();
    for($x=0;$x<$this->sql->rows;$x++){
      $this->sql->fetch($x);
      $data[$this->sql->data['id']] = $this->sql->data;
    }
    return $data;
  }
}
?>