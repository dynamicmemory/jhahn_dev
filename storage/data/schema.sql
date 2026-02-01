CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT, 
    role TEXT NOT NULL DEFAULT "viewer" 
);


CREATE TABLE IF NOT EXISTS projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    last_updated TEXT NOT NULL DEFAULT (date('now')),
    section TEXT NOT NULL DEFAULT 'General',
    rank INTEGER NOT NULL DEFAULT 1,
    languages TEXT,
    description TEXT NOT NULL,
    content TEXT NOT NULL,
    publish INTEGER DEFAULT 0 
);


CREATE TABLE IF NOT EXISTS settings (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    key TEXT NOT NULL,
    value TEXT NOT NULL,
    type TEXT DEFAULT "settings",
    group TEXT DEFAULT "general"
);


CREATE TABLE login_attempts (
    ip TEXT PRIMARY KEY,
    attempts INTEGER NOT NULL,
    last_attempt INTEGER NOT NULL
);
