<?php 
// Hardcode for now as example, dynamically generate eventually
$projects = ["Void" => "Written in C, Text editor of the future... today!",
    "Triple Triad" => "Written in JS/PHP, The card game from FFVIII",
    "Algorithmic Trading System" => "Written in Python, End-to-end trading platform with trend modeling and automation.",
    "Latent" => "Written in C#, A skeleton ERP software.",
    "MemoryVoid" => "Written in html/css/PHP, This very website project.",
    "Promag" => "Written in Undecided, An upcoming project still in concept phase."
];

$key = $_GET['project'] ?? null;

if ($key && isset($projects[$key])) {
    $content = $projects[$key];
}
else {
    $content = $projects[0];
}

?>

<?php include "header.php" ?>
<div class="main-container" id="logs-container">
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
<?php include "footer.php" ?>
