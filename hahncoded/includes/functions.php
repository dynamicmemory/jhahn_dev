<?php 
require "../website_data/database.php";

function getSetting($key, $default = null) {
    global $database;

    $statement = $database->prepare("SELECT value FROM settings WHERE key = :key");
    $statement->execute([":key" => $key]);

    $value = $statement->fetchColumn();

    return $value !== false ? $value : $default;
}
?>
