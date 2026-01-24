<?php 
// Add any php objects or code I need here.
require_once __DIR__ . "/../website_data/database.php";
require_once __DIR__ . "/includes/functions.php";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/css/root.css">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/about.css">
    <script defer src="js/main.js"></script>
    <script src="js/word.js"></script>
  </head>

  <body> 
    <div class="page-container">
      <header class="header">

        <h1> 
          <a href="/index.php"><?= getSetting("header_website_title") ?></a> 
        </h1>

        <h3 class="contact-info">
          <a id="github" href="<?= getSetting("contact_github") ?>" target="_blank"
             rel="noopener">github
          </a>
          |
          <a class="contact-info" href="mailto:<?= getSetting("contact_email") ?>" target="_blank"
             rel="noopener">email
          </a>
        </h3>

      </header>
