<?php
$routes = array(
  '/' => 'home:index',
  '/hello' => 'home:hello',
  '/user/:id' => 'home:user',
  '/category/:article' => 'home:article',
  '/world' => 'HelloWorld:index'
);
