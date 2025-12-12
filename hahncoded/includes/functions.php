<?php 
require "../website_data/database.php";

function getSetting($key, $default = null) {
    global $database;

    $statement = $database->prepare("SELECT value FROM settings WHERE key = ?");
    $statement->bindValue(1, $key, SQLITE3_TEXT);
    $statement->execute();

    $value = $statement->fetchColumn();

    return $value !== false ? $value : $default;
}

?>
