<?php
require "Parsedown.php";
$Parsedown = new Parsedown();

$dir = __DIR__ . "/projects";
$files = glob("$dir/*.md");

// Build the array list of articles 
$projects = [];
foreach ($files as $file) {
    $slug = basename($file, ".md");
    $projects[$slug] = $file;
}

$slug = $_GET["id"] ?? array_key_first($projects);

$content = "";
if (isset($projects[$slug])) {
    $content = file_get_contents($projects[$slug]);
}
else {
    $content = "File not found";
}
?>

<?php include "header.php" ?>
<div id="frag-container">
  <aside id="frag-left-col">
    <ul>
    <?php foreach($projects as $s => $a): ?>
      <li> 
      <a href="?id=<?= $s ?>" class="<?= $s==$slug?'active':'' ?>">
          <?= ucfirst($s) ?></a>
      
      </li> 
  <?php endforeach; ?>
    </ul>
  </aside>

  <div class="frag-center-col">
    <?= $Parsedown->text($content) ?>
  </div>
</div>
<?php include "footer.php" ?>
