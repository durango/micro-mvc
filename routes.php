<?php
/*
Route -> Controller:Method

A good rule of thumb is to
type out the controller name as-is...
*/
$routes = array(
  // ...but you don't have to
  '/' => 'home:index',
  '/hello' => 'home:hello',
  '/user/:id' => 'home:user',
  '/category/:article' => 'home:article',
  // Caps are required for this next controller
  '/world' => 'HelloWorld:index',
  // Or we can use snake_case
  '/json' => 'hello_world:json',
  // We can call an extension explicitly...
  '/test.json' => 'hello_world:test',
  // ... or use $this->respond_with in the controller
  '/test2' => 'hello_world:test2',
);
