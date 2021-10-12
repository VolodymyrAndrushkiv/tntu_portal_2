document.querySelector("#add_btn_add_ask").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_add_task").classList.toggle("hidden");
});

document.querySelector("#add_btn_edit_task").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_edit_task").classList.toggle("hidden");
});