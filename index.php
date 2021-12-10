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
        $html = <<<END
         <!DOCTYPE html> <html>
         <title> WishList </title>
         <link rel="icon" href="img/favicon.ico" />
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" >
         <body background="E.jpg"> <h1> Index </h1>
         <button type="button" class="btn btn-primary">test</button>
         <div class="content">
         </div>
        </body><html>
END;
        $rs->getBody()->write($html);
    }
);
$app->get(
    '/listes',
    function ($rq, $rs, $args) {
        $rs->getBody()->write("printage des liste".'<br>');
        $c = new ControleurListe();
        return $c->getAllListes($rq, $rs);
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

$app->get(
    '/creerliste',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->creerListe($rq, $rs);
    }
);
$app->run();



