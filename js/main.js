document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById("main-container");
    const links = document.querySelectorAll(".nav-right a");

    // load page into main-containers
    async function loadPage(page) {
        try {
            const res = await fetch(`/pages/${page}.html`);
            if (!res.ok) throw new Error("Page not found");
            const html = await res.text();
            container.innerHTML = html;
        }
        catch (err) {
            container.innerHTML = `<h2>404</h2><p>Page not found</p>`;
            console.error(err);
        }
    }

    links.forEach(link => {
        link.addEventListener("click", e => {
            e.preventDefault();
            const page = link.getAttribute("id");
            history.pushState({ page }, "", `/${page}`);
            loadPage(page);
        });
    });

    window.addEventListener("popstate", e => {
        const page = e.state?.page || "home";
        loadPage(page);
    });

    loadPage("home");
});
