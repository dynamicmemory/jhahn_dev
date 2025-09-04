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
    
    const routes = {
        "/": home, 
        "/writings": writings,
        "/memories": memories,
        "/projects": projects,
        "/about": about 
    };

    function loadRoute() {
        const path = location.hash.replace('#', '') || '/';
        const page = routes[path] || home;
        document.getElementById("main-container").innerHTML = page();
    

    // Handles the population of the articles
    if (path === "/writings") {
        import("./pages/writings.js").then(module => {
        // test code 
            const testFrag = [
                {title: "Why agi will never happen", body: "Sam fraud bank..altman"},
                {title: "Controversial opinion", body: "This is my controversial"},
                {title: "Title of tiel ", body: "peter tiel? or epter tiel?"},
                {title: "Musk a scammer?", body: "elon van ge lone"}
            ];
            module.populateFragments(testFrag);

        // backend code
        //     fetch("/api/fragments")
        //         .then(res => res.json())
        //         .then(fragments => module.populateFragments(fragments));
        });
    }
}
    window.addEventListener("hashchange", loadRoute);
    loadRoute();
});
