<?php 
// Add any php objects or code I need here.
require_once __DIR__ . "/../website_data/database.php";
require_once __DIR__ . "/includes/functions.php";

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <!-- <link rel="stylesheet" type="text/css" href="/css/reset.css"> -->
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/about.css">
    <!--<link rel="stylesheet" type="text/css" href="/css/logs.css"> -->
    <link rel="stylesheet" type="text/css" href="/css/projects.css">
    <link rel="stylesheet" type="text/css" href="/css/contact.css">
    <script defer src="js/main.js"></script>
    <script src="js/word.js"></script>
  </head>
  <body> 
    <header>
      <h1 class="nav-text"> <a href="/index.php">{HAHN CODED}</a> </h1>
      <nav>

        <div id="left-nav">

        </div>

        <div id="right-nav">
            <!-- <a href="/log.php">(&Log)</a>   -->
            <a href="/projects.php">(&Projects)</a> 
            <!-- <a href="/contact.php">(&Contact)</a>  -->
            <a id="github" href="<?= getSetting("contact_github") ?>" target="_blank"
              rel="noopener">github</a> | 
            <a id="email" href="mailto:<?= getSetting("contact_email") ?>" target="_blank"
              rel="noopener"><?= getSetting("contact_email") ?></a>
        </div>

      </nav>
    </header>
