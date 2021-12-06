let counter = 0;
document.addEventListener("click", function(event){
    // console.log(event);
    if (event.target.checked && event.target.localName == "input" && event.target.type != "submit") {
        event.target.parentElement.classList.add("turq");
        counter++;
        // console.log(counter);
        document.querySelector("#sub_counter").innerHTML = "Вибрано предметів: " + counter + "/9";
    }
    if (!event.target.checked && event.target.localName == "input" && event.target.type != "submit") {
        event.target.parentElement.classList.remove("turq");
        counter--;
        // console.log(counter);
        document.querySelector("#sub_counter").innerHTML = "Вибрано предметів: " + counter + "/9";
    }
    if (counter > 9){   // change to 9
        document.querySelector("#sub_counter").classList.remove("turq");
        document.querySelector("#sub_counter").classList.remove("grey");
        document.querySelector("#sub_counter").classList.add("red");
        // document.querySelector(".enter_opt").setAttribute("disabled", "disabled");
        document.querySelector(".enter_opt").setAttribute("disabled", "disabled");
    }
    else if (counter == 9){   // change to 9
        document.querySelector("#sub_counter").classList.remove("red");
        document.querySelector("#sub_counter").classList.remove("grey");
        document.querySelector("#sub_counter").classList.add("turq");
        document.querySelector(".enter_opt").removeAttribute("disabled");
    }
    else if (counter < 9){   // change to 9
        document.querySelector("#sub_counter").classList.remove("red");
        document.querySelector("#sub_counter").classList.remove("turq");
        document.querySelector("#sub_counter").classList.add("grey");
        document.querySelector(".enter_opt").setAttribute("disabled", "disabled");
    }
});
