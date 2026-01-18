<?php 
require "../website_data/database.php";
// Markdown Parser (https://github.com/erusev/parsedown/blob/master/Parsedown.php)
// Maybe ill build my own md parser but for now ill use this.
require __DIR__ . "/vendor/Parsedown.php";
require __DIR__ . "/vendor/ParsedownExtra.php";
$Parsedown = new ParsedownExtra();

// Set project and content to null to start for the on load case
$project = null;
$content = null;

// Get all the projects in the db
$projects_list = $database
    ->query("SELECT name, slug, section , rank, languages, description FROM projects")
    ->fetchAll();

// Get the slug from the db for the url if a project has been clicked
$slug = $_GET['project'] ?? null;

// Load a project using the url slug
if ($slug !== null) {
    $statement = $database->prepare("SELECT * FROM projects WHERE slug = :slug");
    $statement->execute([":slug" => $slug]);
    $project = $statement->fetch();
    // On failure
    if (!$project) {
        /* http_reponse_code(404); */
        die("Project $slug not found");
    } 

    // Get 'last updated' and inject it into the md file
    $md = $project["content"];
    $formatDate = date('d-m-Y', strtotime($project["last_updated"]));
    $md = str_replace("{{last_updated}}", htmlspecialchars($formatDate), $md);
    $content = $Parsedown->text($md);
}

// Sorting the side bar
// TODO: Turn this into a table and let the datatbase drive this, until then 
//       use this array to control and edit the project section headings and 
//       match them to the projects section in each of their tables to generate 
//       them in the right place with the right order 
$sections = ["Systems", "Data & Learning", "Networked Apps", "Web Design"];
// Creating a new list of projects grouped together by their sections
$projectBySection = [];
foreach($projects_list as $p) {
    $projectBySection[$p["section"]][] = $p;
}
// Sorting the projects within the sections by their ranks
foreach($projectBySection as &$projects) {
    usort($projects, fn($a, $b) => $a["rank"] <=> $b["rank"]);
}
unset($projects);

?>

<?php include "header.php" ?>
<div id="projects-container">
  <div class="left-col" id="projects-left-col">
    <ul> 
      <?php foreach($sections as $sectionName): ?>
        <?php if(empty($projectsBySection[$sectionName])): ?>
          <p class="section-header">
            <?= htmlspecialchars($sectionName) ?>
          </p>

          <?php foreach($projectBySection[$sectionName] as $item): ?>
            <li>
              <a href="?project=<?= urlencode($item['slug']) ?>"
                class="<?= ($item["slug"] === $project["slug"]) ? 'active' : '' ?>">
                <?= htmlspecialchars($item['name']) ?>
                <span class="proj-lang">- <?= htmlspecialchars($item['languages']) ?></span>
                <p class="proj-desc"><?= htmlspecialchars($item['description']) ?></p>
              </a>
            </li>
          <?php endforeach; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>


  <?php if ($project === null): ?>
    <div class="center-col" id="projects-center-col" style="background-color: #212121;">

      <div class="main-container" id="about-container">
        <div class="float" id="about-center-container">
          <h1 class="float" id="about-h1"><?= getSetting("about_title"); ?></h1>
          <p class="float" id="about-p1"><?= getsetting("about_p1"); ?></p>
          <p class="float" id="about-p2"><?= getSetting("about_p2"); ?></p>
          <p class="float" id="about-p3"><?= getSetting("about_p3"); ?></p>
        </div>
      </div>
    </div>

    <?php else: ?>
    <div class="center-col" id="projects-center-col">
      <!--  <h2><?= htmlspecialchars($project['name']) ?></h2> -->
      <?= $content?>

    </div>
  <?php endif; ?>
</div>
<?php include "footer.php" ?>
