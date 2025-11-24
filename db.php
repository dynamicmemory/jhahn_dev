<?php 
// Creates a sqlite object connected to my projects database
$projects_db = new PDO("sqlite:" . __DIR__ . "/data/projects.db");

$projects_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
