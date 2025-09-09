document.addEventListener("DOMContentLoaded", () => {

    const menuButton = document.getElementById("menu-toggle");
    const sidebar = document.getElementById("frag-left-col");

    menuButton.addEventListener("click", () => {
        sidebar.classList.toggle("hidden");
    });
});
