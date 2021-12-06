let arr = document.querySelectorAll(".tab_data");
// console.log(arr);
for (let i = 0; i < arr.length; i++){
    // console.log(arr[i].innerHTML.length);
    arr[i].setAttribute("title", arr[i].innerHTML);
    if (arr[i].innerHTML.length > 70) {
        arr[i].innerHTML = arr[i].innerHTML.slice(0, 80) + "...";
    }
}

document.addEventListener("click", function(event){
    // console.log(event.target.classList[1]);
    let td_arr = document.querySelectorAll(".tab_data");
    for (let i = 0; i < td_arr.length; i++){
        if (td_arr[i].classList.contains("turq")){
            console.log("true");
            td_arr[i].classList.remove("turq");
        }
    }
    
    let x = event.target.name.slice(event.target.name.length-1, event.target.name.length);
    let y = event.target.name.slice(event.target.name.length-3, event.target.name.length-2);
    
    let item_x = document.querySelector("#table_inp_" + y + "-0");
    let item_y = document.querySelector("#table_inp_0" + "-" + x);


    item_x.classList.add("turq");
    item_y.classList.add("turq");

});

document.querySelector(".close_result").addEventListener("click", function(event){
    document.querySelector(".opt_result").classList.add("hidden");
});

let res_text = document.querySelectorAll(".result_text");
for (let i = 0; i < res_text.length; i++){
    if (res_text[i].innerHTML == "Spent money") {
        res_text[i].innerHTML = "Витрачені кошти";
    }
    if (res_text[i].innerHTML == "Total hours") {
        res_text[i].innerHTML = "Всього годин";
    }
    if (res_text[i].innerHTML == "Vector credits") {
        res_text[i].innerHTML = "Вектор кредитів";
    }
    if (res_text[i].innerHTML == "Max effect") {
        res_text[i].innerHTML = "Максимальний ефект";
    }
    if (res_text[i].innerHTML == "Result") {
        res_text[i].innerHTML = "Результат";
    }
}