document.querySelector('#add_btn_to_rate').addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_to_rate").classList.toggle("hidden");
});

document.querySelector('#add_btn_del_rate').addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_del_rate").classList.toggle("hidden");
});

document.querySelector("#add_btn_add_ask").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_add_task").classList.toggle("hidden");
});

document.querySelector("#add_btn_edit_task").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_edit_task").classList.toggle("hidden");
});

document.querySelector("#add_btn_delete_task").addEventListener("click", function(event){
    event.preventDefault();
    document.querySelector("#add_form_delete_task").classList.toggle("hidden");
});