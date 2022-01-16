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
use wish\controleur\ControleurMessage as ControleurMessage;

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

$app->post(
    '/liste/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurMessage();
        $c->creerMessage($rq,$rs,$args);
        $c = new ControleurListe;
        return $c->getAllItems($rq, $rs, $args);
    }
);

$app->get(
    '/liste/{idliste}/supprimeritem/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->supprimerItem($rq, $rs, $args);
    }
);

$app->post(
    '/liste/{idliste}/supprimeritem/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurListe;
        return $c->traiterItem($rq, $rs, $args);
    }
);

$app->get(
    '/meslistes',
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
        return $c->traiterItem($rq, $rs,$args);
    }
);
$app->get(
    '/ajouteritem',
    function ($rq, $rs, $args) {
        $c = new ControleurItem();
        return $c->ajouterItem($rq, $rs,$args);
    }
);

$app->post(
    '/ajouterDateExpiration',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->ajouterDateExpiration($rq, $rs,$args);
    }
);
$app->get(
    '/ajouterDateExpiration',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->ajouterDateExpiration($rq, $rs,$args);
    }
);

$app->get(
    '/item/{id}/reserver',
    function ($rq, $rs, $args) {
        $c = new ControleurItem;
        return $c->reserverItem($rq,$rs,$args);
    }
);

$app->get(
    '/item/{id}/annuler',
    function ($rq, $rs, $args) {
        $c = new ControleurItem;
        return $c->annulerReservation($rq,$rs,$args);
    }
);

$app->get(
    '/partageListe/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->partageListe($rq, $rs,$args);
    }
);

$app->get(
    '/modifierListe/{id}',
    function ($rq, $rs, $args) {
        $c = new ControleurListe();
        return $c->modifierListe($rq, $rs,$args);
    }
);

$app->run();




