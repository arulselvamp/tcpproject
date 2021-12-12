<?php
include '../vendor/autoload.php';

$app = new \Slim\App();
//slim application routes
$app->get('/', function ($request, $response, $args) { 
 $response->write("Welcome: This is Slim Tutorial Guide");
 return $response;
});
$app->get('/friends', function ($request, $response, $args) {
 $response->write("Hello Friends!");
 return $response;
});
$app->run();