<?php 
session_start();
// Add any php objects or code I need here.
require_once __DIR__ . "/../storage/database.php";
require_once __DIR__ . "/includes/functions.php";

$maintenance = getSetting("maintenance_mode");
if ($maintenance && empty($_SESSION["user_id"])){
    include "maintenance.php";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="icon" href="media/jhahn_dev/logo-trans2.png">
    <link rel="stylesheet" type="text/css" href="/css/reset.css">
    <link rel="stylesheet" type="text/css" href="/css/root.css">
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <link rel="stylesheet" type="text/css" href="/css/about.css">
    <!-- <script src="js/word.js"></script> -->
    <!-- FOR SYNTAX HIGHLIGHTING IN THE MD CONTENT IF I EVER WANT IT-->
    <!-- <link rel="stylesheet" -->
    <!--   href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css"> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script> -->
    <!-- <script> -->
    <!--   hljs.highlightAll(); -->
    <!-- </script> -->
  </head>

  <body> 
    <div class="page-container">
      <header class="header">
        <!-- <img src="./media/jhahn_dev/logo-trans2.png", width="10"></img> -->

        <h1> 
          <a id="title" href="/index.php"><?= getSetting("header_website_title") ?></a> 
        </h1>

<!--        <img class="icon" src="./media/jhahn_dev/logo-trans.png"></img>
-->
<!--        <h4>Projects Writing</h4> 
-->

      </header>
