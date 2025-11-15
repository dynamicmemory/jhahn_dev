<?php 
$PAGE = 1;
// Get the json data 
$database = file_get_contents("articles/database.json");
// Reverse the db so newest is first
$articles = array_reverse(json_decode($database, true));

// Check if/which article was clicked and set it to a varaible to expose it in html
$clickedArticle = null;
if (isset($_GET['post'])) {
    $articlePath = $_GET['post'];

    // Protects against someone injecting an address to a folder we don't want to show
    if (strpos($articlePath, "articles/") === 0 && file_exists($articlePath)) {
        $content = file_get_contents($articlePath);

        foreach ($articles as $article) {
            if ($article['content'] === $articlePath) {
                $clickedArticle = $article;
                break;
            }
        }
    }
    else 
        $content = "Invalid Article.";
}
// Load the latest article if none is selected (on page load)
else {
    if (!empty($articles)) {
        $clickedArticle = $articles[0];
        $content = file_get_contents($clickedArticle['content']);
    }
}
?>

<?php include "header.php" ?>
<main id="page-content">
<div id="logs-container">
    <div class="left-col" id="logs-left-col">
        <ul>
        <!--For every article in the db, loop through and display the name and date-->
        <?php  
            if ($articles) {
                foreach($articles as $article) {
                    echo "<li><a href='?post=" . urlencode($article['content']) . 
                        "'>" . htmlspecialchars($article['title']) . "</a></li>";
                    echo "<small>" . htmlspecialchars($article['date']) . "</small>";
                    echo "<br><hr>";
                }
            }
            else {
                echo "<p>No thoughts were found</p>";
            }
        ?>
        </ul>
    </div>

    <div class="center-col" id="logs-center-col">
        <div id="logs-content">
            <h1 id="logs-title">
            <?php echo htmlspecialchars($clickedArticle['title']);?>
            </h1>
            <p id="logs-date">Published - 
            <?php echo htmlspecialchars($clickedArticle['date']);?>
            </p>
            <p id="logs-body"><?php echo $content;?>
            </p>
        </div>
    </div>
</div>
</main>
<?php include "footer.php" ?>
