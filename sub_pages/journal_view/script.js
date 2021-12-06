let comps = document.querySelectorAll(".comp_item");
for (let i = 0; i < comps.length; i++) {
    comps[i].setAttribute("title", comps[i].innerHTML);
    if (comps[i].innerHTML.length > 5) {
        comps[i].innerHTML = comps[i].innerHTML.slice(0, 5) + " ";
    }
}