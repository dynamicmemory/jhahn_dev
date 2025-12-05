CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT, 
    role TEXT NOT NULL DEFAULT "viewer" 
);


CREATE TABLE IF NOT EXISTS projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pname TEXT NOT NULL, 
    slug TEXT UNIQUE NOT NULL,
    pdescription TEXT,
    pcontent TEXT,
    pmedia TEXT
);
