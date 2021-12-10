<?php
session_start();
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
         <body>
         <div class="container"> <h1> Index </h1>
         <button type="button" class="btn btn-primary">test</button>
         </div>
        </body><html>
END;
        $rs->getBody()->write($html);
    }
);
$app->get(
    '/listes',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->getAllListes($rq, $rs, $args);
    }
);
$app->get(
    '/liste/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurListe;
        return $c->getAllItems($rq, $rs, $args);
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
        return $c->creationListe($rq, $rs, $args);
    }
);

$app->post(
    '/creerliste',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->creerListe($rq, $rs, $args);
    }
);
$app->post(
    '/ajouteritem',
    function ($rq, $rs, $args) {
        $c = new ControleurItem();
        return $c->ajouterItem($rq, $rs);
    }
);
$app->run();



