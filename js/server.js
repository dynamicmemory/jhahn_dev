const http = require("http");
const fs = require("fs");
const path = require("path");
const url = require("url");

async function getFragments() {
    const dir = path.join(__dirname, "articles");
    const files = fs.readdirSync(dir).filter(f => f.endsWith(".txt"));
    return files.map(file => {
        const body = fs.readFileSync(path.join(dir, file), "utf8");
        const title = file.replace(".txt", "").replace(/-/g, " ");
        return { title, body };
    });
}

const server = http.createServer(async (req, res) => {
    const parsedUrl = url.parse(req.url);

    if (parsedUrl.pathname === "/api/fragments") {
        try {
            const fragments = await getFragments();
            res.writeHead(200, { "Content-Type": "application/json"});
            res.end(JSON.stringify(fragments));
        }
        catch (err) {
            res.writeHead(500);
            res.end("Error reading fragments");
        }
        return; 
    }

    //server static files 
    let filePath = path.join(__dirname, parsedUrl.pathname === "/" ? "index.html" : parsedUrl.pathname);
    fs.readFile(filePath, (err, data) => {
        if (err) {
            res.writeHead(404);
            res.end("Not found");
        } else {
            const ext = path.extname(filePath);
            const mimeTypes = { ".html":"text/html", ".js":"text/javascript", ".css":"text/css" };
            res.writeHead(200, { "Content-Type": mimeTypes[ext] || "text/plain" });
            res.end(data);
        }
    });
});

server.listen(3000, () => console.log("Server running at http://localhost:3000"));
