<?php 
// Hardcode for now as example, dynamically generate eventually
$current_projects = ["Void (C) - Text editor of the future",
                     "Triple Triad (html/css/js/php) - The card game from FFVIII,
                     currently prototyped in python, ready to transition to a web game.",
                     "Trading Pipeline (Python & SQLite) - End-to-End Trading platform with 
                     price and trend modeling as well as automated trading",
                     "Latent (C# & postgreSQL) - A skeleton piece of ERP software",
                     "Memory Void (html/css/php) - This website."];
?>

<?php include "header.php" ?>
<div id="project-container">
    <div id="center-container">
        <p>Current Projects</p>
        <ul> 
            <?php foreach($current_projects as $project): ?>
                <li>- <?= $project ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<?php include "footer.php" ?>
