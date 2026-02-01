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

function migrate_table($database, $fields, $new_table, $old_table) {
    $database->exec("INSERT INTO $new_table ($fields) SELECT $fields FROM $old_table");
    echo "$new_table, migrated from $old_table";
}

$table_name = "login_attempts";
$schema = "(
    ip TEXT PRIMARY KEY,
    attempts INTEGER NOT NULL,
    last_attempt INTEGER NOT NULL
);";

create_table($database, $table_name, $schema);


/* $table_name = "projects"; */
/* $schema = "( */
/*     id INTEGER PRIMARY KEY AUTOINCREMENT, */
/*     name TEXT NOT NULL, */
/*     slug TEXT NOT NULL UNIQUE, */
/*     last_updated TEXT NOT NULL DEFAULT (date('now')), */
/*     section TEXT NOT NULL DEFAULT 'General', */
/*     rank INTEGER NOT NULL DEFAULT 1, */
/*     languages TEXT, */
/*     description TEXT NOT NULL, */
/*     content TEXT NOT NULL, */
/*     publish INTEGER DEFAULT 0  */
/*     );"; */

/* $fields = "id, name, slug, last_updated, section, rank, languages, description, content"; */
/* $old_table = "old_projects"; */

// Atomic operation for mirgrating tables
/* $database->beginTransaction(); */
/* try { */
/*     rename_table($database, $table_name, $old_table);  */
/*     create_table($database, $table_name, $schema); */
/*     migrate_table($database, $fields, $table_name, $old_table); */
/*     remove_table($database, $old_table); */
/*     $database->commit(); */
/* } catch (Throwable $e) { */
/*     $database->rollBack(); */
/*     throw $e; */
/* } */


/* $table_name = "users";  */
/* $schema = "( */
/*     id INTEGER PRIMARY KEY AUTOINCREMENT, */
/*     username TEXT UNIQUE, */
/*     password TEXT,  */
/*     role TEXT NOT NULL DEFAULT 'viewer'  */
/*     );"; */

/* $table_name = "settings"; */
/* $schema = "( */
/*     id INTEGER PRIMARY KEY AUTOINCREMENT, */
/*     key TEXT UNIQUE NOT NULL, */
/*     value TEXT NOT NULL, */
/*     section TEXT DEFAULT 'setting', */
/*     tag TEXT DEFAULT 'general' */
/* );"; */


/* $database->exec("ALTER TABLE settings RENAME COLUMN section TO type;"); */
?>
