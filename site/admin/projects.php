<?php
require_once "init.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Works for now, but really don't like this design
    $errors = enforceFields($_POST, ["name", "slug", "description", "content"]);
    if (!empty($errors)) {
        $_SESSION["form_errors"] = $errors;
        $_SESSION["form_data"] = $_POST;

     // Check if the form is for adding a new project 
    if (isset($_GET["action"]) && $_GET["action"] === "new") {
        $isNew = true;
    }
        header("Location: projects.php" . ($isNew ? "?action=new" : "?id=$_GET[id]"));
        /* exit; */
    }

    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $last_updated = $_POST['last_updated'];
    $section = $_POST['section'];
    $rank = $_POST['rank'];
    $languages = $_POST['languages'];
    $description= $_POST['description'];
    $content = $_POST['content'];
    $publish = isset($_POST['publish']) ? 1 : 0;

    // Code for adding a new project
    if ($_POST["mode"] === "create") {
        $statement = $database->prepare(
            "INSERT INTO projects (name, slug, last_updated, section, rank, languages, description, content, publish) 
            VALUES (:name, :slug, :last_updated, :section, :rank, :languages, :description, :content, :publish)"
        );
        // Protect against inserting existing slug 
        try {
            $statement->execute([
                ":name" => $name,
                ":slug" => $slug,
                ":last_updated" => $last_updated,
                ":section" => $section,
                ":rank" => $rank,
                ":languages" => $languages,
                ":description" => $description,
                ":content" => $content,
                ":publish" => $publish
            ]);
        } catch (PDOException $e) {
            die($e);
            /* echo "<p>$e</p>";  */
            /* die("Slug already exists"); */
        }
        echo "<p>Added project: $name</p>";
    }

    // Code for updating a project 
    elseif ($_POST["mode"] === "update") {
        $id = $_POST["id"];
        $statement = $database->prepare(
            "UPDATE projects 
            SET name = :name, slug = :slug, last_updated = :last_updated,
                       section = :section, rank = :rank,
                       languages = :languages, description = :description, 
                       content = :content, publish = :publish WHERE id = :id"
        );

        $statement->execute([
            ":id" => $id,
            ":name" => $name,
            ":slug" => $slug,
            ":last_updated" => date('Y-m-d'),
            ":section" => $section,
            ":rank" => $rank,
            ":languages" => $languages,
            ":description" => $description,
            ":content" => $content,
            ":publish" => $publish
        ]);

        echo "<p>Updated!</p>";
    }

    elseif ($_POST["mode"] === "delete") {
        $id = (int)$_POST["id"];
        $statement = $database->prepare("DELETE FROM projects WHERE id = :id");
        $statement->execute([":id" => $id]);
        echo "<p>Deleted project $name</p>";
    }
}

$selected_project = null;
$isNew = false;

if (isset($_GET["action"]) && $_GET["action"] === "new") {
    $isNew = true;
}

if (isset($_GET['id'])) {
    $statement = $database->prepare("SELECT * FROM projects WHERE id = :id");
    $statement->execute([":id" => $_GET["id"]]);
    $selected_project = $statement->fetch();
}

$projects = $database->query("SELECT id, name FROM projects ORDER BY id ASC");

?>
<?php include "header.php" ?>
<!-- Main container -->
<main> 

  <!-- Left col -->
  <div class="side-panel"> 

    <h3>Projects</h3>
    <ul> 
      <?php while ($p = $projects->fetch()) : ?>
        <li>
          <a href="?id=<?= $p["id"] ?>"><?= htmlspecialchars($p["name"]) ?></a>
        </li>
      <?php endwhile ?> 
    </ul>
    <h3>Other Options</h3>
      <a href="?action=new">Add New Project</a>
  </div>

  <!-- Center col-->
  <div class="center-panel">
    <h1>Projects DB editor</h1>
    <?php if ($selected_project || $isNew): ?>
      <div class="form-heading">
        <?php if (!$isNew): ?>
      
          <h3>Editing: <?= htmlspecialchars($selected_project["name"]) ?></h3> 
          <form method="POST">
            <input type="hidden" name="mode" value="delete">
            <input type="hidden" name="id" value="<?= $selected_project["id"] ?>">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <button class="delete-btn" type="submit" onclick="return 
              confirm('Are you sure you want to delete this project');">
              Delete this project
            </button>
          </form>

        <?php else: ?>
          <h3>Adding New Project</h3>
        <?php endif; ?>
      </div>

      <form method="POST"> 
        <fieldset> 
          <input type="hidden" name="csrf_token" value="<?=csrf_token() ?>">
          <input type="hidden" name="mode" value="<?= $isNew ? "create" : "update" ?>">
          <?php if (!$isNew): ?>
            <input type="hidden" name="id" value="<?= $selected_project["id"]?>">
          <?php endif; ?>

          <label>Name: </label><br>
          <input name="name" value="<?= htmlspecialchars($selected_project["name"]) ?>">
          <br><br>

          <label>URL-Slug: </label><br>
          <input name="slug" value="<?= htmlspecialchars($selected_project["slug"]) ?>">
          <br><br>

          <input type="hidden" name="last_updated" value="<?= htmlspecialchars($selected_project["last_updated"]) ?>">

          <label>Section ("General", "Systems"): </label><br>
          <input name="section" value="<?= htmlspecialchars($selected_project["section"]) ?>">
          <br><br>

          <label>Rank (order): </label><br>
          <input name="rank" value="<?= htmlspecialchars($selected_project["rank"]) ?>">
          <br><br>

          <label>Languages: </label><br>
          <input name="languages" value="<?= htmlspecialchars($selected_project["languages"]) ?>">
          <br><br>

          <label>Description: </label><br>
          <input name="description" value="<?= htmlspecialchars($selected_project["description"]) ?>">
          <br><br>

          <label>Content (Markdown body): </label><br>
          <textarea name="content" rows="30"><?= htmlspecialchars($selected_project["content"]) ?></textarea>
          <br><br>

          <label class="checkbox-label">Publish: 
                <input type="checkbox" name="publish" style="align-content: left;" value="1" 
                    <?= !empty($selected_project["publish"]) ? "checked" : "" ?>>
          </label>
          <br><br>

          <!-- ADD JSON MEDIA OBJECTS IF I CHOOSE TO IMPLEMENT HERE-->
          <button type="submit"><?= $isNew ? "Add Project" : "Save Changes" ?></button>
        </fieldset> 
      </form>



    <?php else: ?>
      <p>Select a project from the left to edit.</>
    <?php endif; ?>
  </div>
</main>
<?php include "footer.php" ?>
