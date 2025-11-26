<?php
require "../db.php";

// Test markdown for memoryvoid project (this website)
$description = <<<MD
# Cache 

## Written in C#(backend), Avalonia UI(frontend), SQL 

A Kanban syle productivity manager designed to lighten the load on your brain 
by keeping track of what you are doing across multiple projects, ideas, plans.
![Screenshot](../media/cache/screenshot1.png){ width=500 }

Includes:
- Draggable tasks & columns
- Editable titles, descriptions, and colours
- Tagging system for quick searching

Lets you context switch your brain into multiple tasks at speed with little 
overhead.

MD;

// If I want to use json for media in the md instead of inserting it above
    //Could add same for videos or embed games 
$media = json_encode([
    ["type" => "image", "src" => "../media/cache/screenshot1.png", "alt" => "UI screenshot"]
]);

$statement = $projects_db->prepare("INSERT OR IGNORE INTO projects (name, slug, description, media) VALUES (?, ?, ?, ?)");
$statement->execute([
    "Cache",
    "cache",
    $description,
    $media
]);

echo "Cache was successfully added";
?>
