<?php

require_once('vendor/autoload.php');
use \Psr\Http\Message\ServerRequestInterface as Request;
use Illuminate\Database\Capsule\Manager as DB;

$db = new DB();
$tab = parse_ini_file('conf/db.config.ini');
$db->addConnection([
    'driver'    => $tab['driver'],
    'host'      => $tab['host'],
    'database'  => $tab['database'],
    'username'  => $tab['username'],
    'password'  => $tab['password'],
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);
$db->setAsglobal();
$db->bootEloquent();
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
$app->run();



