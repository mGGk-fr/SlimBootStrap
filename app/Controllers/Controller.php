<?php

namespace App\Controllers;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class Controller{
    private $container;

    //Affecting container
    public function __construct($container){
        $this->container = $container;
    }

    //Render method
    public function render(ResponseInterface $response, $file, array $params = []){
        $this->container->view->render($response, $file, $params);
    }

    //Executing query and get results
    public function getQueryResult(string $query, array $args = []){
        $req = $this->container->pdo->prepare($query);
        $req->execute($args);
        return $req->fetchAll();
    }

    //Execute query
    public function executeQuery(string $query, array $args = []){
        $req = $this->container->pdo->prepare($query);
        return $req->execute($args);

    }

    //Redirect client
    public function redirect(ResponseInterface $response, string $name){
        return $response->withStatus(302)->withHeader('Location', $this->router->pathFor($name));
    }

    public function flash($type, $message){
        if(!isset($_SESSION["flash"])){
            $_SESSION["flash"] = [];
        }
        return $_SESSION["flash"][$type] = $message;
    }

    //Bypass container shit
    public function __get($name){
        return $this->container->get($name);
    }
}