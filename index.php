<?php

require_once('vendor/autoload.php');
require_once('conf/db.php');
use \Psr\Http\Message\ServerRequestInterface as Request;


$app = new \Slim\App;


$app->get(
    '/listes',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("printage des liste".'<br>');
    }
);
$app->get(
    '/liste/{id}',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("liste numero: " . $args['id'].'<br>');
    }
);
$app->get(
    '/item/{id}',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("item numero: " . $args['id'].'<br>');
    }
);
$app->get(
    '/accueil',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("item numero: " .'<br>');
    }
);
$app->run();



