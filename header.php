<?php 
// Add any php objects or code I need here.
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="/css/reset.css">
        <link rel="stylesheet" type="text/css" href="/css/main.css">
        <link rel="stylesheet" type="text/css" href="/css/about.css">
        <link rel="stylesheet" type="text/css" href="/css/logs.css">
        <link rel="stylesheet" type="text/css" href="/css/projects.css">
        <link rel="stylesheet" type="text/css" href="/css/contact.css">
        <script defer src="js/main.js"></script>
        <script src="js/char.js"></script>
    </head>
<?php
if (!isset($PAGE)) $PAGE = 0;
?>
    <body data-page="<?php echo intval($PAGE); ?>">
        <header>
            <nav>
                <div id="left-nav">
                    <h1 class="nav-text">
                        <a href="/index.php" data-page="0">{MEMORY VOID}</a>
                    </h1>
                </div>
                <div id="right-nav">
                    <h1 class="nav-text">
                        <!-- Turning off articles for the moment, devlog instead-->
                        <!--<a href="/thoughts.php">(&Thoughts)</a> -->
                        <a href="/log.php" data-page="1">(&Log)</a> 
                        <a href="/projects.php" data-page="2">(&Projects)</a> 
                        <a href="/contact.php" data-page="3">(&Contact)</a> 
                    </h1>
                </div>
            </nav>
        </header>
