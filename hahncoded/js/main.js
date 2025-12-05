// document.addEventListener("DOMContentLoaded", () => {
//
//     // Temp, remove this, dont want all pages fading in, just to test system
//     document.body.classList.add("fade-in");
//
//     // Get all the header links in the nav and attach a transition to them 
//     document.querySelectorAll(".nav-text a").forEach(link => {
//         link.addEventListener("click", attachTransition);
//     });
// });
//
// // Transitions between pages 
// function attachTransition(e) {
//     const link = this;
//     e.preventDefault();
//
//     document.body.classList.add("fade-out");
//
//     setTimeout(() => {
//         window.location = link;
//     }, 1);
// }
//
