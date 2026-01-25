<?php 
session_start();

// Locks the admin section from anyone not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

// Used for finer grain control amoung registered users
function requireRole($role) {
    if (!isset($_SESSION["role"]) || $_SESSION["role"] !== $role) {
        echo "Access denied.";
        exit;
    } 
}

?>
