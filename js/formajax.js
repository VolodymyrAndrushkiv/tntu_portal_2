document.querySelector('.subm_reg').onclick = (event)=>{
    event.preventDefault();

    let login    = document.querySelector('#login_reg').value;
    let firstName = document.querySelector('#first_name').value;
    let lastName = document.querySelector('#last_name').value;
    let pass     = document.querySelector('#pass_reg').value;
    let role     = document.querySelector('#enter_role').value;
    let error = false;

    if (login.length < 4 || !login.trim()){
        document.querySelector('#login_reg').style.boxShadow = "0px 0px 15px 0px rgb(102, 26, 33)";
        document.querySelector('#login_reg').style.transition = ".3s linear";
        error = true;
    }
    if (firstName.length === 0 || !firstName.trim() || firstName.length < 2){
        document.querySelector('#first_name').style.boxShadow = "0px 0px 15px 0px rgb(102, 26, 33)";
        document.querySelector('#first_name').style.transition = ".3s linear";
        error = true;
    }
    if (lastName.length === 0 || !lastName.trim() || lastName.length < 2){
        document.querySelector('#last_name').style.boxShadow = "0px 0px 15px 0px rgb(102, 26, 33)";
        document.querySelector('#last_name').style.transition = ".3s linear";
        error = true;
    }
    if (pass.length === 0 || !pass.trim() || pass.length < 4){
        document.querySelector('#pass_reg').style.boxShadow = "0px 0px 15px 0px rgb(102, 26, 33)";
        document.querySelector('#pass_reg').style.transition = ".3s linear";
        error = true;
    }

    if (!error){
        login1 = encodeURIComponent(login);
        firstName1 = encodeURIComponent(firstName);
        lastName1 = encodeURIComponent(lastName);
        pass1 = encodeURIComponent(pass);
        role1 = encodeURIComponent(role);

        let request = new XMLHttpRequest();
        request.onload = ()=>{
            console.log(request.response);
            localStorage.setItem('error', request.response);
        }
        request.open('POST', 'php/back.php');
        request.responseText = 'text';
        request.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        request.send('login='+login1+'&firstname='+firstName1+'&lastname='+lastName1+'&pass='+pass1+'&role='+role1);
        // window.location.href = "index.php";

        // document.querySelectorAll(".sub_block")[1].classList.toggle("hidden");
        // document.querySelectorAll(".sub_block")[2].classList.toggle("hidden");
        // if(localStorage.getItem('error')){
        //     // document.querySelector('#login_reg').value = localStorage.getItem('error');
        //     // localStorage.removeItem('error');
        //     alert("error");
        // }
        location.reload();
    }

    if (error) {
        document.querySelector('#login_reg').onfocus = function(){
            document.querySelector('#login_reg').style.boxShadow = "none";
            document.querySelector('#login_reg').style.transition = ".3s linear";
        };
        document.querySelector('#first_name').onfocus = function(){
            document.querySelector('#first_name').style.boxShadow = "none";
            document.querySelector('#first_name').style.transition = ".3s linear";
        };
        document.querySelector('#last_name').onfocus = function(){
            document.querySelector('#last_name').style.boxShadow = "none";
            document.querySelector('#last_name').style.transition = ".3s linear";
        };
        document.querySelector('#pass_reg').onfocus = function(){
            document.querySelector('#pass_reg').style.boxShadow = "none";
            document.querySelector('#pass_reg').style.transition = ".3s linear";
        };     
    }
    // if(localStorage.getItem('error')){
    //     document.querySelector('#login_reg').value = localStorage.getItem('error');
    //     // localStorage.removeItem('error');
    // }
    // else {
    //     window.location.href = "index.php";
    // }
    // window.location.href = "index.php";
    
}
// function storeg(){
//     if(localStorage.getItem('error')){
//         document.querySelector('#login_reg').value = localStorage.getItem('error');
//         // localStorage.removeItem('error');
//     }
// }

// storeg();


document.querySelector('#subm').onclick = (event)=>{
    event.preventDefault();
    let login = document.querySelector('#login');
    let pass = document.querySelector('#pass');
    let error = false;

    

}





