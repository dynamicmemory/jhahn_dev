<?php 

require "./database.php";

// Markdown Parser (https://github.com/erusev/parsedown/blob/master/Parsedown.php)
// Maybe ill build my own md parser but for now ill use this.
require __DIR__ . "/vendor/Parsedown.php";
/* $Parsedown = new Parsedown(); */

require __DIR__ . "/vendor/ParsedownExtra.php";
$Parsedown = new ParsedownExtra();

// Get the extension (slug) from the url
$slug = $_GET['project'] ?? 'memoryvoid';

// Load a project using the url slug
$statement = $database->prepare("SELECT * FROM projects WHERE slug = ?");
$statement->execute([$slug]);
$project = $statement->fetch(PDO::FETCH_ASSOC);

// Failsafe inscase something failed
if (!$project) {
    $statement = $database->query("SELECT * FROM projects ORDER BY id ASC LIMIT 1");
    $project = $statement->fetch(PDO::FETCH_ASSOC);
    if (!$project) {
        die("No projects found, Add one with XYZ that I haven't built yet");
    } 
}

$list = $database->query(
    "SELECT name, slug FROM projects ORDER BY id ASC")->fetchALL(PDO::FETCH_ASSOC);

$content = $Parsedown->text($project['content']);

// TODO: Ill do media after if i can get name, slug and description in


?>

<?php include "header.php" ?>
<div id="projects-container">
    <div class="left-col" id="projects-left-col">
        <ul> 
            <?php foreach($list as $item): ?>
                <li>
                    <a href="?project=<?= urlencode($item['slug']) ?>"
                        class="<?= ($item === $project) ? 'active' : '' ?>">
                        <?= htmlspecialchars($item['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="center-col" id="projects-center-col">
      <!--  <h2><?= htmlspecialchars($project['name']) ?></h2> -->
      <?= $content?>
    </div>
</div>
<?php include "footer.php" ?>



