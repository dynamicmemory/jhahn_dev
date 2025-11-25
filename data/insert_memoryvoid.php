<?php
require "../db.php";

// Test markdown for memoryvoid project (this website)
$description = <<<MD
# MemoryVoid 

## Written in html/css/PHP/JS

This very website you are viewing this on.
![Screenshot](../media/memoryvoid/screenshot1.png)

Primarily build as a demo of how I handle core web-dev fundatmentals:
- Clean HTML/CSS for the layout 
- JS for simple dynamic behavior on the frontend
- PHP for backend logic and datavase access using SQL 

It also includes a basic but secure login system that lets you access my 
contact details using the correct provided credentials.

MD;

// If I want to use json for media in the md instead of inserting it above
    //Could add same for videos or embed games 
$media = json_encode([
    ["type" => "image", "src" => "../media/memoryvoid/screenshot1.png", "alt" => "Webstie screenshot"]
]);

$statement = $projects_db->prepare("INSERT OR IGNORE INTO projects (name, slug, description, media) VALUES (?, ?, ?, ?)");
$statement->execute([
    "MemoryVoid",
    "memoryvoid",
    $description,
    $media
]);

echo "Memoryvoid was successfully added";
?>
