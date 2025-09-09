<?php
require "Parsedown.php";
$Parsedown = new Parsedown();

$dir = __DIR__ . "/writings";
$files = glob("$dir/*.md");

// Build the array list of articles 
$writings = [];
foreach ($files as $file) {
    $slug = basename($file, ".md");
    $writings[$slug] = $file;
}

$slug = $_GET["id"] ?? array_key_first($writings);

$content = "";
if (isset($writings[$slug])) {
    $content = file_get_contents($writings[$slug]);
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
      <a href="?id=<?= $s ?>" class="<?= $s==$slug?'active':'' ?>"><?= ucfirst($s) ?></a>
      
      </li> 
  <?php endforeach; ?>
    </ul>
  </aside>

  <div class="frag-center-col">
    <?= $Parsedown->text($content) ?>
  </div>
</div>
<?php include "footer.php" ?>
