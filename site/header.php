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

        <h3 class="contact-info">
          <a id="github" href="<?= getSetting("contact_github") ?>" target="_blank"
            aria-label="GitHub" rel="noopener">
            <svg class="icon" viewBox="0 0 24 24">
              <path d="M12 .5C5.65.5.5 5.65.5 12a11.5 11.5 0 0 0 7.87 10.93c.58.1.79-.25.79-.56v-2.02c-3.2.7-3.87-1.54-3.87-1.54-.53-1.34-1.3-1.7-1.3-1.7-1.06-.73.08-.72.08-.72 1.17.08 1.79 1.2 1.79 1.2 1.04 1.78 2.73 1.27 3.4.97.1-.76.41-1.27.74-1.56-2.56-.29-5.25-1.28-5.25-5.69 0-1.26.45-2.3 1.2-3.1-.12-.3-.52-1.5.11-3.13 0 0 .97-.31 3.18 1.18a11.1 11.1 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.64 1.63.24 2.83.12 3.13.75.8 1.2 1.84 1.2 3.1 0 4.42-2.7 5.4-5.27 5.68.42.36.8 1.08.8 2.18v3.24c0 .31.21.67.8.56A11.5 11.5 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5z"/> 
            </svg>
          </a>
          |
          <a class="contact-info" href="mailto:<?= getSetting("contact_email") ?>"
            >
            <svg class="icon" viewBox="0 0 24 24">
              <path d="M2 4h20v16H2V4zm10 7L4 6v12h16V6l-8 5z"/>
            </svg>
          </a>
        </h3>

      </header>
