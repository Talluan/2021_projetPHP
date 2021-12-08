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
         <body> <h1> Index </h1>
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
$app->run();



