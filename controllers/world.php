<?php
namespace mvc\web\controller;

class HelloWorld extends Controller {
  public function get_index(){
    $this->render('hello.html');
  }

  public function get_json(){
    $this->render($this->json, array('key' => 'lock', 2, 'hello'));
  }

  public function get_test(){
    $this->render($this->json, array('calling', 'json', 'directly'));
  }

  public function get_test2(){
    $data = array('you','wanted','json','data!');

    switch($this->respond_with){
    case 'json':
      $this->render($this->json, $data);
      break;
    default:
      $this->render('test2.html', $data);
      break;
    }
  }
}
