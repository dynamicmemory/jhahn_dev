<?php
require_once "auth.php";
require "../../website_data/database.php";
require_once "../includes/csrf.php";
csrf_verify();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description= $_POST['description'];
    $content = $_POST['content'];

    // Code for adding a new project
    if ($_POST["mode"] === "create") {
        $statement = $database->prepare(
            "INSERT INTO projects (name, slug, description, content) 
            VALUES (:name, :slug, :description, :content)"
        );
        // Protect against inserting existing slug 
        try {
            $statement->execute([
                ":name" => $name,
                ":slug" => $slug,
                ":description" => $description,
                ":content" => $content
            ]);
        } catch (PDOException $e) {
            die("Slug already exists");
        }
        echo "<p>Added project: $name</p>";
    }

    // Code for updating a project 
    elseif ($_POST["mode"] === "update") {
        $id = $_POST["id"];
        $statement = $database->prepare(
            "UPDATE projects 
            SET name = :name, slug = :slug, description = :description, 
                content = :content WHERE id = :id"
        );

        $statement->execute([
            ":id" => $id,
            ":name" => $name,
            ":slug" => $slug,
            ":description" => $description,
            ":content" => $content
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

<!-- <div><a href="index.php">Admin Dashboard</a></div> -->

<!-- Main container -->
<div class="main-container"> 


    <!-- Left col -->
    <div style="min-width: 200px;"> 
        <h3>Projects</h3>
        <a href="?action=new">Add New Project</a>
        <ul> 
            <?php while ($p = $projects->fetch()) : ?>
            <li>
                <a href="?id=<?= $p["id"] ?>"> 
                    <?= htmlspecialchars($p["name"]) ?> 
                </a>
            </li>
            <?php endwhile ?> 
        </ul>
    </div>

    <!-- Center col-->
    <h1>Projects DB editor</h1>
    <div style="flex: 1;">
        <?php  if ($selected_project || $isNew): ?>
            <?php if (!$isNew): ?>
                <h3>Editing: <?= htmlspecialchars($selected_project["name"]) ?></h3> 
            <?php else: ?>
                <h3>Adding New Project</h3>
            <?php endif; ?>

            <form method="POST"> 
                <fieldset> 
                    <input type="hidden" name="csrf_token" value="<?=csrf_token() ?>">
                    <input type="hidden" name="mode" value="<?= $isNew ? "create" : "update" ?>">
                    <?php if (!$isNew): ?>
                    <input type="hidden" name="id" value="<?= $selected_project["id"]?>">
                    <?php endif; ?>

                    <label>Name: </label><br>
                    <input name="name" value="<?= htmlspecialchars($selected_project["name"]) ?>" style="width: 100%"><br><br>

                    <label>URL-Slug: </label><br>
                    <input name="slug" value="<?= htmlspecialchars($selected_project["slug"]) ?>" style="width: 100%"><br><br>

                    <label>Description: </label><br>
                    <input name="description" value="<?= htmlspecialchars($selected_project["description"]) ?>" style="width: 100%"><br><br>

                    <label>Content (Markdown body): </label><br>
                    <textarea name="content" rows="30" style="width: 100%;"><?= htmlspecialchars($selected_project["content"]) ?></textarea>
                    <br><br>

                    <!-- ADD JSON MEDIA OBJECTS IF I CHOOSE TO IMPLEMENT HERE-->
                    <button type="submit">
                        <?= $isNew ? "Add Project" : "Save Changes" ?>
                    </button>
                </fieldset> 
            </form>

            <?php if (!$isNew): ?>
            <!-- <p style="margin-top:1rem; float: right;"> -->

                <form method="POST" style="display:inline;">
                <input type="hidden" name="mode" value="delete">
                <input type="hidden" name="id" value="<?= $selected_project["id"] ?>">
                <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
                <button type="submit" onclick="return confirm ('Are you sure you want to delete this project');"
                        style="color:red; text-decoration: none;">Delete this project</button>
                </form>
            <!-- </p> -->
            <?php endif; ?>

        <?php else: ?>
            <p>Select a project from the left to edit.</>
        <?php endif; ?>
    </div>
</div>
<?php include "footer.php" ?>
