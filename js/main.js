/* main.js — Minimal SPA router using the History API
 *
 * Steps in this file (top -> bottom):
 * 1) Views — small view functions that return HTML (and optional mount hooks)
 * 2) Routes — map of path -> view metadata (title, view function)
 * 3) Utils — path normalization helpers
 * 4) Router core — render(), navigate(), popstate handling
 * 5) Link capture — intercept internal <a> clicks and call navigate()
 * 6) Bootstrap — init on DOMContentLoaded
 *
 * Notes:
 * - The router prefers a container with id="app". If missing it falls back to #center-col
 * - For debugging you can use window.__router.navigate('/writings') from the console
 * - Keep the views pure. If a view needs JS after being mounted, attach a `.mount()` function
 */


// ---------------------------
// Step 1 — VIEWS
// Small, pure render functions. Keep markup simple while you learn.
// Each view returns an HTML string. Optionally add a .mount() function.
// ---------------------------

function Home() {
    return `
      <section id="blurb">
        <h2>Hi, I'm <span class="neon-green">emVee.</span></h2>
          <p>
            Welcome to the <span class="neon-cyan">Memory Void</span> — a space
            where my projects, interests and fragmented thoughts float through
            the digital ether.
            <br><br>
            I'm currently studying computer science, majoring in Cyber Security,
            Data Science, and Software Development.
          </p>
    </section>
    `;
}

function Writings() {
    return `
      <section>
        <h2>Writings</h2>
          <p>
            These are some thoughts ive had
          </p>
    </section>
    `;
}

function Projects() {
    return `
      <section>
        <h2>Projects</h2>
          <p>
            These are some projects I project
          </p>
    </section>
    `;
}

function About() {
    return `
      <section>
        <h2>About</h2>
          <p>
            This is about me and stuff
          </p>
    </section>
    `;
}

function NotFound() {
    return `
      <section>
        <h2>NotFound</h2>
          <p>
          </p>
    </section>
    `;
}


//--------------
// Step 2 - ROUTE TABLE
// A plain map of path -> { render, title }
// Normalize paths (no trailing slash except root)
//--------------

const ROUTES = {
    '/': { render: Home, title: "Memory Void - Home"},
    "/writings": { render: Writings, title: "Memory Void - writings"},
    "/projects": { render: Projects, title: "Memory Void - projects"},
    "/about": { render: About, title: "Memory Void - about"},
};

//--------------
// Step 3 - UTILITIES
// NormalizePath, find container, safe innterHTML setting
//--------------

// Essentially extracting out the path
function normalizePath(path) {
    // If you try route to a path that doesn't exist, send to home
    if (!path) 
        return '/';

    // If passed a full URL object or a string, extract out the path name
    try { 
        const url = new URL(path, window.location.origin);
        // Keep the query if passed?
        path = url.pathname + url.search; 
    }
    catch (err) {
        // not a full URL - leave path as-is 
        console.log("ERROR: Could not parse URL, URL incomplete");
    }

    // Add a forward slash if one not provided? werid, it should be 
    if (!path.startsWith('/')) 
        path = '/' + path;

    if (path.length > 1 && path.endsWith('/')) 
        path = path.slice(0, -1);

    // You should now have the name of the path isolated.
    return path;
}

function getAppContainer() {
    return document.getElementById("main-container" || "center-col");
}

function safeSetHTML(container, html) {
    // basic safety: ensure container exists
    if (!container) 
        return ;
    else 
        container.innerHTML = html 
}

//-----------------------
// Step 4 - ROUTER CORE 
// render(), navigate(), handle popstate, setActiveLink
//-----------------------

function render(path) {
    const normalized = normalizePath(path || window.location.pathname);
    const route = ROUTES[normalized];
    const container = getAppContainer();

    if (route && route.render) {
        safeSetHTML(container, route.render());
        document.title = route.title || document.title;
    }
    else {
        safeSetHTML(container, NotFound())
        document.title = "404 - Memory Void";
    }

    // Call mount hook if view proivdes it (e.g., view.mount)
    try {
        const viewFn = route && route.render;

        if (viewFn && typeof viewFn.mount === "function") 
            viewFn.mount();
    }
    catch (err) {
        // Silently ignore mount errors while learning??????
        console.log("View mount error", err);
    }
    
    // Hightlight the active nav link for UX/accessibility
    setActiveLink(normalized);
    // Reset scroll to top for new page
    window.scrollTo(0, 0);
}

function navigate(to, { replace = false } = {}) {
    const target = normalizePath(to);
    if (target === normalizePath(window.location.pathname)) {
        // Same path - optionally do nothing or re-render
        render(target);
        return;
    }

    if (replace) 
        window.history.replaceState({}, '', target);
    else 
        window.history.pushState({}, '', target);

    render(target);
}

function setActiveLink(path) {
    // Find nav links that look like internal routes 
    const navLinks = document.querySelectorAll(".navbar a[href]");
    navLinks.forEach((a) => {
        try {
            const url = new URL(a.href, window.location.origin);
            const linkPath = normalizePath(url.pathname + url.search);

            if (linkPath === path) 
                a.setAttribute("aria-current", "page");
            else 
                a.removeAttribute("aria-current");
        }
        catch (err) {
            a.removeAttribute("aria-current");
        }
    });
}

// Handle back and forwards buttons 
window.addEventListener("popstate", (ev) => {
    render(window.location.pathname);
});

// Expose a tiny API for debugging/testing 
window.__router = {
    navigate,
    render,
    getCurrentPath: () => normalizePath(window.location.pathname),
};

// ----------------------------
// Step 5 - LINK INTERCEPTION
// Single delegated listener that captures internal link clicks 
// and routes them via history API. It ignores external links, 
// modified clicks, and links with target="_blank".
// ----------------------------

document.addEventListener("click", (ev) => {
    if (ev.defaultPrevented) 
        return;
    //only left-click
    if (ev.button !== 0) 
        return;

    // ignore modifier keys (open in new tab/window)
    if (ev.metaKey || ev.ctrlKey || ev.shiftKey || ev.altKey) 
        return;

    const anchor = ev.target.closest('a');
    if (!anchor) 
        return;
    
    const href = anchor.getAttribute("href");
    if (!href) 
        return;

    // allow explicit opt-out
    if (anchor.dataset && anchor.dataset.noSpa !== undefined) 
        return;

    // allow anchors that are hashes for on-page anchors 
    if (href.startsWith('#')) 
        return;

    // build absolute URL and only handle same-origin links 
    let url;
    try {
        url = new URL(anchor.href, window.location.href);
    }
    catch (err) {
        return; // malformed irl, let the browser handle???
    }

    if (url.origin !== window.location.origin) 
        return;

    if (anchor.target && anchor.target !== "_self")
        return;

    // Finally - intercept and rtoute
    ev.preventDefault();
    navigate(url.pathname + url.search);
});

// ---------------------------
// Step 6 — BOOTSTRAP
// Run initial render after DOM ready
// ---------------------------

document.addEventListener("DOMContentLoaded", () => {

    // If your server serves index.html for every route, this will render
    // the correct view on initial load. If not, and you're testing locally
    // with file:// or a server that 404s, make sure to access the root first.
    render(window.location.pathname);
});







