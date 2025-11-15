<?php 
$PAGE = 2;
// Hardcode for now as example, dynamically generate eventually
$projects = ["Void" => "Written in C, Text editor of the future... today!",
    "Triple Triad" => "Written in JS/PHP, The card game from FFVIII",
    "Algorithmic Trading System" => "Written in Python, End-to-end trading platform with trend modeling and automation.",
    "Latent" => "Written in C#, A skeleton ERP software.",
    "MemoryVoid" => "Written in html/css/PHP, This very website project.",
    "Cache" => "Written in C#, A Kanban style productivity manager designed to store projects, ideas, plans outside of the brain."
];

$key = $_GET['project'] ?? null;

if ($key && isset($projects[$key])) {
    $content = $projects[$key];
}
else {
    $content = $projects["Void"];
}

?>

<?php include "header.php" ?>
<main id="page-content">
<div id="logs-container">
    <div class="left-col" id="logs-left-col">
        <ul> 
            <?php foreach($projects as $project => $desc): ?>
                <li>
                    <a href="?project=<?= urlencode($project) ?>"
                        class="<?= ($key === $project) ? 'active' : '' ?>">
                        <?= htmlspecialchars($project) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="center-col" id="logs-center-col">
        <p>Current Projects</p>
        <p><?= htmlspecialchars($content) ?></p>
    </div>
</div>
</main>
<?php include "footer.php" ?>
