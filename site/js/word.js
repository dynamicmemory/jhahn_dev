/*
 Changed from '' to  ' ' as a shortterm solution to the performance problem of 
 trying to refresh every single letter. Will return to this problem later when 
 the site is more fully develop
    */

document.addEventListener("DOMContentLoaded", () => {

    function wrapCharInSpan(id) {
        const e = document.getElementById(id);
        if (!e) return; 

        // Split up every char and place it in an individual span
        e.innerHTML = e.textContent
            .split('')
            .map(c => c === '' ? '' :`<span class="word">${c}</span>`)
            .join('');

        // Randomise the length of the duration
        e.querySelectorAll('.word').forEach(c => {
            // c.style.animationDuration = `${10 + Math.random()*10}s`;
            c.style.animationDuration = `${10 + Math.random()*10}s`;
            c.style.animationDelay = `${Math.random()*5}s`;
        });
    }

    // For each id in the list, call the wrap span function and apply the span
    // TODO: Dynamically load the ids from the page.
    const ids = ["about-h1", "about-p1", "about-p2", "about-p3", "title"]
    ids.forEach(id => wrapCharInSpan(id));
});



