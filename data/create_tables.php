<?php
require "../database.php";

$projects_db->exec("CREATE TABLE IF NOT EXISTS projects_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    media TEXT 
    )");

echo "Projects table created.";

$projects_db->exec("INSERT INTO projects_new (name, slug, description, content, media)
SELECT 
name,
slug,
description,
description,
media 
FROM projects;
");

echo "Data copied into projects_new.<br>";

$projects_db->exec("DROP TABLE projects;");
echo "Old projects table dropped.<br>";

$projects_db->exec("ALTER TABLE projects_new RENAME TO projects;");
echo "Projects table renamed.<br>";

echo "Migration worked.<br>";


?>
