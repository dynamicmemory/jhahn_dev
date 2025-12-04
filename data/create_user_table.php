<?php
require("../database.php");

$database->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT, 
    role TEXT NOT NULL DEFAULT 'viewer' 
    );");

echo "Users Table has been created";

/* INSERT INTO users (username, password, role); */

?>
