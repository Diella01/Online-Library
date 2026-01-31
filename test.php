<?php

require_once "config/Database.php";

$db = new Database();
$conn = $db->connect();

echo "Lidhja me databazën u krye me sukses!";
