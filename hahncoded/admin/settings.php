<?php
require_once "auth.php";
require "../../website_data/database.php";
require_once "../includes/csrf.php";
csrf_verify();

// Sending a new/updating a record in the settings table
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $key = $_POST["key"];
    $value = $_POST["value"];
    $section = $_POST["section"];
    $tag = $_POST["tag"];

    // Create a new setting 
    if ($_POST["mode"] === "create") {
        $statement = $database->prepare(
            "INSERT INTO settings (key, value, section, tag) 
            VALUES (:key, :value, :section, :tag)");
        try {
            $statement->execute([
                ":key" => $key,
                ":value" => $value,
                ":section" => $section,
                ":tag" => $tag,
            ]);
            echo "<p>Successfully added $key to the settings table</p>";
        } 
        catch (PDOException $e) {
            echo "<p>$key already exists in table, $e</p>";
        } 
    }

    // Update an exisiting setting 
    elseif ($_POST["mode"] === "update") {
        $id = $_POST["id"];
        $statement = $database->prepare("UPDATE settings 
            SET key=:key, value=:value, section=:section, tag=:tag WHERE id=:id");
        try {
            $statement->execute([
                ":key" => $key,
                ":value" => $value,
                ":section" => $section,
                ":tag" => $tag,
                ":id" => $id
            ]);
            echo "<p>Successfully updated $key</p>";
        }
        catch (PDOException $e) {
            echo "<p>Failed to update $key, $e</p>";
        }
    }

    // Delete a record
    elseif ($_POST["mode"] === "delete") {
        $id = (int)$_POST["id"];
        $statement = $database->prepare("DELETE from settings WHERE id = :id");
        $statement->execute([":id" => $id]);
        echo "<p>Successfully deleted $key</p>";
    }
}

$selected_setting = null;
$isNew = false;

if (isset($_GET["action"]) && $_GET["action"] === "new") {
    $isNew = true;
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $statement = $database->prepare("SELECT * FROM settings WHERE id = :id");
    $statement->execute([":id" => $id]);
    $selected_setting = $statement->fetch();
}

// Gets all the settings to display in the sidebar
$settings = $database->query("SELECT id, key FROM settings ORDER BY id ASC");

?>
<!-- Make a new header for the admin panel so i can load css scripts and the like-->

<?php include "index.php" ?>
<h1>Settings Editor</h1>
    <!-- Main container-->
    <div class="main-container">

        <!-- Side panel-->
        <div class="side-panel">
            <a href="?action=new">Add new setting</a>
            <ul> 
                <?php while($s = $settings->fetch()): ?>
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
        <?php if ($selected_setting || $isNew): ?>
    
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
                    <label>Section (Area of the site)</label>
                    <input name="section" value="<?=htmlspecialchars($selected_setting["section"])?>">
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

        <?php else: ?>
            <p>Select a setting from the left to edit.</p>
        <?php endif; ?>

        </div>
    </div>
</html>
<!-- -->
