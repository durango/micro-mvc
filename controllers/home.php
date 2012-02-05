<?php
namespace mvc\web\controller;

class Home extends Controller {
  public function before(){
    // This will get called before each request...
    $this->rack['before'] = 'Called before hand!';
  }

  public function get_index(){
    $this->render('index.html', $this->rack);
  }

  public function post_index(){
    $this->rack['name'] = $_POST['name'];
    $this->render('hello.html', $this->rack);
  }

  public function all_index(){
    echo 'This will be called on all HTTP methods for index as well!';
  }

  public function get_hello(){
    $this->render('doi.html', $this->rack);
  }

  public function get_user(){
    $item = new \mvc\model\Item($this->db);
    $items = $item->all();
    echo "Viewing user {$this->params['id']}<br>";
    if(count($items) < 1)
      echo 'There are no items!';
    else
      foreach($items AS $item)
        echo $item['name'].' ($'.number_format($item['cost']).')<br>';
  }

  public function get_article(){
    echo "Viewing article {$this->params['article']}";
  }

  public function get_redirect(){
    $this->helpers->redirect('/');
  }
}