<?php 
// Initializes all admin pages with shared information required

// Sets the auth to access db pages 
require_once "auth.php";

// Gets the database object
require_once "../../website_data/database.php";

// Gets the security and misc helpers
require_once "../includes/csrf.php";
require_once "../includes/helpers.php";
csrf_verify();
?>
