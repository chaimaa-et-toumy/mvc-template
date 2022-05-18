<?php

// autoload
require_once __DIR__ . '/../vendor/autoload.php';
//var_dump(dirname(__DIR__)); // return folder racin ex c/xampp/htdoc...


use app\core\Application;
use app\controllers\SiteController;

$app = new Application(dirname(__DIR__));

$app->router->get('/', [new SiteController(), 'home']);
$app->router->get('/contact', [new SiteController(), 'contact']);
$app->router->post('/contact', [new SiteController(), 'handleContact']);


$app->run();
