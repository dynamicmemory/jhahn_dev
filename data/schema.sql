CREATE TABLE IF NOT EXISTS projects (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pname TEXT NOT NULL, 
    slug TEXT UNIQUE NOT NULL,
    pdescription TEXT,
    pcontent TEXT,
    pmedia TEXT
);
