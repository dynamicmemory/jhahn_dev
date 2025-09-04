export function writings() {
  return `
    <div id="frag-container">
      <section id="frag-left-col">
        <h1 class="frag-title">Fragments</h1>
        <ul id="frag-list"></ul>
      </section>
      <section id="frag-center-col">
        <h1 id="frag-center-title" class="frag-title">Fragment title</h1>
        <p id="frag-body">Here are my writings in neon text...</p>
      </section>
    </div>
  `;
}

// Function to populate list from an array 
export function populateFragments(fragments) {
    const fragList = document.getElementById("frag-list");
    fragments.forEach(frag => {
        const li = document.createElement("li");
        li.textContent = frag.title;
        li.dataset.body = frag.body;
        li.addEventListener("click", () => {
            document.getElementById("frag-center-title").textContent = frag.title;
            document.getElementById("frag-body").textContent = frag.body;
        });
        fragList.appendChild(li);
    });
}
