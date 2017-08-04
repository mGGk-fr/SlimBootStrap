<?php

//Loading autoloader Composer
require '../vendor/autoload.php';

//Initializing App
session_start();

//Setting error mode for dev
$app = new \Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

//Loading container system
require('../app/container.php');

$container = $app->getContainer();

//Loading Middlewares
$app->add(new \App\Middlewares\FlashMiddleware($container->view->getEnvironment()));

//Loading routes
require('../app/routes.php');

//RUN !!!
$app->run();
