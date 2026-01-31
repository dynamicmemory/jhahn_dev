<?php
require_once "init.php";

// Sending a new/updating a record in the settings table
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Works for now, but really don't like this design
    $errors = enforceFields($_POST, ["key", "value", "type", "tag"]);
    if (!empty($errors)) {
        $_SESSION["form_errors"] = $errors;
        $_SESSION["form_data"] = $_POST;

        // Check if the form was for ading a new setting
        if (isset($_GET["action"]) && $_GET["action"] === "new") {
            $isNew = true;
        }
        header("Location: settings.php" . ($isNew ? "?action=new" : "?id=$_POST[id]"));
        /* exit; */
    }

    $key = $_POST["key"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $tag = $_POST["tag"];

    // Create a new setting 
    if ($_POST["mode"] === "create") {
        $statement = $database->prepare(
            "INSERT INTO settings (key, value, type, tag) 
            VALUES (:key, :value, :type, :tag)");
        try {
            $statement->execute([
                ":key" => $key,
                ":value" => $value,
                ":type" => $type,
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
            SET key=:key, value=:value, type=:type, tag=:tag WHERE id=:id");
        try {
            $statement->execute([
                ":key" => $key,
                ":value" => $value,
                ":type" => $type,
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
$settings = $database->query("SELECT id, key, tag FROM settings ORDER BY tag ASC");

?>

<?php include "header.php" ?>

<!-- Main container-->
<main>
  <!-- Side panel-->
  <div class="side-panel">
    <h3>Settings/Content</h3>
      <ul> 
        <?php while($s = $settings->fetch()): ?>
          <li>
            <a href="?id=<?=$s["id"]?>">
              <?=htmlspecialchars($s["key"])?>
            </a>   
          </li>
        <?php endwhile ?>
      </ul>
    <h3>Other Options</h3>
    <a href="?action=new">Add new setting</a>

  </div>
        
  <!-- Center panel-->
  <div class="center-panel">
    <h1>Settings Editor</h1>
    <?php if ($selected_setting || $isNew): ?>
      <div class="form-heading">
        <?php if (!$isNew): ?>
          <h3>Editing: <?= htmlspecialchars($selected_setting["key"])?></h3>
          <form method="POST"> 
            <input type="hidden" name="mode" value="delete">
            <input type="hidden" name="id" value="<?= $selected_setting["id"] ?>">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <button class="delete-btn" type="submit" onclick="return confirm
              ('Are you sure you want to delete this project');"> 
              Delete this setting 
            </button>
          </form>
        <?php else: ?>
          <h3>Adding a New setting</h3>
        <?php endif ?>
      </div>
    
      <form method="POST">
        <fieldset> 
          <input type="hidden" name="csrf_token" value="<?=csrf_token() ?>">
          <input type="hidden" name="mode" value="<?=$isNew ? 'create' : 'update'?>">
          <?php if (!$isNew): ?>
            <input type="hidden" name="id" value="<?=$selected_setting["id"]?>">
          <?php endif; ?>
          <label>Key:</label>
          <br>
          <input name="key" value="<?=htmlspecialchars($selected_setting["key"])?>">
          <br><br>
          <label>Value:</label>
          <br>
          <textarea name="value" rows="20"><?=htmlspecialchars($selected_setting["value"])?></textarea>
          <br><br>
          <label>Type (settings/content):</label>
          <br>
          <input name="type" value="<?=htmlspecialchars($selected_setting["type"])?>">
          <br><br>
          <label>Tag (Area of the website):</label>
          <br>
          <input name="tag" value="<?=htmlspecialchars($selected_setting["tag"])?>">
          <br><br>

          <button type="submit">SUMBIT</button>
        </fieldset>
      </form>

    <?php else: ?>
      <p>Select a setting from the left to edit.</p>
    <?php endif; ?>

  </div>
</main>
<?php include "footer.php" ?>
<!-- -->
