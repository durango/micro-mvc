<?php
namespace mvc\web\controller;

class HelloWorld extends Controller {
  public function get_index(){
    $this->render('hello.html');
  }
}
