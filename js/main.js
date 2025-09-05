import { home } from './pages/home.js';
import { writings } from './pages/writings.js';
import { memories } from './pages/memories.js';
import { projects } from './pages/projects.js';
import { about } from './pages/about.js';

document.addEventListener("DOMContentLoaded", () => {

    // Load the header dynamically
    fetch("partials/header.html")
        .then(res => res.text())
        .then(html => {
            document.getElementById("site-header").innerHTML = html;
        });

    // Website routes for hash routing
    const routes = {
        "/": home, 
        "/writings": writings,
        "/memories": memories,
        "/projects": projects,
        "/about": about 
    };

    // Loads the content for the specific route 
    function loadRoute() {
        const path = location.hash.replace('#', '') || '/';
        const page = routes[path] || home;
        document.getElementById("main-container").innerHTML = page();


        // Handles the population of the articles
        if (path === "/writings") {
            writingsRoute()
        }
        else if (path === "/projects") {
            // add projects route 
        }
    }

    window.addEventListener("hashchange", loadRoute);
    loadRoute();
});

// Handles the writings route 
function writingsRoute() {
    import("./pages/writings.js").then(module => {
        // backend code
        fetch("/api/fragments.php")
            .then(res => res.json())
            .then(fragments => module.populateFragments(fragments));
    });
}
