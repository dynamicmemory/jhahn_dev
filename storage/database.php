<?php 
// Creates a sqlite object connected to my projects database
$database = new PDO("sqlite:" . __DIR__ . "/data/portfolio.db");

$database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
?>
