// /js/main.js
(() => {
  const ANIM_DURATION = 600; // ms, matches CSS
  const STAGGER = 100; // ms between items

  const body = document.body;
  const currentIndex = () => parseInt(body.dataset.page || "0", 10);

  // elements that form the nav/order. Adjust selectors if yours differ
  const leftNav = document.querySelector("#left-nav");
  const rightNavLinks = Array.from(document.querySelectorAll("#right-nav a"));
  const pageContent = document.querySelector("#page-content");

  // Build a generic "visual order" array for exit/entry sequencing:
  function buildVisualOrder() {
    // Base order: left-nav first, then all right-nav links in DOM order, then page content
    return [leftNav, ...rightNavLinks, pageContent].filter(Boolean);
  }

  // Add click handlers to nav anchors
  document.querySelectorAll("nav a[data-page]").forEach(a => {
    a.addEventListener("click", (e) => {
      const targetPage = parseInt(a.dataset.page, 10);
      if (Number.isNaN(targetPage)) return; // fallback
      e.preventDefault();

      // if same page, maybe just no-op or bounce; we'll just do nothing
      if (targetPage === currentIndex()) {
        // optionally: brief pulse animation; for now exit
        return;
      }

      const dir = targetPage > currentIndex() ? "left" : "right";
      startExitAnimation(dir, () => {
        // after exit animation completes, navigate
        window.location.href = a.href;
      });
    });
  });

  // Exit animation: animate elements off-screen in visual order
  function startExitAnimation(dir, done) {
    const order = buildVisualOrder();
    order.forEach((el, i) => {
      if (!el) return;
      const delay = i * STAGGER;
      setTimeout(() => {
        el.classList.add(dir === "left" ? "fly-left" : "fly-right");
      }, delay);
    });

    // call done after full sequence
    const totalTime = (order.length - 1) * STAGGER + ANIM_DURATION;
    setTimeout(done, totalTime + 20);
  }

  // Entry animation: run on page load
  function startEntryAnimation() {
    const urlPage = parseInt(body.dataset.page || "0", 10);
    // entry direction is opposite of exit direction:
    // If we came from left -> we should enter from left (i.e., target < previous? can't detect previous here).
    // We'll implement simple rule: if history length > 1 we can try read document.referrer, but to simplify:
    // We'll animate entries based on last navigation direction stored in sessionStorage if available.

    const prev = parseInt(sessionStorage.getItem("prevPage") || "0", 10);
    const dir = urlPage > prev ? "right" : "left"; // if we moved forward, elements should enter from right
    // store current as prev for next navigation
    sessionStorage.setItem("prevPage", urlPage);

    const order = buildVisualOrder();

    // For entry we want the inverse choreography in most cases:
    // If elements exited left before, they should enter from right (so dir: 'right' -> use enter-from-right)
    order.forEach((el, i) => {
      if (!el) return;
      // hide immediately so entry anim is visible
      el.style.opacity = 0;
      const delay = i * STAGGER + 50;
      setTimeout(() => {
        el.style.opacity = ""; // let animation set opacity
        el.classList.add(dir === "right" ? "enter-from-right" : "enter-from-left");
      }, delay);
    });
  }

  // Run entry animations when DOM ready
  document.addEventListener("DOMContentLoaded", () => {
    // small safety: ensure pageContent exists
    if (!pageContent) return;
    startEntryAnimation();
  });
})();
