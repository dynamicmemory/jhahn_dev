<?php
require_once "auth.php";
require "../../website_data/database.php";
require_once "../includes/csrf.php";

csrf_verify();

// Sending a new/updating a record in the settings table
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $key = $_POST["key"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $tag = $_POST["tag"];

    // Create a new setting 
    if ($_POST["mode"] === "create") {
        $statement = $database->prepare(
            "INSERT OR IGNORE INTO settings (key, value, type, tag) VALUES (?, ?, ?, ?)");
        $statement->bindValue(1, $key, SQLITE3_TEXT);
        $statement->bindValue(2, $value, SQLITE3_TEXT);
        $statement->bindValue(3, $type, SQLITE3_TEXT);
        $statement->bindValue(4, $tag, SQLITE3_TEXT);
        $statement->execute();
        echo "<p>Successfully added $key to the settings table</p>";
    }

    // Update an exisiting setting 
    elseif ($_POST["mode"] === "update") {
        $id = $_POST["id"];
        $statement = $database->prepare("UPDATE settings 
            SET key = ?, value = ?, type = ?, tag = ? WHERE id = ?");
        $statement->bindValue(1, $key, SQLITE3_TEXT);
        $statement->bindValue(2, $value, SQLITE3_TEXT);
        $statement->bindValue(3, $type, SQLITE3_TEXT);
        $statement->bindValue(4, $tag, SQLITE3_TEXT);
        $statement->bindValue(5, $id, SQLITE3_INTEGER);
        $statement->execute();
        echo "<p>Successfully updated $key</p>";
    }

    elseif ($_POST["mode"] === "delete") {
        $id = (int)$_POST["id"];
        $statement = $database->prepare("DELETE from settings WHERE id = ?");
        $statement->bindValue(1, $id, SQLITE3_INTEGER);
        $statement->execute();
        echo "<p>Successfully deleted $key</p>";
    }
}

$selected_setting = null;
$isNew = false;

if (isset($_GET["action"]) && $_GET["action"] === "new") {
    $isNew = true;
}

if (isset($_GET["id"])) {
    $statement = $database->prepare("SELECT * FROM settings WHERE id = ?");
    $statement->bindValue(1, $_GET["id"], SQLITE3_INTEGER);
    $statement->execute();
    $selected_setting = $statement->fetch(PDO::FETCH_ASSOC);
}

// Gets all the settings to display in the sidebar
$settings = $database->query("SELECT id, key FROM settings ORDER BY id ASC");

?>
<!-- Make a new header for the admin panel so i can load css scripts and the like-->
<html> 
    <head> 
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>

    <h1>Settings</h1> 
    <a href="index.php">Dashboard</a>

    <!-- Main container-->
    <div class="main-container">


        <!-- Side panel-->
        <div class="side-panel">
            <a href="?action=new">Add new setting</a>
            <ul> 
                <?php while($s = $settings->fetch(PDO::FETCH_ASSOC)): ?>
                <li>
                    <a href="?id=<?=$s["id"]?>">
                        <?=htmlspecialchars($s["key"])?> 
                    </a>   
                </li>
                <?php endwhile ?>
            </ul>

        </div>
        <!-- Center panel-->
        <div class="center-panel">

            <form method="POST">
                <fieldset> 
                    <input type="hidden" name="csrf_token" value="<?=csrf_token() ?>">
                    <input type="hidden" name="mode" value="<?=$isNew ? 'create' : 'update'?>">
                    <?php if (!$isNew): ?>
                    <input type="hidden" name="id" value="<?=$selected_setting["id"]?>">
                    <?php endif; ?>
                    <label>Key</label>
                    <input name="key" value="<?=htmlspecialchars($selected_setting["key"])?>">
                    <label>Value</label>
                    <textarea name="value" rows="20"><?=htmlspecialchars($selected_setting["value"])?></textarea>
                    <label>Type</label>
                    <input name="type" value="<?=htmlspecialchars($selected_setting["type"])?>">
                    <label>Tag</label>
                    <input name="tag" value="<?=htmlspecialchars($selected_setting["tag"])?>">

                    <button type="submit">SUMBIT</button>
                </fieldset>
            </form>
                    <?php if (!$isNew): ?>
                    <form method="POST" style="display:inline;">
                    <input type="hidden" name="mode" value="delete">
                    <input type="hidden" name="id" value="<?= $selected_setting["id"] ?>">
                    <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                    <button type="submit" onclick="return confirm
                        ('Are you sure you want to delete this project');"
                        style="color:red; text-decoration: none;"> 
                        Delete this project
                        </button>
                    <?php endif; ?>
        </div>
    </div>
</html>
<!-- -->
