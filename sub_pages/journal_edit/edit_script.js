document.querySelector("#add_btn_edit_task").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_edit_task").classList.toggle("hidden");
});

document.querySelector("#add_btn_del_task").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_del_task").classList.toggle("hidden");
});