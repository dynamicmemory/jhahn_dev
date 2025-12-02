<?php
// TODO: Change how the db is named EVERYWHERE including the actual db 
// TODO: Change description key to content or md EVERYWHERE
$db = new SQLite3(__DIR__ . '/../data/memoryvoid.db');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $slug = $_POST['slug'];
    $description= $_POST['description'];
    $content = $_POST['content'];

    // Code for adding a new project
    if ($_POST["mode"] === "create") {
        $statement = $db->prepare(
            "INSERT OR IGNORE INTO projects (name, slug, description, content) VALUES (?, ?, ?, ?)");
        $statement->bindValue(1, $name, SQLITE3_TEXT);
        $statement->bindValue(2, $slug, SQLITE3_TEXT);
        $statement->bindValue(3, $description, SQLITE3_TEXT);
        $statement->bindValue(4, $content, SQLITE3_TEXT);
        $statement->execute();

        echo "<p>Created!</p>";
    }

    // Code for updating a project 
    elseif ($_POST["mode"] === "update") {
        $id = $_POST['id'];
        $statement = $db->prepare(
            "UPDATE projects SET name = ?, slug = ?, description = ?, content = ? WHERE id = ?");
        $statement->bindValue(1, $name, SQLITE3_TEXT);
        $statement->bindValue(2, $slug, SQLITE3_TEXT);
        $statement->bindValue(3, $description, SQLITE3_TEXT);
        $statement->bindValue(4, $content, SQLITE3_TEXT);
        $statement->bindValue(5, $id, SQLITE3_INTEGER);
        $statement->execute();
        echo "<p>Updated!</p>";
    }
}

$selected_project = null;
$isNew = false;

if (isset($_GET["action"]) && $_GET["action"] === "new") {
    $isNew = true;
}

if (isset($_GET["delete"])) {
    $id = (int)$_GET["delete"];

    $statement = $db->prepare("DELETE FROM projects WHERE id = ?");
    $statement->bindValue(1, $id, SQLITE3_INTEGER);
    $statement->execute();
    echo "<p>Deleted project $id</p>";
}

if (isset($_GET['id'])) {
    $statement = $db->prepare("SELECT * FROM projects WHERE id = ?");
    $statement->bindValue(1, $_GET['id'], SQLITE3_INTEGER);
    $result = $statement->execute();
    $selected_project = $result->fetchArray(SQLITE3_ASSOC);
}

$projects = $db->query("SELECT id, name FROM projects ORDER BY id ASC");

?>



<h1>Projects DB editor</h1>
<!-- Main container -->
<div style="display: flex; gap: 2rem; max-width: 1000px;"> 

    <!-- Left col -->
    <div style="min-width: 200px;"> 
        <h3>Projects</h3>
        <a href="?action=new">Add New Project</a>
        <ul> 
            <?php while ($p = $projects->fetchArray(SQLITE3_ASSOC)) : ?>
            <li>
                <a href="?id=<?= $p["id"] ?>"> 
                    <?= htmlspecialchars($p["name"]) ?> 
                </a>
            </li>
            <?php endwhile ?> 
        </ul>
    </div>

    <!-- Center col-->
    <div style="flex: 1;">
        <?php  if ($selected_project || $isNew): ?>
        <?php if (!$isNew): ?>
        <h3>Editing: <?= htmlspecialchars($selected_project["name"]) ?></h3> 
        <?php else: ?>
        <h3>Adding New Project</h3>
        <?php endif; ?>

        <form method="POST"> 
            <fieldset> 
                <input type="hidden" name="mode" value="<?= $isNew ? "create" : "update" ?>">
                <?php if (!$isNew): ?>
                <input type="hidden" name="id" value="<?= $selected_project["id"]?>">
                <?php endif; ?>

                <label>Name: </label><br>
                <input name="name" value="<?= htmlspecialchars($selected_project["name"]) ?>"
                    style="width: 100%"><br><br>

                <label>URL-Slug: </label><br>
                <input name="slug" value="<?= htmlspecialchars($selected_project["slug"]) ?>"
                    style="width: 100%"><br><br>

                <label>Description: </label><br>
                <input name="description" value="<?= htmlspecialchars($selected_project["description"]) ?>"
                    style="width: 100%"><br><br>

                <label>Content (Markdown body): </label><br>
                <textarea name="content" rows="30" style="width: 100%;"><?= htmlspecialchars($selected_project["content"]) ?></textarea>
                <br><br>

                <!-- ADD JSON MEDIA OBJECTS IF I CHOOSE TO IMPLEMENT HERE-->
                <button type="submit">
                    <?= $isNew ? "Add Project" : "Save Changes" ?>
                </button>

                <?php if (!$isNew): ?>
                <p style="margin-top:1rem; float: right;">
                    <button> 
                        <a href="?delete=<?= $selected_project["id"] ?>"
                            onclick="return confirm('Are you sure you want to delete this project');"
                            style="color:red; text-decoration: none;"> 
                            Delete this project
                        </a>
                    </button>
                </p>
                <?php endif; ?>

            </fieldset> 
        </form>

        <?php else: ?>
        <p>Select a project from the left to edit.</>
        <?php endif; ?>
    </div>
</div>
