<?php 
// Creates a sqlite object connected to my projects database
$database = new PDO("sqlite:" . __DIR__ . "/data/memoryvoid.db");

$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
