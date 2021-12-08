<?php

require_once('vendor/autoload.php');
require_once('conf/db.php');
use \Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use wish\models\Liste;
use wish\models\Item;
use wish\controleur\ControleurItem as ControleurItem;
use wish\controleur\ControleurListe as ControleurListe;
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
        // $l = Liste::find($args['id']);
        $c = new ControleurListe;
        return $c->getAllItems($rq, $rs, $args['id']);
    }
);
$app->get(
    '/liste/{id}/items',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("liste numero: " . $args['id'].'<br>');
        $l = Liste::find($args['id']);

        foreach ($l->items as $value) {
            echo($value->nom."<br>");
        }
    }
);

$app->get(
    '/item/{id}',
    function ($rq, $rs, $args) {
        return ControleurItem::getItem($rq,$rs,$args['id']);
    }
);
$app->run();



