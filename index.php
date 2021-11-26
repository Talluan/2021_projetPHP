<?php

require_once('vendor/autoload.php');
require_once('Requetes.php');

use \wish\bd\connectionFactory;

use \Psr\Http\Message\ServerRequestInterface as Request;



$app = new \Slim\App;

$db = new connectionFactory();
$conn = $db->makeConnection();

$req = new requetes();

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
    function ($rq, $rs, $args) use ($conn) {
        $req=new requetes();
        $rs->getBody()->write("item numero: " . $args['id'].'<br>'.$req::getItem($conn, $args['id']));
    }
);
$app->run();



