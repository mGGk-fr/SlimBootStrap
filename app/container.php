<?php
//Defining new container.
$container = $app->getContainer();

//Defining view engine
$container['view'] = function ($container) {

    $dir = dirname(__DIR__);

    $view = new \Slim\Views\Twig($dir.'/app/Views', [
        'cache' => false //$dir.'/tmp/cache'
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $container['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($container['router'], $basePath));

    return $view;
};

//Defining DB access
$container['pdo'] = function($db){
    //loading setting
    require '../app/config.inc.php';
    $pdo = new PDO("mysql:dbname=".$dbBase.";host:".$dbAddress, $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    return $pdo;
};

$container['trackerURL'] = function(){
    require'../app/config.inc.php';
    return $trackerBaseURL;
};