<?php

require_once('vendor/autoload.php');
require_once('conf/db.php');
use \Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use wish\models\Liste;

$app = new \Slim\App;

$app->get(
    '/',
    function ($rq, $rs, $args) {
        $rs->getBody()->write('<h1>Index MyWishList</h1>');
    }
);
$app->get(
    '/listes',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("printage des liste".'<br>');
        $l = Liste::all();
        var_dump($l);
    }
);
$app->get(
    '/liste/{id}',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("liste numero: " . $args['id'].'<br>');
        $l = Liste::find($args['id']);
        var_dump($l);
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
        $rs->getBody()->write("Bienvenue");
    }
);
$app->run();



