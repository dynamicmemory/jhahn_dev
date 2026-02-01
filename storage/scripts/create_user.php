<?php
// Roles = superadmin, admin, viewer
require("../database.php");

// Example for future me 
$username = "superuser";
$password = "password1";
$role = "superadmin";

/* remove_user($database, $username); */
/* add_user($database, $username, $password, $role); */

function add_user($database, $username, $password, $role) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $statement = $database->prepare("INSERT INTO users (username, password, role)
        VALUES (:u, :p, :r)");

    $statement->bindValue(":u", $username);
    $statement->bindValue(":p", $hash);
    $statement->bindValue(":r", $role);

    $statement->execute();

    echo "User created";
}

function remove_user($database, $username) {
    $statement = $database->prepare("DELETE FROM users WHERE username = :u");
    $statement->bindValue(":u", $username);
    $statement->execute();

    echo "User '{$username}' deleted.";
}
?>
