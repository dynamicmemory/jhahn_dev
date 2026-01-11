<?php 
require "../website_data/database.php";

// Markdown Parser (https://github.com/erusev/parsedown/blob/master/Parsedown.php)
// Maybe ill build my own md parser but for now ill use this.
require __DIR__ . "/vendor/Parsedown.php";
require __DIR__ . "/vendor/ParsedownExtra.php";
$Parsedown = new ParsedownExtra();

// Get the extension (slug) from the url
$slug = $_GET['project'] ?? 'memoryvoid';

// Load a project using the url slug
$statement = $database->prepare("SELECT * FROM projects WHERE slug = :slug");
$statement->execute([":slug" => $slug]);
$project = $statement->fetch();

// On failure
if (!$project) {
    /* http_reponse_code(404); */
    die("Project $slug not found");
} 

$list = $database
    ->query("SELECT name, slug, languages, description FROM projects ORDER BY id ASC")
    ->fetchAll();

// Get 'last updated' and inject it into the md file
$md = $project["content"];
$formatDate = date('d-m-Y', strtotime($project["last_updated"]));
$md = str_replace("{{last_updated}}", htmlspecialchars($formatDate), $md);
$content = $Parsedown->text($md);

// TODO: Ill do media after if i can get name, slug and description in

?>

<?php include "header.php" ?>
<div id="projects-container">
  <div class="left-col" id="projects-left-col">
    <ul> 
      <p style="font-weight: bold; font-size:1.75rem; color:purple">Systems Programming</p>
      <p style="font-weight: bold; font-size:1.75rem; color:purple">Data & Learning</p>
      <p style="font-weight: bold; font-size:1.75rem; color:purple">Networked Applications</p>
      <p style="font-weight: bold; font-size:1.75rem; color:purple">Web Platforms</p>
      <?php foreach($list as $item): ?>

        <li>
          <a href="?project=<?= urlencode($item['slug']) ?>"
             class="<?= ($item["slug"] === $project["slug"]) ? 'active' : '' ?>">
             <?= htmlspecialchars($item['name']) ?>
             <span class="proj-lang">- <?= htmlspecialchars($item['languages']) ?></span>
             <p class="proj-desc"><?= htmlspecialchars($item['description']) ?></p>

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
