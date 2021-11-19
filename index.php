<?php

require_once('/bd/connectionFactory.php');
require_once('requetes.php');

$db = new connectionFactory();
$conn = $db->makeConnection();

$req = new requetes();

$req::listItems($conn);

