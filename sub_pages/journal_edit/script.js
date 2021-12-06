document.querySelector('#add_btn').addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form").classList.toggle("hidden");
});

document.querySelector('#add_btn_delete').addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_delete").classList.toggle("hidden");
});

let arr = document.querySelectorAll(".compOptions");
for (let i = 0; i < arr.length; i++){
    arr[i].setAttribute("title", arr[i].innerHTML);
    if (arr[i].innerHTML.length > 70) {
        arr[i].innerHTML = arr[i].innerHTML.slice(0, 80) + "...";
    }
}

document.querySelector("#chooseComp").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector(".compSelect").classList.toggle("hidden");
});

let comps = document.querySelectorAll(".comp_item");
for (let i = 0; i < comps.length; i++) {
    comps[i].setAttribute("title", comps[i].innerHTML);
    if (comps[i].innerHTML.length > 5) {
        comps[i].innerHTML = comps[i].innerHTML.slice(0, 5) + " ";
    }
}