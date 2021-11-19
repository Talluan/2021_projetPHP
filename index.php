<?php

require_once('vendor/autoload.php');
require_once('Requetes.php');

use \wish\bd\connectionFactory;

$db = new connectionFactory();
$conn = $db->makeConnection();

$req = new requetes();

$req::listItems($conn);
echo('<br>');
$req::getItem($conn, 2);

