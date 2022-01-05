<?php
require_once('vendor/autoload.php');
require_once('conf/db.php');
session_start();
use \Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;
use wish\controleur\ControleurConnexion;
use wish\models\Liste;
use wish\models\Item;
use wish\vues\Vue;
use wish\controleur\ControleurItem as ControleurItem;
use wish\controleur\ControleurListe as ControleurListe;

$configuration = [
    'settings' => [
    'displayErrorDetails' => true,],
    'imgPath' => 'img/',
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$app->get(
    '/',
    function ($rq, $rs, $args) {
        $content = "";
        $html = new Vue($content,'WishList',$rq);
        return $html->getHtml();
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
    '/Meslistes',
    function ($rq, $rs, $args) {
        $c = new ControleurListe;
        return $c->getAllMyListes($rq, $rs, $args);
    }
);

$app->get(
    '/item/{id}',
    function ($rq, $rs, $args) {
        return ControleurItem::getItem($rq,$rs,$args);
    }
);

$app->get(
    '/creerliste',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->creationListe($rq, $rs, $args);
    }
);

$app->get(
    '/deco',
    function ($rq, $rs, $args) {
        return ControleurConnexion::seDeconnecter($rq, $rs,$args);
    }
);

$app->get(
    '/connexion',
    function ($rq, $rs, $args) {
        return ControleurConnexion::afficherConnexion($rq, $rs,$args);
    }
);

$app->get(
    '/mylist/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurListe;
        return $c->getAllItems($rq, $rs, $args);
    }
);

$app->post(
    '/connexion/{type}',
    function ($rq, $rs, $args) {
        return ControleurConnexion::orienter($rq, $rs,$args);
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
        return $c->ajouterItem($rq, $rs,$args);
    }
);
$app->run();



