<?php
require "Parsedown.php";
$Parsedown = new Parsedown();

// Get the dir and all the md files 
$dir = __DIR__ . "/writings";
$files = glob("$dir/*.md");

// Build the array list of articles 
$writings = [];
foreach ($files as $file) {
    $slug = basename($file, ".md");
    // Get the date of creation
    $writings[$slug] = [
        "path" => $file,
        "time" => filemtime($file)
    ];
}

// Sorth the articles from newest to oldest for display
uasort($writings, fn($a, $b) => $b["time"] <=> $a["time"]);

$slug = $_GET["id"] ?? array_key_first($writings);

$content = "";
if (isset($writings[$slug])) {
    $content = file_get_contents($writings[$slug]["path"]);
}
else {
    $content = "File not found";
}
?>

<?php include "header.php" ?>
<div id="frag-container">
  <aside id="frag-left-col">
    <ul>
    <?php foreach($writings as $s => $a): ?>
      <li> 
        <a href="?id=<?= $s ?>" class="<?= $s==$slug?'active':'' ?>">
          <?= ucfirst($s) ?>
        <br>
        <small><?= date("F j, Y", $a["time"]) ?></small>
        </a> 
      </li> 
  <?php endforeach; ?>
    </ul>
  </aside>

  <div class="frag-center-col">
    <?= $Parsedown->text($content) ?>
  </div>
</div>
<?php include "footer.php" ?>
