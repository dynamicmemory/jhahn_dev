<?php
require "../database.php";

function create_table($database, $table_name, $schema) {
    $database->exec("CREATE TABLE IF NOT EXISTS $table_name $schema");
    echo "$table_name table created.";
}

function remove_table($database, $table_name) {
    $database->exec("DROP TABLE $table_name;");
    echo "$table_name table dropped.";
}

function rename_table($database, $table_name, $new_name) {
    $database->exec("ALTER TABLE $table_name RENAME TO $new_name;");
    echo "$table_name, renamed to $new_name";
}

$table_name = "users"; 
$schema = "(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT, 
    role TEXT NOT NULL DEFAULT 'viewer' 
    );";

$table_name = "projects"; 
$schema = "(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    media TEXT 
    );";

$table_name = "settings";
$schema = "(
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    key TEXT UNIQUE NOT NULL,
    value TEXT NOT NULL,
    section TEXT DEFAULT 'setting',
    tag TEXT DEFAULT 'general'
);";

$database->exec("ALTER TABLE settings RENAME COLUMN section TO type;");

/* remove_table($database, $table_name); */
/* create_table($database, $table_name, $schema); */

?>




