document.addEventListener("click", function(event){
    if (event.target.checked && event.target.localName == "input" && event.target.type != "submit") {
        event.target.parentElement.classList.add("turq");
    }
    if (!event.target.checked && event.target.localName == "input" && event.target.type != "submit") {
        event.target.parentElement.classList.remove("turq");
    }
});

document.querySelector("#comp_add").addEventListener("click", function(event){
    document.querySelector("#add_comp_select").classList.toggle("hidden");
    if (!document.querySelector("#remove_comp_select").classList.contains("hidden")){
        document.querySelector("#remove_comp_select").classList.toggle("hidden");
    }
});

document.querySelector("#comp_remove").addEventListener("click", function(event){
    document.querySelector("#remove_comp_select").classList.toggle("hidden");
    if (!document.querySelector("#add_comp_select").classList.contains("hidden")){
        document.querySelector("#add_comp_select").classList.toggle("hidden");
    }
});